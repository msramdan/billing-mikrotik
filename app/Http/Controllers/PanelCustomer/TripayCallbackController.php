<?php

namespace App\Http\Controllers\PanelCustomer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Tagihan;
use App\Models\WaGateway;
use \RouterOS\Query;
use Illuminate\Support\Facades\DB;

class TripayCallbackController extends Controller
{

    public function handle(Request $request)
    {
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return Response::json([
                'success' => false,
                'message' => 'Unrecognized callback event, no action was taken',
            ]);
        }

        $data = json_decode($json);
        if (JSON_ERROR_NONE !== json_last_error()) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid data sent by tripay',
            ]);
        }

        $invoiceId = $data->merchant_ref;
        // $tripayReference = $data->reference;
        $status = strtoupper((string) $data->status);

        if ($data->is_closed_payment === 1) {
            $invoice = DB::table('tagihans')
                ->leftJoin('companies', 'tagihans.company_id', '=', 'companies.id')
                ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
                ->leftJoin('packages', 'pelanggans.paket_layanan', '=', 'packages.id')
                ->where('tagihans.no_tagihan', $invoiceId)
                ->where('tagihans.status_bayar', '=', 'Belum Bayar')
                ->select('tagihans.*','pelanggans.id as pelanggan_id','pelanggans.nama as nama_pelanggan', 'pelanggans.jatuh_tempo', 'pelanggans.email as email_customer', 'pelanggans.no_wa', 'packages.nama_layanan', 'pelanggans.no_layanan')
                ->first();

            $privateKey = $invoice->private_key;
            $signature = hash_hmac('sha256', $json, $privateKey);
            if ($signature !== (string) $callbackSignature) {
                return Response::json([
                    'success' => false,
                    'message' => 'Invalid signature',
                ]);
            }

            if (!$invoice) {
                return Response::json([
                    'success' => false,
                    'message' => 'No invoice found or already paid: ' . $invoiceId,
                ]);
            }

            switch ($status) {
                case 'PAID':
                    DB::table('invoices')
                        ->where('no_tagihan', $invoiceId)
                        ->update([
                            'status_bayar' => 'Sudah Bayar',
                            'payload_tripay' => $json,
                            'metode_bayar' => 'Payment Tripay',
                            'tanggal_bayar' => now(),
                            'tanggal_kirim_notif_wa' => now()
                        ]);
                    break;

                case 'EXPIRED':
                    DB::table('invoices')
                        ->where('no_tagihan', $invoiceId)
                        ->update([
                            'status_bayar' => 'Belum Bayar',
                            'payload_tripay' =>  $json
                        ]);
                    break;

                case 'FAILED':
                    DB::table('invoices')
                        ->where('no_tagihan', $invoiceId)
                        ->update([
                            'status_bayar' => 'Belum Bayar',
                            'payload_tripay' =>  $json,
                        ]);
                    break;
                default:
                    return Response::json([
                        'success' => false,
                        'message' => 'Unrecognized payment status',
                    ]);
            }

            if ($status == 'PAID') {
                // insert data pemasukan
                DB::table('pemasukans')->insert([
                    'nominal' => $invoice->nominal,
                    'company_id' => $invoice->company_id,
                    'tanggal' => date('Y-m-d H:i:s'),
                    'keterangan' => 'Pembayaran Tagihan no Tagihan ' . $invoice->no_tagihan . ' a/n ' . $invoice->nama_pelanggan . ' Periode ' . $invoice->periode,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                // set status jadi aktif handle klo kena isolir duluan dan tidak ada tagihan belum di bayar lain nya
                $cekTagihan = Tagihan::where('pelanggan_id', $invoice->pelanggan_id)
                    ->where('status_bayar', 'Belum Bayar')
                    ->count();
                if ($cekTagihan < 1) {
                    // buka isolir
                    $client = setRoute();
                    $pelanggan = DB::table('pelanggans')
                        ->leftJoin('packages', 'pelanggans.paket_layanan', '=', 'packages.id')
                        ->select(
                            'packages.profile',
                            'pelanggans.mode_user',
                            'pelanggans.user_pppoe',
                            'pelanggans.user_static',
                        )->where('pelanggans.id', $invoice->pelanggan_id)->first();
                    if ($pelanggan->mode_user == 'PPOE') {
                        $queryGet = (new Query('/ppp/secret/print'))
                            ->where('name', $pelanggan->user_pppoe);
                        $data = $client->query($queryGet)->read();
                        $idSecret = $data[0]['.id'];
                        // balikan paket
                        $comment = 'Isolir terbuka automatis : ' . date('Y-m-d H:i:s');
                        $queryComment = (new Query('/ppp/secret/set'))
                            ->equal('.id', $idSecret)
                            ->equal('profile', $pelanggan->profile)
                            ->equal('comment', $comment);
                        $client->query($queryComment)->read();
                        // get name
                        $queryGet = (new Query('/ppp/active/print'))
                            ->where('name', $pelanggan->user_pppoe);
                        $data = $client->query($queryGet)->read();
                        // remove session
                        $idActive = $data[0]['.id'];
                        $queryDelete = (new Query('/ppp/active/remove'))
                            ->equal('.id', $idActive);
                        $client->query($queryDelete)->read();
                    } else {
                        $client = setRoute();
                        // get ip by user static
                        $queryGet = (new Query('/queue/simple/print'))
                            ->where('name', $pelanggan->user_static);
                        $data = $client->query($queryGet)->read();
                        $ip = $data[0]['target'];
                        $parts = explode('/', $ip);
                        $fixIp = $parts[0];
                        // get id
                        $queryGet = (new Query('/ip/firewall/address-list/print'))
                            ->where('list', 'expired') // Filter by name
                            ->where('address', $fixIp);
                        $data = $client->query($queryGet)->read();
                        $idIP = $data[0]['.id'];
                        $queryRemove = (new Query('/ip/firewall/address-list/remove'))
                            ->equal('.id', $idIP);
                        $client->query($queryRemove)->read();
                    }

                    DB::table('pelanggans')
                        ->where('id', $invoice->pelanggan_id)
                        ->update(
                            [
                                'status_berlangganan' => 'Aktif',
                            ]
                        );
                }

                // kirim wa
                if ($invoice->is_active == 'Yes') {
                    sendNotifWa($invoice->url_wa_gateway, $invoice->api_key_wa_gateway, $invoice, 'bayar', $invoice->no_wa, $invoice->footer_pesan_wa_pembayaran);
                }
            }
            return Response::json(['success' => true]);
        }
    }
}

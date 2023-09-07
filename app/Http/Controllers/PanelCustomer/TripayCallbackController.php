<?php

namespace App\Http\Controllers\PanelCustomer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Tagihan;
use App\Models\WaGateway;
use Illuminate\Support\Facades\DB;

class TripayCallbackController extends Controller
{

    public function handle(Request $request)
    {
        $privateKey = getTripay()->private_key;
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $privateKey);

        if ($signature !== (string) $callbackSignature) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid signature',
            ]);
        }

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
        $tripayReference = $data->reference;
        $status = strtoupper((string) $data->status);

        if ($data->is_closed_payment === 1) {
            $invoice = Tagihan::where('no_tagihan', $invoiceId)
                // ->where('tripay_reference', $tripayReference)
                ->where('status_bayar', '=', 'Belum Bayar')
                ->first();
            if (!$invoice) {
                return Response::json([
                    'success' => false,
                    'message' => 'No invoice found or already paid: ' . $invoiceId,
                ]);
            }

            switch ($status) {
                case 'PAID':
                    $invoice->update([
                        'status_bayar' => 'Sudah Bayar',
                        'payload_tripay' => $json,
                        'metode_bayar' => 'Payment Tripay',
                        'tanggal_bayar' =>  date('Y-m-d H:i:s'),
                        'tanggal_kirim_notif_wa' =>  date('Y-m-d H:i:s')
                    ]);
                    break;

                case 'EXPIRED':
                    $invoice->update([
                        'status_bayar' => 'Belum Bayar',
                        'payload_tripay' =>  $json
                    ]);
                    break;

                case 'FAILED':
                    $invoice->update([
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
            // kirim wa
            $waGateway = WaGateway::findOrFail(1)->first();
            if ($waGateway->is_active == 'Yes') {
                $invoice = DB::table('tagihans')
                    ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
                    ->leftJoin('packages', 'pelanggans.paket_layanan', '=', 'packages.id')
                    ->select('tagihans.no_tagihan','tagihans.total_bayar as nominal','tagihans.metode_bayar', 'pelanggans.nama as nama_pelanggan', 'pelanggans.jatuh_tempo', 'pelanggans.email as email_customer', 'pelanggans.no_wa', 'packages.nama_layanan', 'pelanggans.no_layanan')
                    ->where('tagihans.no_tagihan', '=', $invoiceId)
                    ->first();

                sendNotifWa($waGateway->url, $waGateway->api_key, $invoice, 'bayar', $invoice->no_wa);
            }
            return Response::json(['success' => true]);
        }
    }
}

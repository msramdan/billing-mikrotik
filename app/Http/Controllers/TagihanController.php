<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Http\Requests\{StoreTagihanRequest, UpdateTagihanRequest};
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WaGateway;
use App\Models\Pelanggan;
use PDF;
use Auth;
use \RouterOS\Query;

class TagihanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tagihan view')->only('index', 'show');
        $this->middleware('permission:tagihan create')->only('create', 'store');
        $this->middleware('permission:tagihan edit')->only('edit', 'update');
        $this->middleware('permission:tagihan delete')->only('destroy');
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $pelanggans = intval($request->query('pelanggans'));
            $metode_bayar = $request->query('metode_bayar');
            $status_bayar = $request->query('status_bayar');
            $tanggal = $request->query('tanggal'); //2023-10
            $kirim_tagihan = $request->query('kirim_tagihan');

            $tagihans = DB::table('tagihans')
                ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
                ->leftJoin('users', 'tagihans.user_id', '=', 'users.id')
                ->where('tagihans.company_id', '=', session('sessionCompany'))
                ->select('tagihans.*', 'pelanggans.nama', 'pelanggans.no_layanan', 'pelanggans.id as pelanggan_id', 'users.name as nama_user');

            if (isset($tanggal) && !empty($tanggal)) {
                $tagihans = $tagihans->where('tagihans.periode', $tanggal);
            } else {
                $tagihans = $tagihans->where('tagihans.periode', date('Y-m'));
            }

            if (isset($pelanggans) && !empty($pelanggans)) {
                if ($pelanggans != 'All') {
                    $tagihans = $tagihans->where('tagihans.pelanggan_id', $pelanggans);
                }
            }

            if (isset($metode_bayar) && !empty($metode_bayar)) {
                if ($metode_bayar != 'All') {
                    $tagihans = $tagihans->where('tagihans.metode_bayar', $metode_bayar);
                }
            }

            if (isset($status_bayar) && !empty($status_bayar)) {
                if ($status_bayar != 'All') {
                    $tagihans = $tagihans->where('tagihans.status_bayar', $status_bayar);
                }
            }

            if (isset($kirim_tagihan) && !empty($kirim_tagihan)) {
                if ($kirim_tagihan != 'All') {
                    $tagihans = $tagihans->where('tagihans.is_send', $kirim_tagihan);
                }
            }

            $tagihans = $tagihans->orderBy('tagihans.id', 'DESC')->get();
            return DataTables::of($tagihans)
                ->addIndexColumn()
                ->addColumn('nominal_bayar', function ($row) {
                    return rupiah($row->nominal_bayar);
                })
                ->addColumn('potongan_bayar', function ($row) {
                    return rupiah($row->potongan_bayar);
                })
                ->addColumn('user', function ($row) {
                    if ($row->nama_user) {
                        return $row->nama_user;
                    } else {
                        return '-';
                    }
                })
                ->addColumn('total_bayar', function ($row) {
                    return rupiah($row->total_bayar);
                })
                ->addColumn('nominal_ppn', function ($row) {
                    return rupiah($row->nominal_ppn);
                })
                ->addColumn('pelanggan', function ($row) {
                    return $row->nama;
                })->addColumn('action', 'tagihans.include.action')
                ->toJson();
        }
        $thisMonth = date('Y-m');
        $pelanggans = DB::table('pelanggans')->where('company_id', '=', session('sessionCompany'))->get();

        $tanggal = $request->query('tanggal') ?? $thisMonth;
        $selectedPelanggan = $request->query('pelanggans') !== null ? intval($request->query('pelanggans')) : null;
        $selectedMetodeBayar = $request->query('metode_bayar') ?? null;
        $selectedStatusBayar = $request->query('status_bayar') ?? null;
        $isSend = $request->query('kirim_tagihan') ?? null;
        return view('tagihans.index', [
            'pelanggans' => $pelanggans,
            'tanggal' => $tanggal,
            'selectedPelanggan' => $selectedPelanggan,
            'selectedMetodeBayar' => $selectedMetodeBayar,
            'selectedStatusBayar' => $selectedStatusBayar,
            'isSend' => $isSend,
            'thisMonth' => $tanggal
        ]);
    }

    public function create()
    {
        return view('tagihans.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'no_tagihan' => 'required|string|max:50',
                'pelanggan_id' => 'required|exists:App\Models\Pelanggan,id',
                'nominal_bayar' => 'required|numeric',
                'potongan_bayar' => 'required|numeric',
                'total_bayar' => 'required|numeric',
                'periode' => 'required',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        if ($request->ppn == 'Yes') {
            $nominal_ppn =  0.11 * ($request->nominal_bayar - $request->potongan_bayar);
        } else {
            $nominal_ppn =  0;
        }

        DB::table('tagihans')->insert([
            'no_tagihan' => 'INV-SSL-' . $request->no_tagihan,
            'pelanggan_id' => $request->pelanggan_id,
            'nominal_bayar' => $request->nominal_bayar,
            'potongan_bayar' => $request->potongan_bayar,
            'total_bayar' => $request->total_bayar,
            'periode' => $request->periode,
            'company_id' => session('sessionCompany'),
            'ppn' => $request->ppn,
            'nominal_ppn' => $nominal_ppn,
            'status_bayar' => 'Belum Bayar',
            'is_send' => 'No',
            'tanggal_create_tagihan' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()
            ->route('tagihans.index')
            ->with('success', __('The tagihan was created successfully.'));
    }

    public function show(Tagihan $tagihan)
    {
        $tagihan = DB::table('tagihans')
            ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
            ->select('tagihans.*', 'pelanggans.nama')
            ->where('tagihans.id', '=', $tagihan->id)
            ->first();

        return view('tagihans.show', compact('tagihan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tagihan $tagihan)
    {
        $tagihan->load('pelanggan:id,coverage_area');

        return view('tagihans.edit', compact('tagihan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tagihan $tagihan)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'no_tagihan' => 'required|string|max:50',
                'pelanggan_id' => 'required|exists:App\Models\Pelanggan,id',
                'nominal_bayar' => 'required|numeric',
                'potongan_bayar' => 'required|numeric',
                'total_bayar' => 'required|numeric',
                'periode' => 'required',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        if ($request->ppn == 'Yes') {
            $nominal_ppn =  0.11 * ($request->nominal_bayar - $request->potongan_bayar);
        } else {
            $nominal_ppn =  0;
        }
        DB::table('tagihans')
            ->where('id', $tagihan->id)
            ->update(
                [
                    'no_tagihan' => 'INV-SSL-' . $request->no_tagihan,
                    'pelanggan_id' => $request->pelanggan_id,
                    'nominal_bayar' => $request->nominal_bayar,
                    'potongan_bayar' => $request->potongan_bayar,
                    'ppn' => $request->ppn,
                    'nominal_ppn' =>  $nominal_ppn,
                    'total_bayar' => $request->total_bayar,
                    'periode' => $request->periode,
                    'status_bayar' => 'Belum Bayar',
                ]
            );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        return redirect()
            ->route('tagihans.index')
            ->with('success', __('The tagihan was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tagihan $tagihan)
    {
        try {
            $tagihan->delete();

            return redirect()
                ->route('tagihans.index')
                ->with('success', __('The tagihan was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('tagihans.index')
                ->with('error', __("The tagihan can't be deleted because it's related to another table."));
        }
    }

    public function invoice($id)
    {
        $data = DB::table('tagihans')
            ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
            ->leftJoin('packages', 'pelanggans.paket_layanan', '=', 'packages.id')
            ->select('tagihans.*', 'pelanggans.nama', 'pelanggans.jatuh_tempo', 'pelanggans.email as email_customer', 'pelanggans.alamat as alamat_customer', 'packages.nama_layanan', 'pelanggans.no_layanan')
            ->where('tagihans.id', '=', $id)
            ->first();
        $pdf = PDF::loadView('tagihans.pdf', compact('data'));
        // return $pdf->download('Invoice.pdf');
        return $pdf->stream();
    }

    public function sendTagihanWa($tagihan_id)
    {
        $waGateway = getCompany();
        $tagihans = DB::table('tagihans')
            ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
            ->select('tagihans.*', 'pelanggans.nama', 'pelanggans.no_wa', 'pelanggans.no_layanan', 'pelanggans.jatuh_tempo')
            ->where('tagihans.id', '=', $tagihan_id)->first();
        if ($waGateway->is_active == 'Yes') {
            try {
                $res = sendNotifWa(
                    $waGateway->url_wa_gateway,
                    $waGateway->api_key_wa_gateway,
                    $tagihans,
                    'tagihan',
                    $tagihans->no_wa,
                    $waGateway->footer_pesan_wa_tagihan
                );
                if ($res->status == true || $res->status == 'true') {
                    // update
                    DB::table('tagihans')
                        ->where('tagihans.id', $tagihan_id)
                        ->update(['is_send' => 'Yes']);
                    return redirect()
                        ->route('tagihans.index')
                        ->with('success', __('Kirim notifikasi tagihan berhasil'));
                } else {
                    return redirect()
                        ->route('tagihans.index')
                        ->with('error', __('Kirim notifikasi tagihan gagal ') . $res->message);
                }
            } catch (\Exception $e) {
                echo 'Caught exception: ', $e->getMessage(), "\n";
            }
        } else {
            return redirect()
                ->route('tagihans.index')
                ->with('error', __('Setting is active wa Off'));
        }
    }

    public function sendAll()
    {
        // get semua tagihan belum bayar
        $tagihans = DB::table('tagihans')
            ->select('tagihans.*')
            ->where('tagihans.status_bayar', '=', 'Belum Bayar')->get();
        $waGateway = getCompany();
        foreach ($tagihans as $row) {
            try {
                if ($waGateway->is_active == 'Yes') {
                    $req = DB::table('tagihans')
                        ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
                        ->select('tagihans.*', 'pelanggans.nama', 'pelanggans.no_wa', 'pelanggans.no_layanan', 'pelanggans.jatuh_tempo')
                        ->where('tagihans.id', '=', $row->id)->first();
                    sendNotifWa($waGateway->url_wa_gateway, $waGateway->api_key_wa_gateway, $req, 'tagihan', $req->no_wa, $waGateway->footer_pesan_wa_tagihan);
                }
            } catch (\Exception $e) {
                continue;
            }
        }
        return redirect()
            ->route('tagihans.index')
            ->with('success', __('Kirim notifikasi ke semua pelanggan berhasil'));
    }

    public function bayarTagihan(Request $request)
    {
        $tgl = date('Y-m-d H:i:s');
        // update tagihan
        if ($request->metode_bayar == 'Cash' || $request->metode_bayar == 'Transfer Bank') {
            $updateData = [
                'tanggal_bayar' => $tgl,
                'metode_bayar' => $request->metode_bayar,
                'status_bayar' => 'Sudah Bayar',
                'tanggal_kirim_notif_wa' => $tgl,
                'user_id' => Auth::user()->id
            ];

            if ($request->metode_bayar == 'Transfer Bank') {
                $updateData['bank_account_id'] = $request->bank_account_id;
            }

            DB::table('tagihans')
                ->where('id', $request->tagihan_id)
                ->update($updateData);
        } else {
            dd('Error metode bayar');
        }

        // insert pemasukan
        DB::table('pemasukans')->insert([
            'nominal' => $request->nominal,
            'tanggal' => $tgl,
            'company_id' =>  session('sessionCompany'),
            'category_pemasukan_id' => 1,
            'keterangan' => 'Pembayaran Tagihan no Tagihan ' . $request->no_tagihan . ' a/n ' . $request->nama_pelanggan . ' Periode ' . $request->periode_waktu,
            'referense_id' => $request->tagihan_id,
            'created_at' => $tgl,
            'updated_at' => $tgl,
        ]);

        // set status jadi aktif handle klo kena isolir duluan dan tidak ada tagihan belum di bayar lain nya
        $cekTagihan = Tagihan::where('pelanggan_id', $request->pelanggan_id)
            ->where('status_bayar', 'Belum Bayar')
            ->count();
        if ($cekTagihan < 1) {
            $pelanggan = DB::table('pelanggans')
                ->leftJoin('packages', 'pelanggans.paket_layanan', '=', 'packages.id')
                ->select(
                    'packages.profile',
                    'pelanggans.mode_user',
                    'pelanggans.user_pppoe',
                    'pelanggans.user_static',
                    'pelanggans.status_berlangganan',
                )->where('pelanggans.id', $request->pelanggan_id)->first();
            if ($pelanggan->mode_user == 'PPOE') {
                // cek ter isolir dulu
                if ($pelanggan->status_berlangganan == 'Non Aktif') {
                    // buka isolir
                    $client = setRoute();
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
                    if ($data) {
                        // remove session
                        $idActive = $data[0]['.id'];
                        $queryDelete = (new Query('/ppp/active/remove'))
                            ->equal('.id', $idActive);
                        $client->query($queryDelete)->read();
                    }
                }
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

                if (isset($data[0]['.id'])) {
                    $idIP = $data[0]['.id'];
                    $queryRemove = (new Query('/ip/firewall/address-list/remove'))
                        ->equal('.id', $idIP);
                    $client->query($queryRemove)->read();
                }
            }
            DB::table('pelanggans')
                ->where('id', $request->pelanggan_id)
                ->update(
                    [
                        'status_berlangganan' => 'Aktif',
                    ]
                );
        }
        // id jika notif Yes kirim
        if ($request->notif == 'Yes') {
            $waGateway = getCompany();
            $pelanggan = Pelanggan::findOrFail($request->pelanggan_id);
            if ($waGateway->is_active == 'Yes') {
                sendNotifWa($waGateway->url_wa_gateway, $waGateway->api_key_wa_gateway, $request, 'bayar', $pelanggan->no_wa, $waGateway->footer_pesan_wa_pembayaran);
            }
        }
        return redirect()
            ->route('tagihans.index')
            ->with('success', __('Pembayran berhasil dilakukan'));
    }
}

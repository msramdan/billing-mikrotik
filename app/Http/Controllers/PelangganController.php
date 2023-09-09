<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Http\Requests\{StorePelangganRequest, UpdatePelangganRequest};
use Yajra\DataTables\Facades\DataTables;
use Image;
use Illuminate\Support\Facades\DB;
use App\Models\AreaCoverage;
use App\Models\Package;
use App\Models\Settingmikrotik;
use Illuminate\Http\Request;
use \RouterOS\Query;
use \RouterOS\Client;
use \RouterOS\Exceptions\ConnectException;

class PelangganController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pelanggan view')->only('index', 'show');
        $this->middleware('permission:pelanggan create')->only('create', 'store');
        $this->middleware('permission:pelanggan edit')->only('edit', 'update');
        $this->middleware('permission:pelanggan delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $area_coverage = intval($request->query('area_coverage'));
            $packagePilihan = intval($request->query('packagePilihan'));
            $mikrotik = intval($request->query('mikrotik'));
            $status = $request->query('status');

            $pelanggans = DB::table('pelanggans')
                ->leftJoin('area_coverages', 'pelanggans.coverage_area', '=', 'area_coverages.id')
                ->leftJoin('odcs', 'pelanggans.odc', '=', 'odcs.id')
                ->leftJoin('odps', 'pelanggans.odp', '=', 'odps.id')
                ->leftJoin('packages', 'pelanggans.paket_layanan', '=', 'packages.id')
                ->leftJoin('settingmikrotiks', 'pelanggans.router', '=', 'settingmikrotiks.id')
                ->select(
                    'pelanggans.*',
                    'area_coverages.kode_area',
                    'area_coverages.nama as nama_area',
                    'odcs.kode_odc',
                    'odps.kode_odp',
                    'packages.nama_layanan',
                    'packages.harga',
                    'settingmikrotiks.identitas_router'
                );

            if (isset($area_coverage) && !empty($area_coverage)) {
                if ($area_coverage != 'All') {
                    $pelanggans = $pelanggans->where('pelanggans.coverage_area', $area_coverage);
                }
            }

            if (isset($packagePilihan) && !empty($packagePilihan)) {
                if ($packagePilihan != 'All') {
                    $pelanggans = $pelanggans->where('pelanggans.paket_layanan', $packagePilihan);
                }
            }

            if (isset($mikrotik) && !empty($mikrotik)) {
                if ($mikrotik != 'All') {
                    $pelanggans = $pelanggans->where('pelanggans.router', $mikrotik);
                }
            }

            if (isset($status) && !empty($status)) {
                if ($status != 'All') {
                    $pelanggans = $pelanggans->where('pelanggans.status_berlangganan', $status);
                }
            }

            $pelanggans = $pelanggans->orderBy('pelanggans.id', 'DESC')->get();
            return Datatables::of($pelanggans)
                ->addIndexColumn()
                ->addColumn('alamat', function ($row) {
                    return str($row->alamat)->limit(100);
                })
                ->addColumn('area_coverage', function ($row) {
                    return $row->kode_area . '-' . $row->nama_area;
                })->addColumn('odc', function ($row) {
                    return $row->kode_odc;
                })->addColumn('odp', function ($row) {
                    return $row->kode_odp;
                })->addColumn('package', function ($row) {
                    return $row->nama_layanan . '-' . $row->harga;
                })->addColumn('settingmikrotik', function ($row) {
                    return $row->identitas_router;
                })
                ->addColumn('action', 'pelanggans.include.action')
                ->toJson();
        }
        $areaCoverages = AreaCoverage::all();
        $package = Package::all();
        $router = Settingmikrotik::all();
        return view('pelanggans.index', [
            'areaCoverages' => $areaCoverages,
            'package' => $package,
            'router' => $router
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pelanggans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePelangganRequest $request)
    {
        $attr = $request->validated();

        $attr['password'] = bcrypt($request->password);

        if ($request->file('photo_ktp') && $request->file('photo_ktp')->isValid()) {

            $path = storage_path('app/public/uploads/photo_ktps/');
            $filename = $request->file('photo_ktp')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('photo_ktp')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            $attr['photo_ktp'] = $filename;
        }

        Pelanggan::create($attr);

        return redirect()
            ->route('pelanggans.index')
            ->with('success', __('The pelanggan was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pelanggan $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show(Pelanggan $pelanggan)
    {
        $pelanggan = DB::table('pelanggans')
            ->leftJoin('area_coverages', 'pelanggans.coverage_area', '=', 'area_coverages.id')
            ->leftJoin('odcs', 'pelanggans.odc', '=', 'odcs.id')
            ->leftJoin('odps', 'pelanggans.odp', '=', 'odps.id')
            ->leftJoin('packages', 'pelanggans.paket_layanan', '=', 'packages.id')
            ->leftJoin('settingmikrotiks', 'pelanggans.router', '=', 'settingmikrotiks.id')
            ->select(
                'pelanggans.*',
                'area_coverages.kode_area',
                'area_coverages.nama as nama_area',
                'odcs.kode_odc',
                'odps.kode_odp',
                'packages.nama_layanan',
                'packages.harga',
                'settingmikrotiks.identitas_router'
            )->where('pelanggans.id', $pelanggan->id)->first();;

        return view('pelanggans.show', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pelanggan $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelanggan $pelanggan)
    {
        $pelanggan->load('area_coverage:id,kode_area', 'odc:id,kode_odc', 'odp:id,kode_odc', 'package:id,nama_layanan', 'settingmikrotik:id,identitas_router');
        $dataOdcs = DB::table('odcs')->where('wilayah_odc',  $pelanggan->coverage_area)->get();
        $dataodps = DB::table('odps')->where('kode_odc',  $pelanggan->odc)->get();
        $dataPort = DB::table('odps')->where('id', $pelanggan->odp)->first();
        $array = [];
        if ($dataPort) {
            $jmlPort = $dataPort->jumlah_port;
            for ($x = 1; $x <=  $jmlPort; $x++) {
                // find customer
                $cek = DB::table('pelanggans')
                    ->where('odp', $pelanggan->odp)
                    ->where('no_port_odp', $x)
                    ->first();
                if ($cek) {
                    $array[$x] = $cek->no_layanan . ' - ' . $cek->nama;
                } else {
                    $array[$x] = 'Kosong';
                }
            }
        }
        $router = DB::table('settingmikrotiks')->where('id', $pelanggan->router)->first();

        if ($router) {
            try {
                $client = new Client([
                    'host' => $router->host,
                    'user' => $router->username,
                    'pass' => $router->password,
                    'port' => $router->port,
                ]);
            } catch (ConnectException $e) {
                echo $e->getMessage() . PHP_EOL;
                die();
            }
            $query = new Query('/ppp/secret/print');
            $secretPPoe = $client->query($query)->read();
        } else {
            $secretPPoe = [];
        }
        return view('pelanggans.edit', compact('pelanggan', 'dataOdcs', 'dataodps', 'array', 'secretPPoe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pelanggan $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePelangganRequest $request, Pelanggan $pelanggan)
    {
        $attr = $request->validated();


        switch (is_null($request->password)) {
            case true:
                unset($attr['password']);
                break;
            default:
                $attr['password'] = bcrypt($request->password);
                break;
        }

        if ($request->file('photo_ktp') && $request->file('photo_ktp')->isValid()) {

            $path = storage_path('app/public/uploads/photo_ktps/');
            $filename = $request->file('photo_ktp')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('photo_ktp')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            // delete old photo_ktp from storage
            if ($pelanggan->photo_ktp != null && file_exists($path . $pelanggan->photo_ktp)) {
                unlink($path . $pelanggan->photo_ktp);
            }

            $attr['photo_ktp'] = $filename;
        }

        $pelanggan->update($attr);

        return redirect()
            ->route('pelanggans.index')
            ->with('success', __('The pelanggan was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pelanggan $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pelanggan $pelanggan)
    {
        try {
            $path = storage_path('app/public/uploads/photo_ktps/');

            if ($pelanggan->photo_ktp != null && file_exists($path . $pelanggan->photo_ktp)) {
                unlink($path . $pelanggan->photo_ktp);
            }

            $pelanggan->delete();

            return redirect()
                ->route('pelanggans.index')
                ->with('success', __('The pelanggan was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('pelanggans.index')
                ->with('error', __("The pelanggan can't be deleted because it's related to another table."));
        }
    }

    public function setToExpired($user_pppoe)
    {
        $client = setRoute();
        $queryGet = (new Query('/ppp/secret/print'))
            ->where('name', $user_pppoe);
        $data = $client->query($queryGet)->read();
        $idSecret = $data[0]['.id'];
        // set komen
        $comment = 'Di set expired Tanggal : ' . date('Y-m-d H:i:s');
        $queryComment = (new Query('/ppp/secret/set'))
            ->equal('.id', $idSecret)
            ->equal('profile', 'EXPIRED')
            ->equal('comment', $comment);
        $client->query($queryComment)->read();
        // get name from active ppp
        $queryGet = (new Query('/ppp/active/print'))
            ->where('name', $user_pppoe);
        $dataActive = $client->query($queryGet)->read();
        // remove session
        $idActive = $dataActive[0]['.id'];
        $queryDelete = (new Query('/ppp/active/remove'))
            ->equal('.id', $idActive);
        $client->query($queryDelete)->read();
        return redirect()
            ->route('pelanggans.index')
            ->with('success', __('Internet pelanggan berhasil di set Expired'));
    }

    public function setNonToExpired($user_pppoe)
    {
        $client = setRoute();
        // set komen
        $queryGet = (new Query('/ppp/secret/print'))
            ->where('name', $user_pppoe);
        $data = $client->query($queryGet)->read();
        $idSecret = $data[0]['.id'];
        // balikan paket
        $comment = 'Di set tidak expired Tanggal : ' . date('Y-m-d H:i:s');
        $queryComment = (new Query('/ppp/secret/set'))
            ->equal('.id', $idSecret)
            ->equal('profile', 'EXPIRED')
            ->equal('comment', $comment);
        $client->query($queryComment)->read();
        // get name
        $queryGet = (new Query('/ppp/active/print'))
            ->where('name', $user_pppoe);
        $data = $client->query($queryGet)->read();
        // remove session
        $idActive = $data[0]['.id'];
        $queryDelete = (new Query('/ppp/active/remove'))
            ->equal('.id', $idActive);
        $client->query($queryDelete)->read();
        return redirect()
            ->route('pelanggans.index')
            ->with('success', __('Internet pelanggan berhasil di set Tidak Expired'));
    }

}

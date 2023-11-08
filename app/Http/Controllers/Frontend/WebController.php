<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Pelanggan;
use App\Models\Package;
use App\Models\WaGateway;
use App\Models\User;
use Image;
use Illuminate\Support\Facades\Http;

class WebController extends Controller
{
    public function index()
    {
        $packages = DB::table('packages')
            ->where('is_active', 'Yes')
            ->orderBy('harga', 'asc')
            ->get();
        $packages = DB::table('packages')
            ->where('is_active', 'Yes')
            ->orderBy('harga', 'asc')
            ->get();
        return view('frontend.index', [
            'packages' => $packages,
        ]);
    }

    public function loginClient()
    {
        return view('frontend.login');
    }

    public function submitLogin(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'email' => "required|email",
                'password' => 'required|string',
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        $email = $request->email;
        $password = $request->password;
        $data = Pelanggan::where('email', $email)->first();
        if ($data) {
            if ($data->status_berlangganan != 'Menunggu') {
                if (Hash::check($password, $data->password)) {
                    Session::put('id-customer', $data->id);
                    Session::put('login-customer', TRUE);
                    Alert::success('Success', 'Login Berhasil');
                    return redirect()->route('dashboardCustomer');
                } else {
                    Alert::error('Failed', 'Password anda salah!');
                    return redirect()->back()->withInput($request->all())->withErrors($validator);
                }
            } else {
                Alert::error('Failed', 'Akun sedang di verifikasi / non aktif silahkan hubungi admin');
                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }
        } else {
            Alert::error('Failed', 'Email tidak terdaftar!');
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
    }

    public function logoutCustomer(Request $request)
    {
        $request->session()->forget('id-customer');
        Alert::success('Success', 'Anda telah logout');
        return redirect()->route('dashboard');
    }

    public function registerClient()
    {
        if (getCompany()->jumlah_pelanggan == 0) {
            $paket = DB::table('packages')->where('is_active', 'Yes')->get();
            return view('frontend.register', [
                'paket' => $paket
            ]);
        } else {
            if (hitungPelanggan() >= getCompany()->jumlah_pelanggan) {
                Alert::error('Limit Router', 'Akun terkena limit pelanggan silahkan hubungi admin aplikasi');
                return redirect()
                    ->route('website');
            } else {
                $paket = DB::table('packages')->where('is_active', 'Yes')->get();
                return view('frontend.register', [
                    'paket' => $paket
                ]);
            }
        }
    }

    public function submitRegister(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|string',
                'email' => 'required|email|unique:pelanggans,email',
                'no_wa' => 'required|string|max:15|phone_number',
                'no_ktp' => 'required|string|max:50',
                'alamat' => 'required|string',
                'password' => 'required',
                'paket_layanan' => 'required|exists:App\Models\Package,id',
                'photo_ktp' => 'image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'no_wa.phone_number'    => 'Harus diawali dengan 62, Cth : 6283874731480',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        try {
            $path = storage_path('app/public/uploads/photo_ktps/');
            $filename = $request->file('photo_ktp')->hashName();
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            Image::make($request->file('photo_ktp')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            $customer = DB::table('pelanggans')->insert([
                'nama' => $request->nama,
                'email' => $request->email,
                'no_wa' => $request->no_wa,
                'no_ktp' => $request->no_ktp,
                'photo_ktp' => $filename,
                'alamat' => $request->alamat,
                'password' => bcrypt($request->password),
                'status_berlangganan' => 'Menunggu',
                'paket_layanan' => $request->paket_layanan,
                'kirim_tagihan_wa' => 'No',
                'tanggal_daftar' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            if ($customer) {
                $waGateway = WaGateway::findOrFail(1);
                if ($waGateway->is_active == 'Yes') {
                    // kirim notif wa ke user
                    $listUser = User::where('kirim_notif_wa', 'Yes')
                        ->get();
                    $url = $waGateway->url. 'send-message';
                    foreach ($listUser as $row) {
                        try {
                            $paket = Package::findOrFail($request->paket_layanan)->first();
                            $customer = Pelanggan::where('email', $request->email)->firstOrFail();
                            $url_detail = url('/pelanggans/' . $customer->id);
                            $message = 'Hello. admin ' . getCompany()->nama_perusahaan . "\n\n";
                            $message .= "Ada calon customer baru yang melakukan pendaftaran \n\n";
                            $message .= "*Nama :* " . $request->nama . "\n";
                            $message .= '*Email :* ' . $request->email . "\n";
                            $message .= '*No Wa :* ' . $request->no_wa . "\n";
                            $message .= '*No KTP :* ' .  $request->no_ktp . " \n";
                            $message .= '*Alamat :* ' .  $request->alamat . "\n";
                            $message .= '*Paket pilihan :* ' . $paket->nama_layanan . "\n\n";
                            $message .= "Detail pendaftaran bisa admin lihat disini : $url_detail \n\n";

                            $data = array(
                                'api_key'  => $waGateway->api_key,
                                'receiver' => $row->no_wa,
                                'data'     => [
                                    'message' => $message,
                                ],
                            );
                            $body = json_encode($data);
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $result = curl_exec($ch);
                            curl_close($ch);
                            print_r($result);
                        } catch (Throwable $t) {
                            continue;
                        }
                    }
                }
            }
        } catch (\Exception $e) {

            return $e->getMessage();
        }
        Alert::success('Daftar akun berhasil', 'Data sedang kami verifikasi untuk info lebih lanjut akan kami hubungi secepatnya');
        return redirect()->back();
    }

    public function cekTagihan(Request $request)
    {
        if ($request->no_tagihan != null) {
            $no_tagihan = $request->no_tagihan;
        } else {
            $no_tagihan = '';
        }
        $metodeBayar = [];
        $tagihan = DB::table('tagihans')
            ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
            ->select('tagihans.*', 'pelanggans.nama')
            ->where('tagihans.no_tagihan', '=', $no_tagihan)
            ->first();
        if ($tagihan) {
            if ($tagihan->status_bayar == 'Belum Bayar') {
                $url =  getTripay()->url . 'merchant/payment-channel';
                $api_key = getTripay()->api_key;
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $api_key
                ])->get($url);
                $a = json_decode($response->getBody());

                if ($a->success == true) {
                    $metodeBayar = $a->data;
                } else {
                    echo $a->message;
                    die();
                }
            }
        }
        return view('frontend.tagihan', [
            'no_tagihan' => $no_tagihan,
            'tagihan' => $tagihan,
            'metodeBayar' => $metodeBayar,
        ]);
    }

    public function areaCoverage()
    {
        $areaCoverages = DB::table('area_coverages')->get();
        return view('frontend.coverage', [
            'areaCoverages' => $areaCoverages
        ]);
    }

    public function speedTest()
    {
        return view('frontend.speed');
    }

    public function bayar($tagihan_id, $method)
    {
        $tagihans = DB::table('tagihans')
            ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
            ->leftJoin('packages', 'pelanggans.paket_layanan', '=', 'packages.id')
            ->select('tagihans.*', 'pelanggans.nama', 'pelanggans.jatuh_tempo', 'pelanggans.email as email_customer', 'pelanggans.no_wa', 'packages.nama_layanan', 'pelanggans.no_layanan')
            ->where('tagihans.id', '=', $tagihan_id)
            ->first();
        $apiKey       = getTripay()->api_key;
        $privateKey   = getTripay()->private_key;
        $merchantCode = getTripay()->kode_merchant;
        $merchantRef  = $tagihans->no_tagihan;
        $url = getTripay()->url . 'transaction/create';
        $amount       =  $tagihans->total_bayar;
        $data = [
            'method'         => $method,
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => $tagihans->nama,
            'customer_email' => $tagihans->email_customer,
            'customer_phone' => $tagihans->no_wa,
            'order_items'    => [
                [
                    'sku'         => 'Internet ' . getCompany()->nama_perusahaan,
                    'name'        => 'Pembayaran Internet',
                    'price'       => $tagihans->total_bayar,
                    'quantity'    => 1,
                    'product_url' => '',
                    'image_url'   => '',
                ]
            ],
            'expired_time' => (time() + (1 * 5 * 60)),
            'signature'    => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
        ];
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        $response = json_decode($response)->data;
        return redirect()->route('detailBayar', [
            'id' => $response->reference
        ]);
    }
    public function detailBayar($reference)
    {
        $apiKey = getTripay()->api_key;
        $payload = ['reference'    => $reference];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => getTripay()->url . 'transaction/detail?' . http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response)->data;

        return view('frontend.detailBayar', [
            'detail' => $response
        ]);
    }
}

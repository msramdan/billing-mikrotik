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
use Image;

class WebController extends Controller
{
    public function index()
    {
        return view('frontend.index');
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
            if($data->status_berlangganan !='Menungu'){
                if (Hash::check($password, $data->password)) {
                    Session::put('id-customer', $data->id);
                    Session::put('login-customer', TRUE);
                    Alert::success('Success', 'Login Berhasil');
                    return redirect()->route('dashboardCustomer');
                } else {
                    Alert::error('Failed', 'Email atau Password anda salah!');
                    return redirect()->back()->withInput($request->all())->withErrors($validator);
                }
            }else{
                Alert::error('Failed', 'Akun sedang di verifikasi / non aktif silahkan hubungi admin');
                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }

        } else {
            Alert::error('Failed', 'Email atau Password anda salah!');
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
        $paket = DB::table('packages')->get();
        return view('frontend.register', [
            'paket' => $paket
        ]);
    }

    public function submitRegister(Request $request,)
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

            DB::table('pelanggans')->insert([
                'nama' => $request->nama,
                'email' => $request->email,
                'no_wa' => $request->no_wa,
                'no_ktp' => $request->no_ktp,
                'photo_ktp' => $filename,
                'alamat' => $request->alamat,
                'password' => bcrypt($request->password),
                'status_berlangganan' => 'Menungu',
                'paket_layanan' => $request->paket_layanan,
                'kirim_tagihan_wa' => 'No',
                'tanggal_daftar' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
        Alert::success('Daftar akun berhasil', 'Data sedang kami verifikasi untuk info lebih lanjut akan kami hubungi secepatnya');
        return redirect()->back();
    }

    public function cekTagihan()
    {
        return view('frontend.tagihan');
    }

    public function areaCoverage()
    {
        return view('frontend.coverage');
    }

    public function speedTest()
    {
        return view('frontend.speed');
    }
}

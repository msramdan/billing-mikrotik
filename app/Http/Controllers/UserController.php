<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreUserRequest, UpdateUserRequest};
use App\Models\Company;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Image;

class UserController extends Controller
{
    /**
     * Path for user avatar file.
     *
     * @var string
     */
    protected $avatarPath = '/uploads/images/avatars/';

    public function __construct()
    {
        $this->middleware('permission:user view')->only('index', 'show');
        $this->middleware('permission:user create')->only('create', 'store');
        $this->middleware('permission:user edit')->only('edit', 'update');
        $this->middleware('permission:user delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = User::with('roles:id,name');

            return Datatables::of($users)
                ->addColumn('action', 'users.include.action')
                ->addColumn('role', function ($row) {
                    return $row->getRoleNames()->toArray() !== [] ? $row->getRoleNames()[0] : '-';
                })
                ->addColumn('avatar', function ($row) {
                    if ($row->avatar == null) {
                        return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($row->email))) . '&s=500';
                    }
                    return asset($this->avatarPath . $row->avatar);
                })
                ->toJson();
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::orderBy('nama_perusahaan', 'ASC')->get();
        return view('users.create', [
            'companies' => $companies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'min:3', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'avatar' => ['nullable', 'image', 'max:1024'],
                'role' => ['required', 'exists:roles,id'],
                'no_wa' => 'required|string|max:15|phone_number',
                'kirim_notif_wa' => 'required|in:Yes,No',
                'companies' => 'required',
                'password' =>  [
                    'required',
                    'confirmed'
                ]
            ],
            [
                'no_wa.phone_number'    => 'Harus diawali dengan 62, Cth : 6283874731480',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        if ($request->file('avatar') && $request->file('avatar')->isValid()) {

            $filename = $request->file('avatar')->hashName();

            if (!file_exists($folder = public_path($this->avatarPath))) {
                mkdir($folder, 0777, true);
            }

            Image::make($request->file('avatar')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path($this->avatarPath) . $filename);

            $attr['avatar'] = $filename;
        }

        $attr['name'] = $request->name;
        $attr['email'] = $request->email;
        $attr['no_wa'] = $request->no_wa;
        $attr['kirim_notif_wa'] = $request->kirim_notif_wa;
        $attr['password'] = bcrypt($request->password);
        $user = User::create($attr);
        if ($user) {
            $user->assignRole($request->role);
            $companies = $request->companies;
            if (isset($companies)) {
                foreach ($companies as $value) {
                    DB::table('assign_company')->insert([
                        'company_id' => $value,
                        'user_id' => $user->id
                    ]);
                }
            }
        }

        return redirect()
            ->route('users.index')
            ->with('success', __('The user was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('roles:id,name');

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->load('roles:id,name');

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'min:3', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email,' . $user->id],
                'avatar' => ['nullable', 'image', 'max:1024'],
                'role' => ['required', 'exists:roles,id'],
                'no_wa' => 'required|string|max:15|phone_number',
                'kirim_notif_wa' => 'required|in:Yes,No',
                'password' =>  [
                    'nullable',
                    'confirmed'
                ]
            ],
            [
                'no_wa.phone_number'    => 'Harus diawali dengan 62, Cth : 6283874731480',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        if ($request->file('avatar') && $request->file('avatar')->isValid()) {

            $filename = $request->file('avatar')->hashName();

            // if folder dont exist, then create folder
            if (!file_exists($folder = public_path($this->avatarPath))) {
                mkdir($folder, 0777, true);
            }

            // Intervention Image
            Image::make($request->file('avatar')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path($this->avatarPath) . $filename);

            // delete old avatar from storage
            if ($user->avatar != null && file_exists($oldAvatar = public_path($this->avatarPath .
                $user->avatar))) {
                unlink($oldAvatar);
            }

            $attr['avatar'] = $filename;
        } else {
            $attr['avatar'] = $user->avatar;
        }

        $attr['name'] = $request->name;
        $attr['email'] = $request->email;
        $attr['no_wa'] = $request->no_wa;
        $attr['kirim_notif_wa'] = $request->kirim_notif_wa;

        switch (is_null($request->password)) {
            case true:
                unset($attr['password']);
                break;
            default:
                $attr['password'] = bcrypt($request->password);
                break;
        }

        $user->update($attr);

        $user->syncRoles($request->role);

        return redirect()
            ->route('users.index')
            ->with('success', __('The user was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->avatar != null && file_exists($oldAvatar = public_path($this->avatarPath . $user->avatar))) {
            unlink($oldAvatar);
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', __('The user was deleted successfully.'));
    }
}

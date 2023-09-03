<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ getCompany()->nama_perusahaan }}</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/admin') }}/dist/css/adminlte.min.css">
    <link rel="icon"
        @if (getCompany()->favicon != null) href="{{ Storage::url('public/uploads/favicons/') . getCompany()->favicon }}" @endif
        type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('frontend/admin') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
        href="{{ asset('frontend/admin') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/admin') }}/dist/css/adminlte.min.css">
</head>

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>Sawit</b>SkyLink</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Daftar customer baru</p>
                <form action="{{ route('submitRegister') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    @error('nama')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="text" class="form-control @error('nama') is-invalid @enderror"  placeholder="Nama Lengkap" name="nama" value="{{ old('nama') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-user" style="width: 15px"></span>
                            </div>
                        </div>
                    </div>

                    @error('email')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror"  placeholder="Email" name="email"  value="{{ old('email') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-envelope" style="width: 15px"></span>
                            </div>
                        </div>
                    </div>

                    @error('no_wa')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="number" class="form-control @error('no_wa') is-invalid @enderror"  placeholder="No Wa (Awali dengan 62)" name="no_wa"  value="{{ old('no_wa') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-whatsapp" style="width: 15px"></span>
                            </div>
                        </div>
                    </div>

                    @error('no_ktp')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="number" class="form-control @error('no_ktp') is-invalid @enderror"  placeholder="No KTP" name="no_ktp" value="{{ old('no_ktp') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-address-card" style="width: 15px"></span>
                            </div>
                        </div>
                    </div>

                    @error('photo_ktp')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="" name="photo_ktp" required>
                                <label class="custom-file-label" for="">Photo KTP</label>
                            </div>
                        </div>
                    </div>

                    @error('alamat')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="text" class="form-control @error('alamat') is-invalid @enderror"  placeholder="Alamat" name="alamat" value="{{ old('alamat') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-map" style="width: 15px"></span>
                            </div>
                        </div>
                    </div>

                    @error('password')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"  placeholder="Password" value="{{ old('password') }}" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-lock" style="width: 15px"></span>
                            </div>
                        </div>
                    </div>

                    @error('paket_layanan')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="form-group">
                        <select class="custom-select select2 "  name="paket_layanan" required>
                            <option value="">-- Pilih Paket --</option>
                            @foreach ($paket as $data)
                                <option value="{{ $data->id }}" {{(old('paket_layanan') == $data->id ? 'selected' : '') }}  >
                                    {{ $data->nama_layanan }} - {{ rupiah($data->harga) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-8">
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                        </div>
                    </div>
                </form>
                <p class="mb-0">
                    <a href="{{ route('loginClient') }}" class="text-center">Sudah punya akun ?</a>
                </p>
            </div>
        </div>
    </div>
    <script src="{{ asset('frontend/admin') }}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('frontend/admin') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/admin') }}/dist/js/adminlte.min.js"></script>
    <script src="{{ asset('frontend/admin') }}/plugins/select2/js/select2.full.min.js"></script>

    <script>
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
    @include('sweetalert::alert')
</body>

</html>

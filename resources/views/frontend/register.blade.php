<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ getCompany()->nama_perusahaan }}</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/admin') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/admin') }}/dist/css/adminlte.min.css">
    <link rel="icon"
        @if (getCompany()->favicon != null) href="{{ Storage::url('public/uploads/favicons/') . getCompany()->favicon }}" @endif
        type="image/x-icon">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>Sawit</b>SkyLink</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Daftar customer baru</p>
                <form action="../../index3.html" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Nama Lengkap">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-user" style="width: 15px"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-envelope" style="width: 15px"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="No Wa">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-whatsapp" style="width: 15px"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="No KTP">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-address-card" style="width: 15px"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Alamat">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-map" style="width: 15px"></span>
                            </div>
                        </div>
                    </div>


                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-lock" style="width: 15px"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
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
</body>

</html>

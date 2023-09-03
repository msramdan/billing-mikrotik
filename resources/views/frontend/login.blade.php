<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ getCompany()->nama_perusahaan }}</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('frontend/admin') }}/plugins/fontawesome-free/css/all.min.css">
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
                <p class="login-box-msg">Halaman Login</p>
                <form action="{{ route('submitLogin') }}" method="post">
                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" onclick="myFunction()">
                                <label for="remember">
                                    Show Password
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </form>
                <p class="mb-0">
                    <a href="{{ route('registerClient') }}" class="text-center">Daftar customer baru</a>
                </p>
            </div>
        </div>
    </div>
    <script src="{{ asset('frontend/admin') }}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('frontend/admin') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/admin') }}/dist/js/adminlte.min.js"></script>
    @include('sweetalert::alert')
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">


<style>
    .display-none {
        display: none !important;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(0, 0, 0, .8);
        z-index: 999;
        opacity: 1;
        transition: all 0.5s;
    }


    .lds-dual-ring {
        display: inline-block;
    }

    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 5% auto;
        border-radius: 50%;
        border: 6px solid #fff;
        border-color: #fff transparent #fff transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }

    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    #getDataBtn {
        background: #e2e222;
        border: 1px solid #e2e222;
        padding: 10px 20px;
    }

    .text-center {
        text-align: center;
    }

    #data-table table {
        margin: 20px auto;
    }
</style>

<head>
    <meta charset="utf-8" />
    <title>Form input mikrotik</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>
    <div id="page-container" class="page-container">
        <div id="content" class="content offset-md-4">
            <div class="row">
                <div class="col-md-offset-2 col-md-6 ">
                    <div class="panel panel-inverse" data-sortable-id="form-stuff-3">
                        <div class="panel-body">
                            <br>
                            <div class="card">
                                <div class="card-body">
                                    <form>
                                        <div class="alert alert-primary" role="alert">
                                            <center>
                                                <b>FORM ISIAN ROUTER MIKROTIK</b>
                                            </center>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Nama Router</label>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    id="" required value="">
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Host</label>
                                                <input type="text" id="host" name="host" class="form-control"
                                                    value="" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Port</label>
                                                <input type="number" id="port" name="port" class="form-control"
                                                    placeholder="8728" required value="">
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Username</label>
                                                <input type="text" id="username" name="username"
                                                    class="form-control" required value="">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Password</label>
                                                <div class="input-group">
                                                    <input type="password" id="password" name="password"
                                                        class="form-control" required value="">
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        style="width: 40px" onclick="toggleShowPassword()">

                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-success" role="alert" id="successMessage"
                                            style="display: none">
                                            <span id="isiPesanSuccess"></span>
                                        </div>
                                        <div class="alert alert-danger" role="alert" id="errormessage"
                                            style="display: none">
                                            <span id="isiPesanError"></span>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-success " id="btn-check">Cek Koneksi</button>
                                            <button class="btn btn-primary" style="display: none" id="btn-simpan"><i
                                                    class="fa fa-save"></i> Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="loader" class="lds-dual-ring display-none overlay"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade"
            data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"
        integrity="sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleShowPassword() {
            const type = $('input#password').attr('type');
            if (type === "password") {
                $('input#password').attr('type', 'text');
                $('input#password-confirmation').attr('type', 'text');
            } else {
                $('input#password').attr('type', 'password');
                $('input#password-confirmation').attr('type', 'password');
            }
        }
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#btn-check").click(function(e) {
            e.preventDefault();
            var name = $("input[name=name]").val();
            var host = $("input[name=host]").val();
            var port = $("input[name=port]").val();
            var username = $("input[name=username]").val();
            var password = $("input[name=password]").val();

            if (name == '') {
                Swal.fire(
                    'Failed',
                    'Silahkan isi nama router terlebih dahulu',
                    'error'
                );
                $("#name").focus();
            } else if (host == '') {
                Swal.fire(
                    'Failed',
                    'Silahkan isi host terlebih dahulu',
                    'error'
                );
                $("#host").focus();
            } else if (port == '') {
                Swal.fire(
                    'Failed',
                    'Silahkan isi port terlebih dahulu',
                    'error'
                );
                $("#port").focus();
            } else if (username == '') {
                Swal.fire(
                    'Failed',
                    'Silahkan isi username terlebih dahulu',
                    'error'
                );
                $("#username").focus();
            } else if (password == '') {
                Swal.fire(
                    'Failed',
                    'Silahkan isi password terlebih dahulu',
                    'error'
                );
                $("#password").focus();
            } else {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('api.cekrouter') }}",
                    data: {
                        name: name,
                        host: host,
                        port: port,
                        username: username,
                        password: password
                    },
                    beforeSend: function() {
                        $('#loader').removeClass('display-none')
                    },
                    success: function(data) {
                        if (data.success == true) {
                            $("button#btn-simpan").show();
                            $("#successMessage").show();
                            $("#errormessage").hide();
                            $("#isiPesanSuccess").html(data.message);
                            $("#btn-simpan").click(function(e) {
                                event.preventDefault();
                                $.ajax({
                                    type: 'POST',
                                    url: "{{ route('api.simpanrouter') }}",
                                    data: {
                                        name: data.data.name,
                                        host: data.data.host,
                                        port: data.data.port,
                                        username: data.data.user,
                                        password: data.data.pass
                                    },
                                    beforeSend: function() {
                                        $('#loader').removeClass('display-none')
                                    },

                                    success: function(data) {
                                        if (data.success == true) {
                                            Swal.fire(
                                                'Sukses',
                                                'Berhasil menambahkan data mikrotik',
                                                'success'
                                            );
                                            window.location.href = "dashboard";
                                        } else {
                                            Swal.fire(
                                                'Failed',
                                                'Ada error',
                                                'error'
                                            );
                                            location.reload('/');
                                        }

                                    },
                                    complete: function() {
                                        $('#loader').addClass('display-none')
                                    },
                                });
                            });
                        } else {
                            $("button#btn-simpan").hide();
                            $("#errormessage").show();
                            $("#successMessage").hide();
                            $("#isiPesanError").html(data.message);
                        }
                    },
                    complete: function() {
                        $('#loader').addClass('display-none')
                    },
                });
            }
        });
    </script>
</body>

</html>

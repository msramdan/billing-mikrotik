<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Aplikasi Undian Doorprize</title>
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
                                            FORM ISIAN ROUTER MIKROTIK
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Nama Router</label>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    id="" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Host</label>
                                                <input type="text" id="host" name="host" class="form-control"
                                                    required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Port</label>
                                                <input type="number" id="port" name="port" class="form-control"
                                                    value="" placeholder="8728" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Username</label>
                                                <input type="text" id="username" name="username"
                                                    class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Password</label>
                                                <div class="input-group">
                                                    <input type="password" id="password" name="password"
                                                        class="form-control" required>
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        style="width: 40px" onclick="toggleShowPassword()">

                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-success " id="btn-check">Check</button>
                                        </div>
                                    </form>
                                </div>
                            </div>


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
                success: function(data) {
                    console.log(data);
                    // alert(data.success);
                }
            });

        });
    </script>
</body>

</html>

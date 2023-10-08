<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Expired</title>
    <link rel="icon"
        @if (getCompany()->favicon != null) href="{{ Storage::url('public/uploads/favicons/') . getCompany()->favicon }}" @endif
        type="image/x-icon">
    <link rel="stylesheet" href=" {{ asset('mazer/css/main/app.css') }}">
    <link rel="stylesheet" href=" {{ asset('mazer/css/pages/error.css') }}">
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="error">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <img style="width: 60%;margin-top:-100px"
                        class="img-error"src="{{ asset('mazer/images/samples/error-404.svg') }}" alt="Not Found">
                    <p class='fs-5 ' style="color: red"> <b>Your subscription has expired. <br>
                            Please renew your subscription to continue using our services.
                    </p>
                    {{-- <a href="index.html" class="btn btn-lg btn-outline-primary mt-3">Renew Subscription</a> --}}
                </div>
            </div>
        </div>


    </div>
</body>

</html>

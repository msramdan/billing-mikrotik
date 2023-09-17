<!doctype html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/animate.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/flaticon.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/nice-select.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/meanmenu.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/style.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/responsive.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/dark-style.css">
    <title> {{ getCompany()->nama_perusahaan }} </title>
    <link rel="icon"
        @if (getCompany()->favicon != null) href="{{ Storage::url('public/uploads/favicons/') . getCompany()->favicon }}" @endif
        type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
        integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
        crossorigin="" />
    <link href="{{ asset('mazer/assets/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet" />

</head>

@stack('css')

<body>
    <header class="header-area">
        <div class="top-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-md-5">
                        <div class="top-header-left">
                            <p><span>Telpon / Wa :</span> <a href="#">{{ getCompany()->telepon_perusahaan }} /
                                    {{ getCompany()->no_wa }}</a></p>
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-7">
                        <div class="top-header-right">
                            <div class="login-signup-btn">
                                <p><a href="{{ route('loginClient') }}">Login</a> <span>or</span> <a
                                        href="{{ route('registerClient') }}">Register</a></p>
                            </div>

                            <ul class="social">
                                <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Navbar Area -->
        <div class="navbar-area">
            <div class="bahama-mobile-nav">
                <div class="logo">
                    <a href="/">
                       <h1><b style="color: #FA8185">{{ getCompany()->nama_perusahaan }}</b></h1>
                    </a>
                </div>
            </div>

            <div class="bahama-nav">
                <div class="container">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="/">
                            <h1><b style="color: #FA8185">{{ getCompany()->nama_perusahaan }}</b></h1>
                        </a>

                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item"><a href="/" class="nav-link">Home</a></li>
                                <li class="nav-item"><a href="{{ route('cekTagihan') }}" class="nav-link">Cek
                                        Tagihan</a></li>
                                <li class="nav-item"><a href="{{ route('areaCoverage') }}" class="nav-link">Area
                                        Coverage</a></li>
                                {{-- <li class="nav-item"><a href="{{ route('speedTest') }}" class="nav-link">Speed Test</a>
                                </li> --}}
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- End Navbar Area -->
    </header>

    @yield('content')

    <div class="go-top"><i class="fas fa-arrow-up"></i></div>
    <script src="{{ asset('frontend') }}/assets/js/jquery.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery.meanmenu.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/owl.carousel.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/parallax.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery.nice-select.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/wow.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery.ajaxchimp.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/form-validator.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/contact-form-script.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/main.js"></script>
    <script src="{{ asset('mazer/assets/jqvmap/dist/jquery.vmap.js') }}"></script>
    <script src="{{ asset('mazer/assets/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('mazer/assets/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
        integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
        crossorigin=""></script>
    @stack('js')
</body>

</html>

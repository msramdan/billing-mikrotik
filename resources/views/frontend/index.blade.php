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
        <title> {{ getCompany()->nama_perusahaan}} </title>
        <link rel="icon" type="image/png" href="{{ asset('frontend') }}/assets/img/favicon.png">
    </head>
    <body>
        <header class="header-area">
            <div class="top-header">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-5 col-md-5">
                            <div class="top-header-left">
                                <p><span>Telpon / Wa :</span> <a href="#">{{ getCompany()->telepon_perusahaan}} / {{ getCompany()->no_wa}}</a></p>
                            </div>
                        </div>

                        <div class="col-lg-7 col-md-7">
                            <div class="top-header-right">
                                <div class="login-signup-btn">
                                    <p><a href="#">Login</a> <span>or</span> <a href="#">Register</a></p>
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
                        <a href="index.html">
                            <img src="{{ asset('frontend') }}/assets/img/logo.png" alt="logo">
                        </a>
                    </div>
                </div>

                <div class="bahama-nav">
                    <div class="container">
                        <nav class="navbar navbar-expand-md navbar-light">
                            <a class="navbar-brand" href="index.html">
                                <h1 ><b style="color: #FA8185">Sawit</b><b>SkyLink</b></h1>
                            </a>

                            <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                                <ul class="navbar-nav">
                                    <li class="nav-item"><a href="" class="nav-link">Home</a></li>
                                    <li class="nav-item"><a href="" class="nav-link">Cek Tagihan</a></li>
                                    <li class="nav-item"><a href="" class="nav-link">Area Coverage</a></li>
                                    <li class="nav-item"><a href="" class="nav-link">Speed Test</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- End Navbar Area -->
        </header>
        <!-- End Header Area -->

        <!-- Start Main Banner Area -->
        <div class="main-banner">
            <div class="container">
                <div class="row align-items-center m-0">
                    <div class="col-lg-6 p-0">
                        <div class="main-banner-content">
                            <span class="sub-title"><i class="flaticon-wifi-signal"></i> {{ getCompany()->nama_perusahaan}} Broadband Service</span>
                            <h1>Built for Internet Service</h1>
                            <p>Dapatkan layanan internet murah berkualitas hanya di {{ getCompany()->nama_perusahaan}}</p>
                            <div class="price">
                                Rp 165.00 <span>/Bulan</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 p-0">
                        <div class="banner-image">
                            <img src="{{ asset('frontend') }}/assets/img/banner-img1.png" alt="image">
                        </div>
                    </div>
                </div>
            </div>

            <div class="shape-img1"><img src="{{ asset('frontend') }}/assets/img/shape-image/1.png" alt="imgae"></div>
        </div>
        <!-- End Main Banner Area -->

        <!-- Start Features Area -->
        <section class="features-area bg-image ptb-100" style="margin-top: -100px;">
            <div class="container">
                <div class="section-title">
                    <span>
                        <span class="icon">
                            <i class="flaticon-wifi"></i>
                        </span>

                        <span>{{ getCompany()->nama_perusahaan}} Isp Features</span>
                    </span>
                    <h2>
                        Kami adalah perusahaan penyedia layanan internet di Bali</h2>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-features-box">
                            <div class="icon">
                                <i class="flaticon-speedometer"></i>
                            </div>

                            <h3>Download 1Gbps</h3>

                            <p>Lorem ipsum dolor sit do eiusmod sit consectetur adipiscing elit, sed do eiusmod tempor incididunt ut.</p>

                            <div class="back-icon">
                                <i class="flaticon-speedometer"></i>
                            </div>

                            <div class="image-box">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-features-box">
                            <div class="icon">
                                <i class="flaticon-speedometer-1"></i>
                            </div>

                            <h3>99% Internet Uptime</h3>

                            <p>Lorem ipsum dolor sit do eiusmod sit consectetur adipiscing elit, sed do eiusmod tempor incididunt ut.</p>

                            <div class="back-icon">
                                <i class="flaticon-speedometer-1"></i>
                            </div>

                            <div class="image-box">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-0 offset-md-3 offset-sm-3">
                        <div class="single-features-box">
                            <div class="icon">
                                <i class="flaticon-support"></i>
                            </div>

                            <h3>24/7 Customer Support</h3>

                            <p>Lorem ipsum dolor sit do eiusmod sit consectetur adipiscing elit, sed do eiusmod tempor incididunt ut.</p>

                            <div class="back-icon">
                                <i class="flaticon-support"></i>
                            </div>

                            <div class="image-box">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Features Area -->

        <!-- Start About Area -->
        <section class="about-area ptb-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="about-content">
                            <span class="sub-title"><i class="flaticon-care-about-environment"></i> Tentang {{ getCompany()->nama_perusahaan}}</span>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisseLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="about-image">
                            <img src="{{ asset('frontend') }}/assets/img/about-img1.png" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End About Area -->

        <section class="cta-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-12">
                        <div class="cta-content">
                            <h3>Telpon / Wa</h3>
                            <a href="#">{{ getCompany()->telepon_perusahaan}} / {{ getCompany()->no_wa}}</a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <div class="cta-btn">
                            <a href="#" class="btn btn-primary">Periksa cakupan area</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>




        <!-- Start Pricing Area -->
        <section class="pricing-area ptb-100 extra-mb pb-0">
            <div class="container">
                <div class="section-title">
                    <span>
                        <span>Pilihan Paket {{ getCompany()->nama_perusahaan}}</span>
                    </span>
                    <h5>Daftar Harga Layanan Paket Internet {{ getCompany()->nama_perusahaan}}, Pilih sesuai keinginan dan kebutuhan Anda</h5>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-pricing-table">
                            <div class="pricing-header">
                                <div class="icon">
                                    <i class="flaticon-online-shop"></i>
                                </div>

                                <span>TV + Internet</span>
                                <h3>Player Bundle</h3>
                            </div>

                            <ul class="pricing-features-list">
                                <li><i class="flaticon-check-mark"></i> 150+ channels</li>
                                <li><i class="flaticon-check-mark"></i> Catch Up & On Demand</li>
                                <li><i class="flaticon-check-mark"></i> Cell Phone Connection</li>
                                <li><i class="flaticon-check-mark"></i> Up to 100Mbps fibre</li>
                                <li><i class="flaticon-check-mark"></i> Made for 1-4 devices</li>
                            </ul>

                            <div class="price">
                                <span>Harga</span>
                                <span>Rp</span>
                                67.99
                                <span>/mo</span>
                            </div>
                            <div class="image-box">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-pricing-table active">
                            <div class="pricing-header">
                                <div class="icon">
                                    <i class="flaticon-online-shop"></i>
                                </div>

                                <span>TV + Internet</span>
                                <h3>Bahama TV Box</h3>
                            </div>

                            <ul class="pricing-features-list">
                                <li><i class="flaticon-check-mark"></i> 150+ channels</li>
                                <li><i class="flaticon-check-mark"></i> Catch Up & On Demand</li>
                                <li><i class="flaticon-check-mark"></i> Cell Phone Connection</li>
                                <li><i class="flaticon-check-mark"></i> Up to 100Mbps fibre</li>
                                <li><i class="flaticon-check-mark"></i> Made for 1-4 devices</li>
                            </ul>

                            <div class="price">
                                <span>Harga</span>
                                <span>Rp</span>
                                79.99
                                <span>/mo</span>
                            </div>
                            <div class="image-box">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-0 offset-md-3 offset-sm-3">
                        <div class="single-pricing-table">
                            <div class="pricing-header">
                                <div class="icon">
                                    <i class="flaticon-online-shop"></i>
                                </div>

                                <span>TV + Internet</span>
                                <h3>Broadband & WIFI</h3>
                            </div>

                            <ul class="pricing-features-list">
                                <li><i class="flaticon-check-mark"></i> 150+ channels</li>
                                <li><i class="flaticon-check-mark"></i> Catch Up & On Demand</li>
                                <li><i class="flaticon-check-mark"></i> Cell Phone Connection</li>
                                <li><i class="flaticon-check-mark"></i> Up to 100Mbps fibre</li>
                                <li><i class="flaticon-check-mark"></i> Made for 1-4 devices</li>
                            </ul>

                            <div class="price">
                                <span>Harga</span>
                                <span>Rp</span>
                                99.99
                                <span>/mo</span>
                            </div>

                            <div class="image-box">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-pricing-table">
                            <div class="pricing-header">
                                <div class="icon">
                                    <i class="flaticon-online-shop"></i>
                                </div>

                                <span>TV + Internet</span>
                                <h3>Player Bundle</h3>
                            </div>

                            <ul class="pricing-features-list">
                                <li><i class="flaticon-check-mark"></i> 150+ channels</li>
                                <li><i class="flaticon-check-mark"></i> Catch Up & On Demand</li>
                                <li><i class="flaticon-check-mark"></i> Cell Phone Connection</li>
                                <li><i class="flaticon-check-mark"></i> Up to 100Mbps fibre</li>
                                <li><i class="flaticon-check-mark"></i> Made for 1-4 devices</li>
                            </ul>

                            <div class="price">
                                <span>Harga</span>
                                <span>Rp</span>
                                67.99
                                <span>/mo</span>
                            </div>
                            <div class="image-box">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-pricing-table active">
                            <div class="pricing-header">
                                <div class="icon">
                                    <i class="flaticon-online-shop"></i>
                                </div>

                                <span>TV + Internet</span>
                                <h3>Bahama TV Box</h3>
                            </div>

                            <ul class="pricing-features-list">
                                <li><i class="flaticon-check-mark"></i> 150+ channels</li>
                                <li><i class="flaticon-check-mark"></i> Catch Up & On Demand</li>
                                <li><i class="flaticon-check-mark"></i> Cell Phone Connection</li>
                                <li><i class="flaticon-check-mark"></i> Up to 100Mbps fibre</li>
                                <li><i class="flaticon-check-mark"></i> Made for 1-4 devices</li>
                            </ul>

                            <div class="price">
                                <span>Harga</span>
                                <span>Rp</span>
                                79.99
                                <span>/mo</span>
                            </div>
                            <div class="image-box">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-0 offset-md-3 offset-sm-3">
                        <div class="single-pricing-table">
                            <div class="pricing-header">
                                <div class="icon">
                                    <i class="flaticon-online-shop"></i>
                                </div>

                                <span>TV + Internet</span>
                                <h3>Broadband & WIFI</h3>
                            </div>

                            <ul class="pricing-features-list">
                                <li><i class="flaticon-check-mark"></i> 150+ channels</li>
                                <li><i class="flaticon-check-mark"></i> Catch Up & On Demand</li>
                                <li><i class="flaticon-check-mark"></i> Cell Phone Connection</li>
                                <li><i class="flaticon-check-mark"></i> Up to 100Mbps fibre</li>
                                <li><i class="flaticon-check-mark"></i> Made for 1-4 devices</li>
                            </ul>

                            <div class="price">
                                <span>Harga</span>
                                <span>Rp</span>
                                99.99
                                <span>/mo</span>
                            </div>

                            <div class="image-box">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
    </body>
</html>

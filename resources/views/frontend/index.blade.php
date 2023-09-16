@extends('layouts.frontend.frontend-master')

@section('content')
    <!-- Start Main Banner Area -->
    <div class="main-banner">
        <div class="container">
            <div class="row align-items-center m-0">
                <div class="col-lg-6 p-0">
                    <div class="main-banner-content">
                        <span class="sub-title"><i class="flaticon-wifi-signal"></i> {{ getCompany()->nama_perusahaan }}
                            Broadband Service</span>
                        <h1>Built for Internet Service</h1>
                        <p>Dapatkan layanan internet murah berkualitas hanya di {{ getCompany()->nama_perusahaan }}</p>
                        <div class="price">
                          Rp {{ rupiah2($packages[0]->harga) }} <span>/ Bulan</span>
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

                    <span>{{ getCompany()->nama_perusahaan }} Isp Features</span>
                </span>
                <h2>
                    Kami adalah perusahaan penyedia layanan internet di Bali</h2>
            </div>

            <div class="row">
                @foreach ( $features as $row )
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-features-box" style="height: 325px">
                        <div class="icon">
                            {!!$row->icon!!}
                        </div>

                        <h3>{{$row->judul}}</h3>

                        <p style="text-align: justify">{{$row->keterangan}}</p>

                        <div class="back-icon">
                            {!!$row->icon!!}
                        </div>

                        <div class="image-box">
                            <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                            <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                        </div>
                    </div>
                </div>
                @endforeach


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
                        <span class="sub-title"><i class="flaticon-care-about-environment"></i> Tentang
                            {{ getCompany()->nama_perusahaan }}</span>
                        <p style="text-align: justify"> {{ getCompany()->deskripsi_perusahaan }}</p>
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
                        <a href="#">{{ getCompany()->telepon_perusahaan }} / {{ getCompany()->no_wa }}</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="cta-btn">
                        <a href="/areaCoverage" class="btn btn-primary">Periksa cakupan area</a>
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
                    <span>Pilihan Paket {{ getCompany()->nama_perusahaan }}</span>
                </span>
                <h5>Daftar Harga Layanan Paket Internet {{ getCompany()->nama_perusahaan }}, Pilih sesuai keinginan dan
                    kebutuhan Anda</h5>
            </div>

            <div class="row">
                @foreach ($packages as $val)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-pricing-table active">
                            <div class="pricing-header">
                                <div class="icon">
                                    <i class="fa fa-wifi"></i>
                                </div>
                                <span>Internet</span>
                                <h3>{{ $val->nama_layanan }}</h3>
                            </div>
                            <p>{{ $val->keterangan }}</p>
                            <div class="price">
                                <span>Harga</span>
                                <span>Rp</span>
                                {{ rupiah2($val->harga) }}
                                <span>/ Bulan</span>
                            </div>
                            <div class="image-box">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                                <img src="{{ asset('frontend') }}/assets/img/shape-image/2.png" alt="image">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

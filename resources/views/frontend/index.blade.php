@extends('layouts.frontend.frontend-master')

@push('css')
    <style>
        .frame {
            height: 65px;
            width: 160px;
            position: relative;
        }

        .img-aja {
            max-height: 100%;
            max-width: 100%;
            width: auto;
            height: auto;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            padding: 0.25rem;
            background-color: #fff;
            /* border: 1px solid #dee2e6; */
            border-radius: 0.25rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .075);
        }
    </style>

    <style>
        .special-card {
            background-color: rgba(245, 245, 245, 0.6) !important;
        }
    </style>

    <style>
        .ribbon {
            position: absolute;
            right: -5px;
            top: -5px;
            z-index: 1;
            overflow: hidden;
            width: 93px;
            height: 93px;
            text-align: right;
        }

        .ribbon span {
            font-size: 0.7rem;
            color: #fff;
            text-transform: uppercase;
            text-align: center;
            font-weight: bold;
            line-height: 32px;
            transform: rotate(45deg);
            width: 125px;
            display: block;
            background: #79a70a;
            background: linear-gradient(#9bc90d 0%, #79a70a 100%);
            box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
            position: absolute;
            top: 17px;
            right: -29px;
        }

        .ribbon span::before {
            content: '';
            position: absolute;
            left: 0px;
            top: 100%;
            z-index: -1;
            border-left: 3px solid #79A70A;
            border-right: 3px solid transparent;
            border-bottom: 3px solid transparent;
            border-top: 3px solid #79A70A;
        }

        .ribbon span::after {
            content: '';
            position: absolute;
            right: 0%;
            top: 100%;
            z-index: -1;
            border-right: 3px solid #79A70A;
            border-left: 3px solid transparent;
            border-bottom: 3px solid transparent;
            border-top: 3px solid #79A70A;
        }

        .red span {
            background: linear-gradient(#f70505 0%, #8f0808 100%);
        }

        .red span::before {
            border-left-color: #8f0808;
            border-top-color: #8f0808;
        }

        .red span::after {
            border-right-color: #8f0808;
            border-top-color: #8f0808;
        }
    </style>
@endpush

@section('content')
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header"> <b>Masukan ID Pelanggan</b></div>
                    <form action="">
                        <div class="card-body special-card">
                            @if ($no_tagihan != '')
                                @if ($tagihan != null)
                                    @if ($tagihan->status_bayar == 'Sudah Bayar')
                                        <div class="ribbon"><span>Sudah Bayar</span></div>
                                    @else
                                        <div class="ribbon red"><span>Belum Bayar</span></div>
                                    @endif
                                @endif

                            @endif
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="no_tagihan" id="no_tagihan"
                                        required="no_tagihan" value="{{ $no_tagihan }}" style="border-color: white">

                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <button type="submit" class="btn"
                                    style="background-color: blue; color:white">Submit</button>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
            <div class="col-md-8">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header"> <b>Informasi</b></div>
                    <div class="card-body special-card">

                        @if ($no_tagihan == '')
                            <center><b>Silahkan isi form Terlebih dahulu untuk melihat tagihan</b></center>
                        @else
                            @if ($tagihan != null)

                                @if ($tagihanCount > 0)
                                    <div class="alert alert-danger" role="alert">
                                       <b>Anda mempunya tunggakan {{$tagihanCount}} bulan pembayaran. Harap segera bayarkan !!!</b>
                                    </div>
                                @else
                                    <div class="alert alert-success" role="alert">
                                       <b>Terimakasih, tagihan internet anda sudah terbayar semua !!!</b>
                                    </div>
                                @endif




                                <table class="table table-hover table-striped">
                                    <tr>
                                        <td class="fw-bold">{{ __('ID Pelanggan') }}</td>
                                        <td>{{ $tagihan->no_layanan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('No Tagihan') }}</td>
                                        <td>{{ $tagihan->no_tagihan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Pelanggan') }}</td>
                                        <td>{{ $tagihan->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Periode') }}</td>
                                        <td>{{ $tagihan->periode }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Metode Bayar') }}</td>
                                        <td>{{ $tagihan->metode_bayar }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Status Bayar') }}</td>
                                        <td>{{ $tagihan->status_bayar }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Nominal Bayar') }}</td>
                                        <td>{{ rupiah($tagihan->nominal_bayar) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Potongan Bayar') }}</td>
                                        <td>{{ rupiah($tagihan->potongan_bayar) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('PPN') }}</td>
                                        <td>{{ $tagihan->ppn }} - {{ rupiah($tagihan->nominal_ppn) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Total Bayar') }}</td>
                                        <td>
                                            (Nominal Bayar - Potongan Bayar) + PPN <br>
                                            ({{ rupiah($tagihan->nominal_bayar) }} -
                                            {{ rupiah($tagihan->potongan_bayar) }}) +
                                            {{ rupiah($tagihan->nominal_ppn) }} <br>
                                            <b>{{ rupiah($tagihan->total_bayar) }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tanggal Bayar') }}</td>
                                        <td>{{ isset($tagihan->tanggal_bayar) ? $tagihan->tanggal_bayar : '' }}
                                        </td>
                                    </tr>
                                </table>

                                @if ($tagihan->status_bayar == 'Belum Bayar')
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                    <b>LANGSUNG BAYAR TAGIHAN</b>
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    @foreach ($metodeBayar as $row)
                                                                        <div class="col-md-3 col-md-3 mb-3">
                                                                            <div class="small-box bg-light"
                                                                                style="border-radius: 5%">
                                                                                <center>
                                                                                    <div class="frame">
                                                                                        <img src="{{ $row->icon_url }}"
                                                                                            class="img-aja"
                                                                                            style="height: 80%" />
                                                                                    </div>
                                                                                    <a href="{{ route('bayar', [
                                                                                        'tagihan_id' => $tagihan->id,
                                                                                        'metode' => $row->code,
                                                                                    ]) }}"
                                                                                        class="small-box-footer"
                                                                                        style="color: blue"> <b>Pilih
                                                                                            Metode</b>
                                                                                        <i
                                                                                            class="fas fa-arrow-circle-right"></i></a>
                                                                                </center>


                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <center><b>Data tidak ditemukan, Silahkan cek kembali no tagihan</b></center>
                            @endif
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

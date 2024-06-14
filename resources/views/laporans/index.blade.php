@extends('layouts.app')

@section('title', __('Create Laporan'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Laporan') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('View laporan Keuangan.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/dashboard">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Laporan') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('laporans.index') }}" method="GET">
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="filter-bulan">{{ __('Filter Bulan') }}</label>
                                            <input type="month" name="filter_bulan" id="filter-bulan" class="form-control"
                                                value="{{ $month }}" placeholder="{{ __('Filter Bulan') }}"
                                                required />
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- Tombol untuk menampilkan modal -->
                                <div class="col-sm-6">
                                    <div class="alert alert-dark" role="alert">
                                        <b>Tagihan Sudah Bayar</b>
                                        <hr>
                                        Total : {{ $tagiahnBayar }} Tagihan<br>
                                        Nominal : {{ rupiah($nominalTagiahnBayar) }}
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#myModal">
                                            Detail
                                        </button>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Detail Tagihan Periode :
                                                    {{ konversiTanggal($month) }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Cash</td>
                                                            <td>{{ rupiah($nominalTagiahnBayarCash) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Payment Tripay</td>
                                                            <td>{{ rupiah($nominalTagiahnBayarPayment) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Transfer Bank</td>
                                                            <td>
                                                                {{ rupiah($nominalTagiahnBayarTrf) }}
                                                                @php
                                                                    $bankAccounts = DB::table('bank_accounts')
                                                                        ->leftJoin(
                                                                            'banks',
                                                                            'bank_accounts.bank_id',
                                                                            '=',
                                                                            'banks.id',
                                                                        )
                                                                        ->where(
                                                                            'bank_accounts.company_id',
                                                                            '=',
                                                                            session('sessionCompany'),
                                                                        )
                                                                        ->select('bank_accounts.*', 'banks.nama_bank')
                                                                        ->get();
                                                                @endphp
                                                                @foreach ($bankAccounts as $bankAccount)
                                                                    <li>{{ $bankAccount->nama_bank }} -
                                                                        {{ $bankAccount->nomor_rekening }} :
                                                                        @php
                                                                            $nominal = DB::table('tagihans')
                                                                                ->where('periode', $month)
                                                                                ->where('status_bayar', 'Sudah Bayar')
                                                                                ->where(
                                                                                    'tagihans.bank_account_id',
                                                                                    $bankAccount->id,
                                                                                )
                                                                                ->where(
                                                                                    'company_id',
                                                                                    '=',
                                                                                    session('sessionCompany'),
                                                                                )
                                                                                ->sum('tagihans.total_bayar');
                                                                        @endphp
                                                                        {{ rupiah($nominal) }}
                                                                    </li>
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="alert alert-dark" role="alert">
                                        <b>Tagihan Belum Bayar</b>
                                        <hr>
                                        Total : {{ $tagiahnBelumBayar }} Tagihan <br>
                                        Nominal : {{ rupiah($nominalTtagiahnBayar) }}
                                    </div>
                                </div>


                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                aria-expanded="false" aria-controls="collapseOne">
                                                <b> Pemasukan : {{ rupiah($nominalpemasukan) }} || Total transaksi :
                                                    {{ $totalpemasukan }}</b>
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    @foreach ($pemasukans as $pemasukan)
                                                        <div class="col-sm-6">
                                                            <div class="alert alert-success" role="alert">
                                                                <b>{{ $pemasukan->nama_kategori_pemasukan }}</b>
                                                                <hr>
                                                                Total : {{ $pemasukan->total_transaksi }} Transaksi<br>
                                                                Nominal : {{ rupiah($pemasukan->total_nominal) }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                <b>Pengeluaran : {{ rupiah($nominalpengeluaran) }} || Total transaksi :
                                                    {{ $totalpengeluaran }}</b>
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse"
                                            aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    @foreach($pengeluarans as $pengeluaran)
                                                    <div class="col-sm-6">
                                                        <div class="alert alert-danger" role="alert">
                                                            <b>{{ $pengeluaran->nama_kategori_pengeluaran }}</b>
                                                            <hr>
                                                            Total : {{ $pengeluaran->total_transaksi }} Transaksi<br>
                                                            Nominal : {{ rupiah($pengeluaran->total_nominal) }}
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed" type="button">
                                                <b>Sisa Hasil Pendapatan :
                                                    {{ rupiah($nominalpemasukan - $nominalpengeluaran) }}</b>
                                            </button>
                                        </h2>
                                    </div>
                                </div>






                                {{-- <div class="col-sm-6">
                                    <div class="alert alert-dark" role="alert">
                                        <b>Pemasukan Voucher</b>
                                        <hr>
                                        Total : {{ $countPemasukanVoucher }} Voucher<br>
                                        Nominal : {{ rupiah($nominalpemasukanVoucher) }}
                                    </div>
                                </div>



                                <div class="col-sm-6">
                                    <div class="alert alert-dark" role="alert">
                                        <b>Pengeluaran</b>
                                        <hr>
                                        Total : {{ $totalpengeluaran }} Transaksi<br>
                                        Nominal : {{ rupiah($nominalpengeluaran) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="alert alert-dark" role="alert">
                                        <b>Sisa Hasil Pendapatan</b>
                                        <hr>
                                        Nominal : {{ rupiah(($nominalpemasukan + $nominalpemasukanVoucher) - $nominalpengeluaran) }}
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

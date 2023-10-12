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
                                <div class="col-sm-6">
                                    <div class="alert alert-dark" role="alert">
                                        <b>Tagihan Sudah Bayar</b>
                                        <hr>
                                        Total : {{$tagiahnBayar}} Tagihan<br>
                                        Nominal : {{ rupiah($nominalTagiahnBayar) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="alert alert-dark" role="alert">
                                       <b>Tagihan Belum Bayar</b>
                                        <hr>
                                        Total : {{$tagiahnBelumBayar}} Tagihan <br>
                                        Nominal : {{ rupiah($nominalTtagiahnBayar) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="alert alert-dark" role="alert">
                                        <b>Pemasukan</b>
                                        <hr>
                                        Total : {{$totalpemasukan}} Transaksi<br>
                                        Nominal : {{ rupiah($nominalpemasukan) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="alert alert-dark" role="alert">
                                        <b>Pengeluaran</b>
                                        <hr>
                                        Total : {{$totalpengeluaran}} Transaksi<br>
                                        Nominal : {{ rupiah($nominalpengeluaran) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="alert alert-dark" role="alert">
                                        <b>Sisa Hasil Pendapatan</b>
                                        <hr>
                                        Total : {{$totalpengeluaran}} Transaksi<br>
                                        Nominal : {{ rupiah($nominalpemasukan - $nominalpengeluaran ) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

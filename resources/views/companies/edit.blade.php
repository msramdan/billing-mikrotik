@extends('layouts.app')

@section('title', __('Edit Companies'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Companies') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Edit a company.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/dashboard">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.index') }}">{{ __('Companies') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Edit') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-info" role="alert">
                                @php
                                    $info = getCompany();
                                @endphp
                                Anda terdaftar paket : {{ $info->nama_paket }}

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">Jumlah Router Mikrotik :  {{ $info->jumlah_router == 0 ? '-' : $info->jumlah_router  }} <br>
                                            <ul>
                                                <li>Terpakai : {{ hitungRouter()  }} </li>
                                                <li>Sisa : {{ $info->jumlah_router == 0 ? '-' : $info->jumlah_router - hitungRouter()  }} </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3">Jumlah Pelanggan : {{ $info->jumlah_pelanggan== 0 ? '-' : $info->jumlah_pelanggan  }}<br>
                                            <ul>
                                                <li>Terpakai :  {{ hitungPelanggan()  }} </li>
                                                <li>Sisa : {{ $info->jumlah_pelanggan== 0 ? '-' : $info->jumlah_pelanggan - hitungPelanggan()  }}</li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <form action="{{ route('companies.update', $company->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @include('companies.include.form')
                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

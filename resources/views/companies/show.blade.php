@extends('layouts.app')

@section('title', __('Detail of Companies'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Companies') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of company.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('companies.index') }}">{{ __('Companies') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Detail') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <tr>
                                        <td class="fw-bold">{{ __('Nama Perusahaan') }}</td>
                                        <td>{{ $company->nama_perusahaan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Nama Pemilik') }}</td>
                                        <td>{{ $company->nama_pemilik }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Telepon Perusahaan') }}</td>
                                        <td>{{ $company->telepon_perusahaan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Email') }}</td>
                                        <td>{{ $company->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('No Wa') }}</td>
                                        <td>{{ $company->no_wa }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Alamat') }}</td>
                                        <td>{{ $company->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Deskripsi Perusahaan') }}</td>
                                        <td>{{ $company->deskripsi_perusahaan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Logo') }}</td>
                                        <td>
                                            @if ($company->logo == null)
                                                <img src="https://via.placeholder.com/350?text=No+Image+Avaiable"
                                                    alt="Logo" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @else
                                                <img src="{{ asset('storage/uploads/logos/' . $company->logo) }}"
                                                    alt="Logo" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Favicon') }}</td>
                                        <td>
                                            @if ($company->favicon == null)
                                                <img src="https://via.placeholder.com/350?text=No+Image+Avaiable"
                                                    alt="Favicon" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @else
                                                <img src="{{ asset('storage/uploads/favicons/' . $company->favicon) }}"
                                                    alt="Favicon" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Url Wa Gateway') }}</td>
                                        <td>{{ $company->url_wa_gateway }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Api Key Wa Gateway') }}</td>
                                        <td>{{ $company->api_key_wa_gateway }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Sender WA') }}</td>
                                        <td>{{ $company->sender }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Is Active') }}</td>
                                        <td>{{ $company->is_active }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Footer Pesan Wa Tagihan') }}</td>
                                        <td>{{ $company->footer_pesan_wa_tagihan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Footer Pesan Wa Pembayaran') }}</td>
                                        <td>{{ $company->footer_pesan_wa_pembayaran }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Url Tripay') }}</td>
                                        <td>{{ $company->url_tripay }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Api Key Tripay') }}</td>
                                        <td>{{ $company->api_key_tripay }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Kode Merchant') }}</td>
                                        <td>{{ $company->kode_merchant }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Private Key') }}</td>
                                        <td>{{ $company->private_key }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Paket') }}</td>
                                        <td>{{ $company->paket ? $company->paket->nama_paket : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $company->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $company->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

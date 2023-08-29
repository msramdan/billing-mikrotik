@extends('layouts.app')

@section('title', __('Detail of Packages'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Packages') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of package.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/dashboard">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('packages.index') }}">{{ __('Packages') }}</a>
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
                                        <td class="fw-bold">{{ __('Nama Layanan') }}</td>
                                        <td>{{ $package->nama_layanan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Harga') }}</td>
                                        <td>{{ $package->harga }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Package Category') }}</td>
                                        <td>{{ $package->package_category ? $package->package_category->nama_kategori : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Keterangan') }}</td>
                                        <td>{{ $package->keterangan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Is Active') }}</td>
                                        <td>{{ $package->is_active }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $package->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $package->updated_at->format('d/m/Y H:i') }}</td>
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

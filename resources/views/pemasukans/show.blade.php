@extends('layouts.app')

@section('title', __('Detail of Pemasukan'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Pemasukan') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of pemasukan.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/dashboard">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('pemasukans.index') }}">{{ __('Pemasukan') }}</a>
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
                                            <td class="fw-bold">{{ __('Nominal') }}</td>
                                            <td>{{ $pemasukan->nominal }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Tanggal') }}</td>
                                            <td>{{ isset($pemasukan->tanggal) ? $pemasukan->tanggal->format('d/m/Y H:i') : ''  }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Keterangan') }}</td>
                                            <td>{{ $pemasukan->keterangan }}</td>
                                        </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $pemasukan->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $pemasukan->updated_at->format('d/m/Y H:i') }}</td>
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

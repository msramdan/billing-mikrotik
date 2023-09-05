@extends('layouts.app')

@section('title', __('Detail of Pengeluaran'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Pengeluaran') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of pengeluaran.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/dashboard">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('pengeluarans.index') }}">{{ __('Pengeluaran') }}</a>
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
                                            <td>{{ $pengeluaran->nominal }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Tanggal') }}</td>
                                            <td>{{ isset($pengeluaran->tanggal) ? $pengeluaran->tanggal->format('d/m/Y H:i') : ''  }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Keterangan') }}</td>
                                            <td>{{ $pengeluaran->keterangan }}</td>
                                        </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $pengeluaran->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $pengeluaran->updated_at->format('d/m/Y H:i') }}</td>
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

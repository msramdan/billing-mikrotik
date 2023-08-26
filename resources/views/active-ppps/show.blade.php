@extends('layouts.app')

@section('title', __('Detail of Active Ppps'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Active Ppps') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of active ppp.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('active-ppps.index') }}">{{ __('Active Ppps') }}</a>
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
                                            <td class="fw-bold">{{ __('Name') }}</td>
                                            <td>{{ $activePpp->name }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Service') }}</td>
                                            <td>{{ $activePpp->service }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Caller Id') }}</td>
                                            <td>{{ $activePpp->caller_id }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Ip Address') }}</td>
                                            <td>{{ $activePpp->ip_address }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Uptime') }}</td>
                                            <td>{{ $activePpp->uptime }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Komentar') }}</td>
                                            <td>{{ $activePpp->komentar }}</td>
                                        </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $activePpp->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $activePpp->updated_at->format('d/m/Y H:i') }}</td>
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

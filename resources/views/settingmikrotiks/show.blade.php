@extends('layouts.app')

@section('title', __('Detail of Setting Router'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Setting Router') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of settingmikrotik.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('settingmikrotiks.index') }}">{{ __('Setting Router') }}</a>
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
                                        <td class="fw-bold">{{ __('Identitas Router') }}</td>
                                        <td>{{ $settingmikrotik->identitas_router }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Host') }}</td>
                                        <td>{{ $settingmikrotik->host }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Port') }}</td>
                                        <td>{{ $settingmikrotik->port }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Username') }}</td>
                                        <td>{{ $settingmikrotik->username }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Is Active') }}</td>
                                        <td>{{ $settingmikrotik->is_active }}</td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $settingmikrotik->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $settingmikrotik->updated_at->format('d/m/Y H:i') }}</td>
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

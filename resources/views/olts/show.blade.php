@extends('layouts.app')

@section('title', __('Detail of Olts'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Olts') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of olt.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('olts.index') }}">{{ __('Olts') }}</a>
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
                                        <td>{{ $olt->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Type') }}</td>
                                        <td>{{ $olt->type }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Host') }}</td>
                                        <td>{{ $olt->host }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Telnet Port') }}</td>
                                        <td>{{ $olt->telnet_port }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Telnet Username') }}</td>
                                        <td>{{ $olt->telnet_username }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Telnet Password') }}</td>
                                        <td>{{ $olt->telnet_password }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('SNMP Port') }}</td>
                                        <td>{{ $olt->snmp_port }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Ro Community') }}</td>
                                        <td>{{ $olt->ro_community }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('IP Acs') }}</td>
                                        <td>{{ $olt->ip_acs }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Acs Username') }}</td>
                                        <td>{{ $olt->acs_username }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Acs Password') }}</td>
                                        <td>{{ $olt->acs_password }}</td>
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

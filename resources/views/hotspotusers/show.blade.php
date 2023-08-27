@extends('layouts.app')

@section('title', __('Detail of Hotspot Users'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Hotspot Users') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of hotspotuser.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('hotspotusers.index') }}">{{ __('Hotspot Users') }}</a>
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
                                            <td>{{ $hotspotuser->name }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Password') }}</td>
                                            <td>{{ $hotspotuser->password }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Profile') }}</td>
                                            <td>{{ $hotspotuser->profile }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Uptime') }}</td>
                                            <td>{{ $hotspotuser->uptime }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Bytes Out') }}</td>
                                            <td>{{ $hotspotuser->bytes_out }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Bytes In') }}</td>
                                            <td>{{ $hotspotuser->bytes_in }}</td>
                                        </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $hotspotuser->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $hotspotuser->updated_at->format('d/m/Y H:i') }}</td>
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

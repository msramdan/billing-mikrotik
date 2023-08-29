@extends('layouts.app')

@section('title', __('Detail of Secret Ppps'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Secret Ppps') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of secret ppp.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/dashboard">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('secret-ppps.index') }}">{{ __('Secret Ppps') }}</a>
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
                                            <td class="fw-bold">{{ __('Username') }}</td>
                                            <td>{{ $secretPpp->username }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Password') }}</td>
                                            <td>{{ $secretPpp->password }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Service') }}</td>
                                            <td>{{ $secretPpp->service }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Profile') }}</td>
                                            <td>{{ $secretPpp->profile }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Last Logout') }}</td>
                                            <td>{{ $secretPpp->last_logout }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Komentar') }}</td>
                                            <td>{{ $secretPpp->komentar }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Status') }}</td>
                                            <td>{{ $secretPpp->status }}</td>
                                        </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $secretPpp->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $secretPpp->updated_at->format('d/m/Y H:i') }}</td>
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

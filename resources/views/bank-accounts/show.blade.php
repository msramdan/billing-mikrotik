@extends('layouts.app')

@section('title', __('Detail of Bank Accounts'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Bank Accounts') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of bank account.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('bank-accounts.index') }}">{{ __('Bank Accounts') }}</a>
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
                                        <td class="fw-bold">{{ __('Bank') }}</td>
                                        <td>{{ $bankAccount->bank ? $bankAccount->bank->id : '' }}</td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Pemilik Rekening') }}</td>
                                            <td>{{ $bankAccount->pemilik_rekening }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Nomor Rekening') }}</td>
                                            <td>{{ $bankAccount->nomor_rekening }}</td>
                                        </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $bankAccount->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $bankAccount->updated_at->format('d/m/Y H:i') }}</td>
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

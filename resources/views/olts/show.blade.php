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
                                            <td class="fw-bold">{{ __('Ro') }}</td>
                                            <td>{{ $olt->ro }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Rw') }}</td>
                                            <td>{{ $olt->rw }}</td>
                                        </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $olt->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $olt->updated_at->format('d/m/Y H:i') }}</td>
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

@extends('layouts.app')

@section('title', __('Detail of Area Coverages'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Area Coverages') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of area coverage.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('area-coverages.index') }}">{{ __('Area Coverages') }}</a>
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
                                            <td class="fw-bold">{{ __('Kode Area') }}</td>
                                            <td>{{ $areaCoverage->kode_area }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Tampilkan Register') }}</td>
                                            <td>{{ $areaCoverage->tampilkan_register }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Nama') }}</td>
                                            <td>{{ $areaCoverage->nama }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Alamat') }}</td>
                                            <td>{{ $areaCoverage->alamat }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Keterangan') }}</td>
                                            <td>{{ $areaCoverage->keterangan }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Jangkauan') }}</td>
                                            <td>{{ $areaCoverage->jangkauan }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Latitude') }}</td>
                                            <td>{{ $areaCoverage->latitude }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Longitude') }}</td>
                                            <td>{{ $areaCoverage->longitude }}</td>
                                        </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $areaCoverage->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $areaCoverage->updated_at->format('d/m/Y H:i') }}</td>
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

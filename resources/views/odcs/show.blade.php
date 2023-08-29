@extends('layouts.app')

@section('title', __('Detail of Odcs'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Odcs') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of odc.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('odcs.index') }}">{{ __('Odcs') }}</a>
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
                                            <td class="fw-bold">{{ __('Kode Odc') }}</td>
                                            <td>{{ $odc->kode_odc }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Area Coverage') }}</td>
                                        <td>{{ $odc->area_coverage ? $odc->area_coverage->kode_area : '' }}</td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Nomor Port Olt') }}</td>
                                            <td>{{ $odc->nomor_port_olt }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Warna Tube Fo') }}</td>
                                            <td>{{ $odc->warna_tube_fo }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Nomor Tiang') }}</td>
                                            <td>{{ $odc->nomor_tiang }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Document') }}</td>
                                        <td>
                                            @if ($odc->document == null)
                                            <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Document"  class="rounded" width="200" height="150" style="object-fit: cover">
                                            @else
                                                <img src="{{ asset('storage/uploads/documents/' . $odc->document) }}" alt="Document" class="rounded" width="200" height="150" style="object-fit: cover">
                                            @endif
                                        </td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Description') }}</td>
                                            <td>{{ $odc->description }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Latitude') }}</td>
                                            <td>{{ $odc->latitude }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Longitude') }}</td>
                                            <td>{{ $odc->longitude }}</td>
                                        </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $odc->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $odc->updated_at->format('d/m/Y H:i') }}</td>
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

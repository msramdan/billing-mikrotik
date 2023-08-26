@extends('layouts.app')

@section('title', __('Area Coverages'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Area Coverages') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all area coverages.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Area Coverages') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

            @can('area coverage create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('area-coverages.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Create a new area coverage') }}
                    </a>
                </div>
            @endcan

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Kode Area') }}</th>
                                            <th>{{ __('Tampilkan Register') }}</th>
                                            <th>{{ __('Nama') }}</th>
                                            <th>{{ __('Alamat') }}</th>
                                            <th>{{ __('Keterangan') }}</th>
                                            <th>{{ __('Jangkauan') }}</th>
                                            <th>{{ __('Latitude') }}</th>
                                            <th>{{ __('Longitude') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.css" />
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script>
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('area-coverages.index') }}",
            columns: [{
                    data: 'kode_area',
                    name: 'kode_area',
                },
                {
                    data: 'tampilkan_register',
                    name: 'tampilkan_register',
                },
                {
                    data: 'nama',
                    name: 'nama',
                },
                {
                    data: 'alamat',
                    name: 'alamat',
                },
                {
                    data: 'keterangan',
                    name: 'keterangan',
                },
                {
                    data: 'radius',
                    name: 'radius',
                },
                {
                    data: 'latitude',
                    name: 'latitude',
                },
                {
                    data: 'longitude',
                    name: 'longitude',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    </script>
@endpush

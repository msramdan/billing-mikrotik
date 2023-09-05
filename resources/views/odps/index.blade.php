@extends('layouts.app')

@section('title', __('Odps'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Odps') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all odps.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/dashboard">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Odps') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

                @can('odp create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('odps.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Create a new odp') }}
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
                                            <th>{{ __('Odc') }}</th>
											<th>{{ __('Nomor Port Odc') }}</th>
											<th>{{ __('Kode Odp') }}</th>
											<th>{{ __('Area Coverage') }}</th>
											<th>{{ __('Warna Tube Fo') }}</th>
											<th>{{ __('Nomor Tiang') }}</th>
											<th>{{ __('Jumlah Port') }}</th>
											<th>{{ __('Description') }}</th>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.css" />
@endpush

@push('js')

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script>
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('odps.index') }}",
            columns: [
                {
                    data: 'odc',
                    name: 'odc.kode_odc'
                },
				{
                    data: 'nomor_port_odc',
                    name: 'nomor_port_odc',
                },
				{
                    data: 'kode_odp',
                    name: 'kode_odp',
                },
				{
                    data: 'area_coverage',
                    name: 'area_coverage.kode_area'
                },
				{
                    data: 'warna_tube_fo',
                    name: 'warna_tube_fo',
                },
				{
                    data: 'nomor_tiang',
                    name: 'nomor_tiang',
                },
				{
                    data: 'jumlah_port',
                    name: 'jumlah_port',
                },
				{
                    data: 'description',
                    name: 'description',
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

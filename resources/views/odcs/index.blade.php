@extends('layouts.app')

@section('title', __('Odcs'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Odcs') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all odcs.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/dashboard">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Odcs') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

                @can('odc create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('odcs.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Create a new odc') }}
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
                                            <th>{{ __('Kode Odc') }}</th>
											<th>{{ __('Area Coverage') }}</th>
											<th>{{ __('Nomor Port Olt') }}</th>
											<th>{{ __('Warna Tube Fo') }}</th>
											<th>{{ __('Nomor Tiang') }}</th>
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
            ajax: "{{ route('odcs.index') }}",
            columns: [
                {
                    data: 'kode_odc',
                    name: 'kode_odc',
                },
				{
                    data: 'area_coverage',
                    name: 'area_coverage.kode_area'
                },
				{
                    data: 'nomor_port_olt',
                    name: 'nomor_port_olt',
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

@extends('layouts.app')

@section('title', __('Hotspot Users'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Hotspot Users') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all Hotspot Users.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/dashboard">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Hotspot Users') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

                @can('hotspotuser create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('hotspotusers.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Create a new hotspotuser') }}
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
                                            <th>{{ __('Name') }}</th>
											<th>{{ __('Password') }}</th>
											<th>{{ __('Profile') }}</th>
											<th>{{ __('Uptime') }}</th>
											<th>{{ __('Download') }}</th>
											<th>{{ __('Upload') }}</th>
                                            <th>{{ __('Disable') }}</th>
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
            ajax: "{{ route('hotspotusers.index') }}",
            columns: [
                {
                    data: 'name',
                    name: 'name',
                },
				{
                    data: 'password',
                    name: 'password',
                    render: function(data, type, full, meta) {
                        if (typeof data !== 'undefined') {
                            return `${data}`;
                        } else {
                            return '-';
                        }
                    }
                },
				{
                    data: 'profile',
                    name: 'profile',
                },
				{
                    data: 'uptime',
                    name: 'uptime',
                },
				{
                    data: 'bytes_out',
                    name: 'bytes_out',
                },
				{
                    data: 'bytes_in',
                    name: 'bytes_in',
                },
                {
                    data: 'disabled',
                    name: 'disabled',
                    render: function(data, type, full, meta) {
                        if (data == 'true') {
                            return '<button type="button" class="btn btn-danger btn-sm">Ya</button>';
                        } else {
                            return '<button type="button" class="btn btn-success btn-sm">Tidak</button>';
                        }
                    }
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

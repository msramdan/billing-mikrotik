@extends('layouts.app')

@section('title', __('Olts'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Olts') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all olts.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Olts') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

                @can('olt create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('olts.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Create a new olt') }}
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
											<th>{{ __('Type') }}</th>
											<th>{{ __('Host') }}</th>
                                            <th>{{ __('Telnet Port') }}</th>
											<th>{{ __('Telnet Username') }}</th>
											<th>{{ __('Telnet Password') }}</th>
                                            <th>{{ __('Snmp Port') }}</th>
                                            <th>{{ __('Ro Community') }}</th>
                                            <th>{{ __('IP Acs') }}</th>
                                            <th>{{ __('Acs Username') }}</th>
                                            <th>{{ __('Acs Password') }}</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script>
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('olts.index') }}",
            columns: [
                {
                    data: 'name',
                    name: 'name',
                },
				{
                    data: 'type',
                    name: 'type',
                },
				{
                    data: 'host',
                    name: 'host',
                },
                {
                    data: 'telnet_port',
                    name: 'telnet_port',
                },
				{
                    data: 'telnet_username',
                    name: 'telnet_username',
                },
				{
                    data: 'telnet_password',
                    name: 'telnet_password',
                },
                {
                    data: 'snmp_port',
                    name: 'snmp_port',
                },
                {
                    data: 'ro_community',
                    name: 'ro_community',
                },
                {
                    data: 'ip_acs',
                    name: 'ip_acs',
                },
                {
                    data: 'acs_username',
                    name: 'acs_username',
                },
                {
                    data: 'acs_password',
                    name: 'acs_password',
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

@extends('layouts.app')

@section('title', __('Active PPP'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Active PPP') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all active PPP.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Active PPP') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Service') }}</th>
                                            <th>{{ __('Caller Id') }}</th>
                                            <th>{{ __('Ip Address') }}</th>
                                            <th>{{ __('Uptime') }}</th>
                                            <th>{{ __('Komentar') }}</th>
                                            {{-- <th>{{ __('Action') }}</th> --}}
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
            ajax: "{{ route('active-ppps.index') }}",
            columns: [{
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'service',
                    name: 'service',
                },
                {
                    data: 'caller-id',
                    name: 'caller-id',
                },
                {
                    data: 'address',
                    name: 'address',
                },
                {
                    data: 'uptime',
                    name: 'uptime',
                },
                {
                    data: 'comment',
                    name: 'comment',
                    render: function(data, type, full, meta) {
                        if (typeof data !== 'undefined') {
                            return `${data}`;
                        } else {
                            return '-';
                        }
                    }
                }
                // ,
                // {
                //     data: 'action',
                //     name: 'action',
                //     orderable: false,
                //     searchable: false
                // }
            ],
        });
    </script>
@endpush

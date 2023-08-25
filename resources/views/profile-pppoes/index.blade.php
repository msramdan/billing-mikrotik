@extends('layouts.app')

@section('title', __('Profile PPP'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Profile PPP') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all profile PPP.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Profile PPP') }}</li>
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
                                            <th>{{ __('Local') }}</th>
                                            <th>{{ __('Remote') }}</th>
                                            <th>{{ __('Limit') }}</th>
                                            <th>{{ __('Parent') }}</th>
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
            ajax: "{{ route('profile-pppoes.index') }}",
            columns: [{
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'local-address',
                    name: 'local-address',
                    render: function(data, type, full, meta) {
                        if (typeof data !== 'undefined') {
                            return `${data}`;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    data: 'remote-address',
                    name: 'remote-address',
                    render: function(data, type, full, meta) {
                        if (typeof data !== 'undefined') {
                            return `${data}`;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    data: 'rate-limit',
                    name: 'rate-limit',
                    render: function(data, type, full, meta) {
                        if (typeof data !== 'undefined') {
                            return `${data}`;
                        } else {
                            return '-';
                        }
                    }

                },
                {
                    data: 'parent-queue',
                    name: 'parent-queue',
                    render: function(data, type, full, meta) {
                        if (typeof data !== 'undefined') {
                            return `${data}`;
                        } else {
                            return '-';
                        }
                    }
                }
            ],
        });
    </script>
@endpush

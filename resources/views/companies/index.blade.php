@extends('layouts.app')

@section('title', __('Companies'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Companies') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all companies.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Companies') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

            @can('company create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('companies.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Create a new company') }}
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
                                            <th>#</th>
                                            <th>{{ __('Nama Perusahaan') }}</th>
                                            <th>{{ __('Nama Pemilik') }}</th>
                                            <th>{{ __('Telepon Perusahaan') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('No Wa') }}</th>
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
        function format(d) {
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td>Area Alamat</td>' +
                '<td>' + d.Alamat + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Deskripsi Perusahaan</td>' +
                '<td>' + d.deskripsi_perusahaan + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Url Wa Gateway</td>' +
                '<td>' + d.url_wa_gateway + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Api Key Wa Gateway</td>' +
                '<td>' + d.api_key_wa_gateway + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Sender WA</td>' +
                '<td>' + d.sender + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Is Active</td>' +
                '<td>' + d.is_active + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Footer Pesan Wa Tagihan</td>' +
                '<td>' + d.footer_pesan_wa_tagihan + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Footer Pesan Wa Pembayaran</td>' +
                '<td>' + d.footer_pesan_wa_pembayaran + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Url Tripay</td>' +
                '<td>' + d.url_tripay + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Api Key Tripay</td>' +
                '<td>' + d.api_key_tripay + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Kode Merchant</td>' +
                '<td>' + d.kode_merchant + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Private Key</td>' +
                '<td>' + d.private_key + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Paket</td>' +
                '<td>' + d.nama_paket + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Expired</td>' +
                '<td>' + d.expired + '</td>' +
                '</tr>' +
                '</table>';
        }

        $('#data-table').on('click', 'tbody td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
            } else {
                row.child(format(row.data())).show();
            }
        });

        $('#data-table').on('requestChild.dt', function(e, row) {
            row.child(format(row.data())).show();
        })

        let columns = [{
                "className": 'dt-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            {
                data: 'nama_perusahaan',
                name: 'nama_perusahaan',
            },
            {
                data: 'nama_pemilik',
                name: 'nama_pemilik',
            },
            {
                data: 'telepon_perusahaan',
                name: 'telepon_perusahaan',
            },
            {
                data: 'email',
                name: 'email',
            },
            {
                data: 'no_wa',
                name: 'no_wa',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ];

        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('companies.index') }}",
            },
            columns: columns
        });
    </script>
@endpush

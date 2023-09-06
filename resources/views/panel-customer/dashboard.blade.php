@extends('layouts.panelCustomer.panel-customer-master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
            </div>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="month" name="tanggal" id="tanggal" class="form-control" />
                                </div>
                                <div class="col-md-3">
                                    <select name="metode_bayar" id="metode_bayar"
                                        class="form-control  js-example-basic-single">
                                        <option value="All">All Metode Bayar</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Transfer Bank">Transfer Bank</option>
                                        <option value="Payment Tripay">Payment Tripay</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <select name="status_bayar" id="status_bayar"
                                        class="form-control  js-example-basic-single">
                                        <option value="All">All Status Bayar
                                        </option>
                                        <option value="Sudah Bayar">Sudah Bayar</option>
                                        <option value="Belum Bayar">Belum Bayar</option>

                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('No Tagihan') }}</th>
                                            <th>{{ __('Pelanggan') }}</th>
                                            <th>{{ __('Periode') }}</th>
                                            <th>{{ __('Metode Bayar') }}</th>
                                            <th>{{ __('Nominal Bayar') }}</th>
                                            <th>{{ __('Potongan Bayar') }}</th>
                                            <th>{{ __('PPN') }}</th>
                                            <th>{{ __('Total Bayar') }}</th>
                                            <th>{{ __('Status Bayar') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.css" />
@endpush

@push('js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script>
        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'no_tagihan',
                name: 'no_tagihan',
            },
            {
                data: 'pelanggan',
                name: 'pelanggan.coverage_area'
            },
            {
                data: 'periode',
                name: 'periode',
            },
            {
                data: 'metode_bayar',
                name: 'metode_bayar',
            },

            {
                data: 'nominal_bayar',
                name: 'nominal_bayar',
            },

            {
                data: 'potongan_bayar',
                name: 'potongan_bayar',
            },
            {
                data: 'nominal_ppn',
                name: 'nominal_ppn',
            },
            {
                data: 'total_bayar',
                name: 'total_bayar',
            },
            {
                data: 'status_bayar',
                name: 'status_bayar',
                render: function(data, type, full, meta) {
                    if (data == 'Belum Bayar') {
                        return '<button type="button" class="btn btn-danger btn-sm">Belum Bayar</button>';
                    } else {
                        return '<button type="button" class="btn btn-success btn-sm">Sudah Bayar</button>';
                    }
                }
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
                url: "{{ route('dashboardCustomer') }}",
                data: function(s) {
                    s.metode_bayar = $('select[name=metode_bayar] option').filter(':selected').val()
                    s.status_bayar = $('select[name=status_bayar] option').filter(':selected').val()
                    s.tanggal = $("#tanggal").val();
                }
            },
            columns: columns
        });

        $('#metode_bayar').change(function() {
            table.draw();
        })
        $('#status_bayar').change(function() {
            table.draw();
        })
        $('#tanggal').change(function() {
            table.draw();
        })
    </script>
@endpush

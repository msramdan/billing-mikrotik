@extends('layouts.app')

@section('title', __('Tagihans'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Tagihans') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all tagihans.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Tagihans') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

            @can('tagihan create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('tagihans.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Create a new tagihan') }}
                    </a>
                </div>
            @endcan

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <input type="month" name="tanggal" id="tanggal" class="form-control" />
                                        </div>
                                        <div class="col-md-3">
                                            <select name="pelanggans" id="pelanggans"
                                                class="form-control  js-example-basic-single">
                                                <option value="All">All Pelanggan</option>
                                                @foreach ($pelanggans as $row)
                                                    <option value="{{ $row->id }}">
                                                        {{ $row->nama }}
                                                    </option>
                                                @endforeach

                                            </select>
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
                                            {{-- <th>{{ __('Periode') }}</th>
                                            <th>{{ __('Metode Bayar') }}</th>
                                            <th>{{ __('Nominal Bayar') }}</th>
                                            <th>{{ __('Potongan Bayar') }}</th>
                                            <th>{{ __('PPN') }}</th> --}}
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
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script>
        function format(d) {
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td>Periode</td>' +
                '<td>' + d.periode + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Metode Bayar</td>' +
                '<td>' + d.metode_bayar + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Nominal Bayar</td>' +
                '<td>' + d.nominal_bayar + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Potongan Bayar</td>' +
                '<td>' + d.potongan_bayar + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>PPN</td>' +
                '<td>' + d.nominal_ppn + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Total Bayar</td>' +
                '<td>' + d.total_bayar + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>User Verifikasi</td>' +
                '<td>' + d.user + '</td>' +
                '</tr>' +
                '</table>';
        }

        $('#data-table').on('click', 'tbody td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
            } else {
                // Open this row
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
                data: 'no_tagihan',
                name: 'no_tagihan',
            },
            {
                data: 'pelanggan',
                name: 'pelanggan.coverage_area'
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
                url: "{{ route('tagihans.index') }}",
                data: function(s) {
                    s.pelanggans = $('select[name=pelanggans] option').filter(':selected').val()
                    s.metode_bayar = $('select[name=metode_bayar] option').filter(':selected').val()
                    s.status_bayar = $('select[name=status_bayar] option').filter(':selected').val()
                    s.tanggal = $("#tanggal").val();
                }
            },
            columns: columns
        });

        $('#pelanggans').change(function() {
            table.draw();
        })
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

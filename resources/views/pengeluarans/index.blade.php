@extends('layouts.app')

@section('title', __('Pengeluaran'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Pengeluaran') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all Pengeluaran.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/dashboard">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Pengeluaran') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

            @can('pengeluaran create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('pengeluarans.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Create a new pengeluaran') }}
                    </a>
                </div>
            @endcan

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group mb-4">
                                        <span class="input-group-text" id="addon-wrapping"><i
                                                class="fa fa-calendar"></i></span>
                                        <input type="text" class="form-control" aria-describedby="addon-wrapping"
                                            id="daterange-btn" value="">
                                        <input type="hidden" name="start_date" id="start_date"
                                            value="{{ $microFrom ?? '' }}">
                                        <input type="hidden" name="end_date" id="end_date" value="{{ $microTo ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-4">
                                        <select name="kategori_pengeluaran" id="kategori_pengeluaran" class="form-control select2-form">
                                            <option value="All">-- All kategori pengeluaran --</option>
                                            @foreach ($categoryPengeluarans as $row)
                                                <option value="{{ $row->id }}"
                                                    {{ $kategori_pengeluaran == $row->id ? 'selected' : '' }}>
                                                    {{ $row->nama_kategori_pengeluaran }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Nominal') }}</th>
                                            <th>{{ __('Tanggal') }}</th>
                                            <th>{{ __('Kategori pengeluaran') }}</th>
                                            <th>{{ __('Keterangan') }}</th>
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
    <link href="{{ asset('mazer/css/daterangepicker.min.css') }}" rel="stylesheet" />
@endpush

@push('js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script type="text/javascript" src="{{ asset('mazer/js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mazer/js/daterangepicker.min.js') }}"></script>
    <script>
        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'nominal',
                name: 'nominal',
            },
            {
                data: 'tanggal',
                name: 'tanggal',
            },
            {
                data: 'nama_kategori_pengeluaran',
                name: 'nama_kategori_pengeluaran',
            },
            {
                data: 'keterangan',
                name: 'keterangan',
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
                url: "{{ route('pengeluarans.index') }}",
                data: function(s) {
                    s.start_date = $("#start_date").val();
                    s.end_date = $("#end_date").val();
                    s.kategori_pengeluaran = $('select[name=kategori_pengeluaran] option').filter(':selected').val()
                }
            },
            columns: columns
        });

        function replaceURLParams() {
            var params = new URLSearchParams();
            var startDate = $("#start_date").val();
            var endDate = $("#end_date").val();
            var kategoriPengeluaran = $('select[name=kategori_pengeluaran]').val();
            if (startDate) params.set('start_date', startDate);
            if (endDate) params.set('end_date', endDate);
            if (kategoriPengeluaran) params.set('kategori_pengeluaran', kategoriPengeluaran);
            var newURL = "{{ route('pengeluarans.index') }}" + '?' + params.toString();
            history.replaceState(null, null, newURL);
        }

        $('#daterange-btn').change(function() {
            table.draw();
            replaceURLParams()
        })

        $('#kategori_pengeluaran').change(function() {
            table.draw();
            replaceURLParams()
        })
    </script>
    <script>
        var start = {{ $microFrom }}
        var end = {{ $microTo }}
        var label = '';
        $('#daterange-btn').daterangepicker({
                locale: {
                    format: 'DD MMM YYYY'
                },
                startDate: moment(start),
                endDate: moment(end),
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                        'month')],
                }
            },
            function(start, end, label) {
                $('#start_date').val(Date.parse(start));
                $('#end_date').val(Date.parse(end));
                if (isDate(start)) {
                    $('#daterange-btn span').html(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
                }
            });


        function isDate(val) {
            var d = Date.parse(val);
            return Date.parse(val);
        }
    </script>
@endpush

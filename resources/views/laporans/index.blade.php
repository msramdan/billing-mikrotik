@extends('layouts.app')

@section('title', __('View Laporan'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Laporan') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('View laporan Keuangan.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/dashboard">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Laporan') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="alert alert-light" role="alert">
                                    <b>Laporan Keuangan</b>
                                </div>
                                <form action="{{ route('laporans.index') }}" method="GET">
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3 d-flex justify-content-between">
                                            <div class="input-group me-2">
                                                <span class="input-group-text" id="addon-wrapping">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control" aria-describedby="addon-wrapping"
                                                    id="daterange-btn" value="">
                                                <input type="hidden" name="start_date" id="start_date"
                                                    value="{{ $microFrom ?? '' }}">
                                                <input type="hidden" name="end_date" id="end_date"
                                                    value="{{ $microTo ?? '' }}">
                                            </div>
                                            <button type="submit" class="btn btn-success">Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="alert alert-light" role="alert">
                                    <b>Laporan Keuangan</b>
                                </div>
                                <div class="row">

                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                    aria-expanded="false" aria-controls="collapseOne">
                                                    <b> Pemasukan : {{ rupiah($nominalpemasukan) }}</b>
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse"
                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 33%;">Kategori</th>
                                                                    <th style="width: 33%;">Total Transaksi</th>
                                                                    <th style="width: 34%;">Nominal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $totalTransaksi = 0;
                                                                    $totalNominal = 0;
                                                                @endphp
                                                                @foreach ($pemasukans as $pemasukan)
                                                                    @php
                                                                        $totalTransaksi += $pemasukan->total_transaksi;
                                                                        $totalNominal += $pemasukan->total_nominal;
                                                                    @endphp
                                                                    <tr>
                                                                        <td><b>{{ $pemasukan->nama_kategori_pemasukan }}</b></td>
                                                                        <td>{{ $pemasukan->total_transaksi }}</td>
                                                                        <td>{{ rupiah($pemasukan->total_nominal) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>Total</th>
                                                                    <th>{{ $totalTransaksi }}</th>
                                                                    <th>{{ rupiah($totalNominal) }}</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>

                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 33%;">Metode Bayar</th>
                                                                    <th style="width: 33%;">Total Transaksi</th>
                                                                    <th style="width: 34%;">Nominal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $totalTransaksiSumber = 0;
                                                                    $totalNominalSumber = 0;
                                                                @endphp
                                                                @foreach ($pemasukansBySumber as $row)
                                                                    @php
                                                                        $totalTransaksiSumber += $row->total_transaksi;
                                                                        $totalNominalSumber += $row->total_nominal;
                                                                    @endphp
                                                                    <tr>
                                                                        <td><b>{{ $row->metode_bayar }}</b></td>
                                                                        <td>{{ $row->total_transaksi }}</td>
                                                                        <td>{{ rupiah($row->total_nominal) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>Total</th>
                                                                    <th>{{ $totalTransaksiSumber }}</th>
                                                                    <th>{{ rupiah($totalNominalSumber) }}</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                    <b>Pengeluaran : {{ rupiah($nominalpengeluaran) }}</b>
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 33%;">Kategori</th>
                                                                    <th style="width: 33%;">Total Transaksi</th>
                                                                    <th style="width: 33%;">Nominal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $totalTransaksi = 0;
                                                                    $totalNominal = 0;
                                                                @endphp
                                                                @foreach ($pengeluarans as $pengeluaran)
                                                                    @php
                                                                        $totalTransaksi +=
                                                                            $pengeluaran->total_transaksi;
                                                                        $totalNominal += $pengeluaran->total_nominal;
                                                                    @endphp
                                                                    <tr>
                                                                        <td><b>{{ $pengeluaran->nama_kategori_pengeluaran }}</b>
                                                                        </td>
                                                                        <td>{{ $pengeluaran->total_transaksi }}</td>
                                                                        <td>{{ rupiah($pengeluaran->total_nominal) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>Total</th>
                                                                    <th>{{ $totalTransaksi }}</th>
                                                                    <th>{{ rupiah($totalNominal) }}</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item" style="padding: 5px">
                                            <h2 class="accordion-header" id="headingThree">
                                                <b
                                                    style="color: {{ $nominalpemasukan - $nominalpengeluaran >= 0 ? 'green' : 'red' }};">
                                                    Sisa Hasil Pendapatan :
                                                    {{ rupiah($nominalpemasukan - $nominalpengeluaran) }}
                                                </b>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="alert alert-light" role="alert">
                                    <b>Laporan Pertumbuhan Pelanggan</b>
                                </div>

                                <!-- Pilihan tampilan grafik (harian, bulanan, tahunan) -->
                                <div class="mb-3">
                                    <select class="form-select" id="view-option" style="width: 200px;">
                                        <option value="daily">Harian</option>
                                        <option value="monthly">Bulanan</option>
                                        <option value="yearly">Tahunan</option>
                                    </select>
                                </div>
                                <div id="myChart"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('css')
    <link href="{{ asset('mazer/css/daterangepicker.min.css') }}" rel="stylesheet" />
@endpush


@push('js')
    @push('css')
        <link href="{{ asset('mazer/css/daterangepicker.min.css') }}" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.css" rel="stylesheet" />
    @endpush

    @push('js')
        <script type="text/javascript" src="{{ asset('mazer/js/moment.js') }}"></script>
        <script type="text/javascript" src="{{ asset('mazer/js/daterangepicker.min.js') }}"></script>
        <!-- Tambahkan ApexCharts JS -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.min.js"></script>
        <script>
            var start = {{ $microFrom }};
            var end = {{ $microTo }};
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
            }, function(start, end, label) {
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


        <!-- Your custom JavaScript code -->
        <script>
            $(document).ready(function() {
                fetchDataAndRenderChart('daily'); // Load chart with default 'daily' view
            });

            function fetchDataAndRenderChart(viewOption) {
                var startDate = $('#start_date').val(); // Get start date
                var endDate = $('#end_date').val(); // Get end date

                // Call API to fetch data based on viewOption
                $.ajax({
                    url: '/pelanggan-data', // Adjust to your API URL
                    method: 'GET',
                    data: {
                        view_option: viewOption,
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                        console.log(response);
                        renderChart(response, viewOption);
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            function renderChart(data, viewOption) {
                var labels = [];
                var counts = [];

                // Process data according to viewOption
                if (viewOption === 'daily') {
                    data.forEach(item => {
                        labels.push(item.date);
                        counts.push(item.count);
                    });
                } else if (viewOption === 'monthly') {
                    data.forEach(item => {
                        labels.push(item.year + '-' + item.month);
                        counts.push(item.count);
                    });
                } else if (viewOption === 'yearly') {
                    data.forEach(item => {
                        labels.push(item.year);
                        counts.push(item.count);
                    });
                }

                // Remove the previous chart if it exists
                if (typeof chart !== 'undefined') {
                    chart.destroy();
                }

                // Render new chart
                var options = {
                    chart: {
                        type: 'line',
                        height: 350
                    },
                    series: [{
                        name: 'Jumlah Pelanggan',
                        data: counts
                    }],
                    xaxis: {
                        categories: labels,
                        title: {
                            text: viewOption === 'daily' ? 'Tanggal' : (viewOption === 'monthly' ? 'Bulan' : 'Tahun')
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Jumlah Pelanggan'
                        }
                    }
                };

                chart = new ApexCharts(document.querySelector("#myChart"), options);
                chart.render();
            }

            // Trigger chart update on view option change
            $('#view-option').change(function() {
                var viewOption = $(this).val();
                fetchDataAndRenderChart(viewOption);
            });
        </script>
    @endpush

@endpush

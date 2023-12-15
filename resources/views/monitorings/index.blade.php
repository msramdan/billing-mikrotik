@extends('layouts.app')

@section('title', __('Monitorings'))


@push('css')
    <style>
        .card-footer {
            display: flex;
            justify-content: space-between;
            /* Membuat jarak seimbang di antara elemen */
            padding: 5px;
        }

        .card-footer a {
            color: grey;
            text-decoration: none;
            font-size: 12px;
            /* Menambahkan font size 10px */
        }
    </style>
    <style>
        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            /* Transparan white background */
            z-index: 1000;
            text-align: center;
        }

        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <style>
        canvas {
            width: 100% !important;
            /* height: 270px !important; */
        }
    </style>
    <style>
        .map-embed {
            width: 100%;
            height: 510px;
        }

        a.resultnya {
            color: #1e7ad3;
            text-decoration: none;
        }

        a.resultnya:hover {
            text-decoration: underline
        }

        .search-box {
            position: relative;
            margin: 0 auto;
            width: 300px;
        }

        .search-box input#search-loc {
            height: 26px;
            width: 100%;
            padding: 0 12px 0 25px;
            background: white url("https://cssdeck.com/uploads/media/items/5/5JuDgOa.png") 8px 6px no-repeat;
            border-width: 1px;
            border-style: solid;
            border-color: #a8acbc #babdcc #c0c3d2;
            border-radius: 13px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -o-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            -moz-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            -ms-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            -o-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
            box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
        }

        .search-box input#search-loc:focus {
            outline: none;
            border-color: #66b1ee;
            -webkit-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            -moz-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            -ms-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            -o-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
            box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
        }

        .search-box .results {
            display: none;
            position: absolute;
            top: 35px;
            left: 0;
            right: 0;
            z-index: 9999;
            padding: 0;
            margin: 0;
            border-width: 1px;
            border-style: solid;
            border-color: #cbcfe2 #c8cee7 #c4c7d7;
            border-radius: 3px;
            background-color: #fdfdfd;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fdfdfd), color-stop(100%, #eceef4));
            background-image: -webkit-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: -moz-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: -ms-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: -o-linear-gradient(top, #fdfdfd, #eceef4);
            background-image: linear-gradient(top, #fdfdfd, #eceef4);
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -ms-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -o-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            overflow: hidden auto;
            max-height: 34vh;
        }

        .search-box .results li {
            display: block
        }

        .search-box .results li:first-child {
            margin-top: -1px
        }

        .search-box .results li:first-child:before,
        .search-box .results li:first-child:after {
            display: block;
            content: '';
            width: 0;
            height: 0;
            position: absolute;
            left: 50%;
            margin-left: -5px;
            border: 5px outset transparent;
        }

        .search-box .results li:first-child:before {
            border-bottom: 5px solid #c4c7d7;
            top: -11px;
        }

        .search-box .results li:first-child:after {
            border-bottom: 5px solid #fdfdfd;
            top: -10px;
        }

        .search-box .results li:first-child:hover:before,
        .search-box .results li:first-child:hover:after {
            display: none
        }

        .search-box .results li:last-child {
            margin-bottom: -1px
        }

        .search-box .results a {
            display: block;
            position: relative;
            margin: 0 -1px;
            padding: 6px 40px 6px 10px;
            color: #808394;
            font-weight: 500;
            text-shadow: 0 1px #fff;
            border: 1px solid transparent;
            border-radius: 3px;
        }

        .search-box .results a span {
            font-weight: 200
        }

        .search-box .results a:before {
            content: '';
            width: 18px;
            height: 18px;
            position: absolute;
            top: 50%;
            right: 10px;
            margin-top: -9px;
            background: url("https://cssdeck.com/uploads/media/items/7/7BNkBjd.png") 0 0 no-repeat;
        }

        .search-box .results a:hover {
            text-decoration: none;
            color: #fff;
            text-shadow: 0 -1px rgba(0, 0, 0, 0.3);
            border-color: #2380dd #2179d5 #1a60aa;
            background-color: #338cdf;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #59aaf4), color-stop(100%, #338cdf));
            background-image: -webkit-linear-gradient(top, #59aaf4, #338cdf);
            background-image: -moz-linear-gradient(top, #59aaf4, #338cdf);
            background-image: -ms-linear-gradient(top, #59aaf4, #338cdf);
            background-image: -o-linear-gradient(top, #59aaf4, #338cdf);
            background-image: linear-gradient(top, #59aaf4, #338cdf);
            -webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            -moz-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            -ms-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            -o-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
            box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
        }

        .lt-ie9 .search input#search-loc {
            line-height: 26px
        }

        .my-custom-scrollbar {
            position: relative;
            height: 270px;
            overflow: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 360px;
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

        .radius-10 {
            border-radius: 10px !important;
        }

        .border-info {
            border-left: 5px solid #0dcaf0 !important;
        }

        .border-danger {
            border-left: 5px solid #fd3550 !important;
        }

        .border-success {
            border-left: 5px solid #24695c !important;
        }

        .border-warning {
            border-left: 5px solid #ffc107 !important;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0px solid rgba(0, 0, 0, 0);
            border-radius: .25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);
        }

        .bg-gradient-scooter {
            background: #17ead9;
            background: -webkit-linear-gradient(45deg, #17ead9, #6078ea) !important;
            background: linear-gradient(45deg, #17ead9, #6078ea) !important;
        }

        .widgets-icons-2 {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ededed;
            font-size: 27px;
            border-radius: 10px;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .text-white {
            color: #fff !important;
        }

        .ms-auto {
            margin-left: auto !important;
        }

        .bg-gradient-bloody {
            background: #f54ea2;
            background: -webkit-linear-gradient(45deg, #f54ea2, #ff7676) !important;
            background: linear-gradient(45deg, #f54ea2, #ff7676) !important;
        }

        .bg-gradient-ohhappiness {
            background: #00b09b;
            background: -webkit-linear-gradient(45deg, #00b09b, #96c93d) !important;
            background: linear-gradient(45deg, #00b09b, #96c93d) !important;
        }

        .bg-gradient-blooker {
            background: #ffdf40;
            background: -webkit-linear-gradient(45deg, #ffdf40, #ff8359) !important;
            background: linear-gradient(45deg, #ffdf40, #ff8359) !important;
        }
    </style>
@endpush

@section('content')

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Detail</h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <table class="table" style="line-height: 11px">
                        <tbody>
                            <tr>
                                <th scope="row">Onu ID</th>
                                <td>:</td>
                                <td><span id="modalOnuId"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Name</th>
                                <td>:</td>
                                <td><span id="modalName"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">SN</th>
                                <td>:</td>
                                <td><span id="modalSN"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Vlan</th>
                                <td>:</td>
                                <td><span id="modalVlan"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">UP</th>
                                <td>:</td>
                                <td>
                                    <p>RX : <span id="modal_up_rx"></span></p>
                                    <p>TX : <span id="modal_up_tx"></p>
                                    <p>Attenuation : <span id="modal_up_att"></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Down</th>
                                <td>:</td>
                                <td>
                                    <p>RX : <span id="modal_down_rx"></span></p>
                                    <p>TX : <span id="modal_down_tx"></p>
                                    <p>Attenuation : <span id="modal_down_att"></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>



    <div id="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Monitorings') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all monitorings.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Monitorings') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="container mt-5">
                            <div class="card"
                                style="background: linear-gradient(to right, #4CAF50, #3498db); color: #fff;">
                                <div class="card-body">
                                    <div class="col-md-3">
                                        <select name="status" id="oltSelect" class="form-control">
                                            <option value="" selected disabled>-- Select OLT -- </option>
                                            @foreach ($olts as $row)
                                                <option value="{{ $row->id }}"
                                                    {{ session('sessionOlt') == $row->id ? 'selected' : '' }}>
                                                    {{ $row->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="row">
                    <div class="col-xl-4 col-sm-6 box-col-4">
                        <div class="card radius-10 border-start border-0 border-3 border-secondary">
                            <div class="card-body" style="padding: 10px">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Waiting Auth</p>
                                        <h4 class="my-1 text-primary">
                                            <a href="/hotspotactives" class=""> {{ $uncf }} </a>
                                        </h4>

                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                            class="fa fa-bell" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="#"><b>Klik For Register: {{ $uncf }} Gpon</b></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 box-col-4">
                        <div class="card radius-10 border-start border-0 border-3 border-success">
                            <div class="card-body" style="padding: 10px">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Online</p>
                                        <h4 class="my-1 text-primary"><a href="#" class="">
                                                {{ $online }} </a>
                                        </h4>

                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                            class="fa fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" style="padding: 5px">
                                <a href="#" style="color: grey"><b>Total Auth : {{ $total_auth }}</b> </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 box-col-4">
                        <div class="card radius-10 border-start border-0 border-3 border-danger">
                            <div class="card-body" style="padding: 10px">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Offline</p>
                                        <h4 class="my-1 text-primary"><a href="#" class="">
                                                {{ $offline }} </a>
                                        </h4>

                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                            class="fa fa-times"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                @foreach ($groupedCounts as $phase => $jumlah)
                                    @if ($phase !== 'working')
                                        <a href="#"><b>{{ $phase }}: {{ $jumlah }}</b></a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="example" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Onu ID') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Reason') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($list_olt as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->index }}</td>
                                                <td>{{ $item->name }}</td>
                                                @if ($item->phase == 'working')
                                                    <td><span style="color: green"><i class="fa fa-globe"
                                                                aria-hidden="true"></i> Online</span></td>
                                                @else
                                                    <td><span style="color: red"><i class="fa fa-globe"
                                                                aria-hidden="true"></i> Offline</span></td>
                                                @endif

                                                @if ($item->phase == 'working')
                                                    <td><span style="color: green">{{ $item->phase }}</span></td>
                                                @else
                                                    <td><span style="color: red">{{ $item->phase }}</span></td>
                                                @endif
                                                <td><button type="button" class="btn btn-primary open-modal-btn"
                                                        data-onu="{{ $item->index }}"
                                                        data-name="{{ $item->name }}">detail
                                                    </button></td>
                                            </tr>
                                        @endforeach

                                    </tbody>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.css" />
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script>
        $(".open-modal-btn").click(function() {
            var onuIndex = $(this).data('onu');
            var onuName = $(this).data('name');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $('#loading-overlay').show();
            $.ajax({
                type: "POST",
                url: '{{ route('detailOlt') }}',
                data: {
                    onu_id: onuIndex,
                    _token: csrfToken
                },
                success: function(response) {
                    $('#loading-overlay').hide();
                    $("#modalOnuId").text(onuIndex);
                    $("#modalName").text(onuName);
                    $("#modalSN").text(response.result.status.data.serial_number);
                    $("#modalVlan").text(response.result.onuName.data);
                    $("#modal_up_rx").text(response.result.uncf.data.up.Rx);
                    $("#modal_up_tx").text(response.result.uncf.data.up.Tx);
                    $("#modal_up_att").text(response.result.uncf.data.up.Attenuation);
                    $("#modal_down_rx").text(response.result.uncf.data.down.Rx);
                    $("#modal_down_tx").text(response.result.uncf.data.down.Tx);
                    $("#modal_down_att").text(response.result.uncf.data.down.Attenuation);
                    $('#myModal').modal('show');
                    console.log(response);
                },
                error: function(error) {
                    console.error('Error:', error);
                },
            });
        });

        $(document).ready(function() {
            new DataTable('#example', {
                info: true,
                ordering: true,
                paging: true
            });

            addLoadingOverlay();
            $(".open-modal-btn").click(function() {
                var onuIndex = $(this).data('onu');
                var onuName = $(this).data('name');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                showLoadingIndicator();
                $.ajax({
                    type: "POST",
                    url: '{{ route('detailOlt') }}',
                    data: {
                        onu_id: onuIndex,
                        _token: csrfToken
                    },
                    success: function(response) {
                        hideLoadingIndicator();
                        $("#modalOnuId").text(onuIndex);
                        $("#modalName").text(onuName);
                        $("#modalSN").text(response.result.status.data.serial_number);
                        $("#modalVlan").text(response.result.onuName.data);
                        $("#modal_up_rx").text(response.result.uncf.data.up.Rx);
                        $("#modal_up_tx").text(response.result.uncf.data.up.Tx);
                        $("#modal_up_att").text(response.result.uncf.data.up.Attenuation);
                        $("#modal_down_rx").text(response.result.uncf.data.down.Rx);
                        $("#modal_down_tx").text(response.result.uncf.data.down.Tx);
                        $("#modal_down_att").text(response.result.uncf.data.down.Attenuation);
                        $('#myModal').modal('show');
                        console.log(response);
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    },
                });
            });

            $('#oltSelect').on('change', function() {
                var selectedValue = $(this).val();
                changeSession(selectedValue);
            });

            function changeSession(selectedValue) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                showLoadingIndicator();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('oltSelect') }}',
                    data: {
                        selectedValue: selectedValue,
                        _token: csrfToken
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: 'Pilih OLT Berhasil.',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Pilih OLT Gagal.',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat mengirim permintaan.',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                });
            }

            function addLoadingOverlay() {
                $('body').append('<div id="loading-overlay"><div class="loading-spinner"></div></div>');
            }

            function showLoadingIndicator() {
                $('#loading-overlay').show();
            }

            function hideLoadingIndicator() {
                $('#loading-overlay').hide();
            }
        });
    </script>
@endpush

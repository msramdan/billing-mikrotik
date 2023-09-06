@extends('layouts.app')

@section('title', __('Dashboard'))


@push('css')
    <style>
        canvas {
            width: 100% !important;
            /* height: 270px !important; */
        }
    </style>
    <style>
        .map-embed {
            width: 100%;
            height: 400px;
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
    </style>
@endpush

@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-xl-3 col-sm-6 box-col-3">
                <div class="card radius-10 border-start border-0 border-3 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Hotspot aktif</p>
                                <h4 class="my-1 text-primary"><a href="#" class="" data-bs-toggle="modal"
                                        data-bs-target="#modalBrancError">
                                        XXXX Data </a>
                                </h4>

                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                    class="fa fa-database"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 box-col-3">
                <div class="card radius-10 border-start border-0 border-3 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Ppp aktif</p>
                                <h4 class="my-1 text-primary"><a href="#" class="" data-bs-toggle="modal"
                                        data-bs-target="#modalBrancError">
                                        XXXX Data </a>
                                </h4>

                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                    class="fa fa-database"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 box-col-3">
                <div class="card radius-10 border-start border-0 border-3 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Ppp tidak aktif</p>
                                <h4 class="my-1 text-primary"><a href="#" class="" data-bs-toggle="modal"
                                        data-bs-target="#modalBrancError">
                                        XXXX Data </a>
                                </h4>

                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                    class="fa fa-database"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 box-col-3">
                <div class="card radius-10 border-start border-0 border-3 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Area Coverage</p>
                                <h4 class="my-1 text-primary"><a href="#" class="" data-bs-toggle="modal"
                                        data-bs-target="#modalBrancError">
                                        {{ $countAreaCoverage}} Data </a>
                                </h4>

                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                    class="fa fa-database"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 box-col-3">
                <div class="card radius-10 border-start border-0 border-3 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Pelanggan</p>
                                <h4 class="my-1 text-primary"><a href="#" class="" data-bs-toggle="modal"
                                        data-bs-target="#modalBrancError">
                                        {{$countPelanggan}} Data </a>
                                </h4>

                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                    class="fa fa-database"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 box-col-3">
                <div class="card radius-10 border-start border-0 border-3 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Pelanggan Aktif</p>
                                <h4 class="my-1 text-primary"><a href="#" class="" data-bs-toggle="modal"
                                        data-bs-target="#modalBrancError">
                                        {{$countPelangganAktif}} Data </a>
                                </h4>

                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                    class="fa fa-database"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 box-col-3">
                <div class="card radius-10 border-start border-0 border-3 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Pelanggan Non Aktif</p>
                                <h4 class="my-1 text-primary"><a href="#" class="" data-bs-toggle="modal"
                                        data-bs-target="#modalBrancError">
                                        {{$countPelangganNon}} Data </a>
                                </h4>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                    class="fa fa-database"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 box-col-3">
                <div class="card radius-10 border-start border-0 border-3 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Pelanggan Menungu</p>
                                <h4 class="my-1 text-primary"><a href="#" class="" data-bs-toggle="modal"
                                        data-bs-target="#modalBrancError">
                                        {{$countPelangganMenunggu}} Data </a>
                                </h4>

                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                    class="fa fa-database"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="row">
            <div class="col-sm-4 col-sm-4">
                <div class="card"  style="height: 370px">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Status Tagihan
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart"> </canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-sm-4">
                <div class="card"  style="height: 370px">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Pemasukan VS Pengeluaran
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart2"> </canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4">
                <div class="card" style="height: 370px">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            10 Pemasukan Terbaru
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive p-1">
                            <table class="table table-striped" id="data-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('Nominal') }}</th>
                                        <th>{{ __('Tanggal') }}</th>
                                        <th>{{ __('Keterangan') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card" style="height: 550px">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Lokasi Pelanggan</h4>
                    </div>
                    <div class="card-body">
                        <div class="map-embed" id="map" style="height: 100%; z-index: 0;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Sudah Bayar', 'Belum Bayar'],
                datasets: [{
                    label: '# Total',
                    data: [
                        {{ totalStatusBayar('Sudah Bayar') }},
                        {{ totalStatusBayar('Belum Bayar') }}
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        const ctx2 = document.getElementById('myChart2');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Pemasukan', 'Pemasukan'],
                datasets: [{
                    label: '# Total',
                    data: [
                        {{ totalStatusBayar('Sudah Bayar') }},
                        {{ totalStatusBayar('Belum Bayar') }}
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        const ctx3 = document.getElementById('myChart3');
        new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ['Aktif', 'Non Aktif', 'Menungu'],
                datasets: [{
                    label: '# Total',
                    data: [
                        {{ totalStatusBayar('Sudah Bayar') }},
                        {{ totalStatusBayar('Belum Bayar') }},
                        {{ totalStatusBayar('Belum Bayar') }}
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var i = 1;

            function checkKosongLatLong() {
                if ($('#latitude').val() == '' || $('#longitude').val() == '') {
                    $('.alert-choose-loc').show();
                } else {
                    $('.alert-choose-loc').hide();
                }
            }
            var delay = (function() {
                var timer = 0;
                return function(callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })()
            // initialize map
            const getLocationMap = L.map('map');
            // initialize OSM
            const osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            const osmAttrib = 'Leaflet © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
            const osm = new L.TileLayer(osmUrl, {
                // minZoom: 0,
                // maxZoom: 3,
                attribution: osmAttrib
            });
            // render map
            getLocationMap.scrollWheelZoom.disable()
            @foreach ($pelanggan as $ins)
                getLocationMap.setView(new L.LatLng("{{ $ins->latitude }}", "{{ $ins->longitude }}"), 7);
            @endforeach
            getLocationMap.addLayer(osm)
            let location = '';

            @foreach ($pelanggan as $pelanggan)
                getToLoc("{{ $pelanggan->latitude }}", "{{ $pelanggan->longitude }}", getLocationMap,
                    "{{ $pelanggan->id }}", "{{ $pelanggan->nama }}", "pelanggan");
            @endforeach

            function getToLoc(lat, lng, getLocationMap, id, name, type) {
                const zoom = 1;
                var url_edit = "";
                $.ajax({
                    url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`,
                    dataType: 'json',
                    success: function(result) {
                        var marker = L.marker([lat, lng], {
                            icon: L.AwesomeMarkers.icon({
                                icon: 'users',
                                prefix: 'fa',
                                markerColor: 'darkblue',
                            })
                        }).addTo(getLocationMap);
                        let list_of_location_html = '';
                        list_of_location_html += '<div>';
                        list_of_location_html += `<b>Pelanggan : ${name}</b><br>`;
                        list_of_location_html += `<b>${result.display_name}</b><br>`;
                        list_of_location_html += `<span>latitude : ${result.lat}</span><br>`;
                        list_of_location_html += `<span>longitude: ${result.lon}</span><br>`;
                        list_of_location_html += '</div>';
                        marker.bindPopup(list_of_location_html);

                    }
                });
            }
        });
    </script>
@endpush

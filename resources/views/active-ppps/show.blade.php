@extends('layouts.app')

@section('title', __('Detail of Active PPP'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Active PPP') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of Active PPP.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('active-ppps.index') }}">{{ __('Active PPP') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Detail') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <?php
                                        foreach ($pppuser as $dataku) {
                                            $id = str_replace('*', '', $dataku['.id']);
                                        ?>
                                    <tr>
                                        <td>Nama Pengguna</td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>:</td>
                                        <td>&nbsp;</td>
                                        <td><?= $dataku['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Password Akun</td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>:</td>
                                        <td>&nbsp;</td>
                                        <td><?= $dataku['password'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Paket Pengguna</td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>:</td>
                                        <td>&nbsp;</td>
                                        <td><?= $dataku['profile'] ?></td>
                                    </tr>
                                    <?php
                                            foreach ($pppactive as $mydata) {
                                            ?>
                                    <tr>
                                        <td>IP Address</td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>:</td>
                                        <td>&nbsp;</td>
                                        <td><?= $mydata['address'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Aktif Selama</td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>:</td>
                                        <td>&nbsp;</td>
                                        <td><?= $mydata['uptime'] ?></td>
                                    </tr>
                                    <?php
                                            }
                                            ?>
                                    <tr>
                                        <td>Status Pengguna</td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>:</td>
                                        <td>&nbsp;</td>
                                        <td>
                                            @if (count($pppactive) > 0)
                                                Online
                                            @else
                                                Offline
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Komentar</td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>:</td>
                                        <td>&nbsp;</td>
                                        <td><?= isset($dataku['comment']) ? $dataku['comment'] : '-' ?></td>
                                    </tr>
                                    <?php } ?>
                                </table>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Interace</th>
                                            <th>Upload</th>
                                            <th>Download</th>
                                        </tr>
                                        <tr>
                                            <?php
                                    foreach ($pppuser as $dataku) {
                                    ?>
                                            <td width="40%">
                                                <input name="interface" id="interface" type="hidden"
                                                    value="<?= $dataku['name'] ?>" readonly>
                                                pppoe-<?= $dataku['name'] ?>
                                            </td>
                                            <?php } ?>
                                            <td width="30%">
                                                <div id="tabletx"></div>
                                            </td>
                                            <td width="30%">
                                                <div id="tablerx"></div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="graph"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"
        integrity="sha512-jGR1T3dQerLCSm/IGEGbndPwzszJBlKQ5Br9vuB0Pw2iyxOy+7AK+lJcCC8eaXyz/9du+bkCy4HXxByhxkHf+w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"
        integrity="sha384-XEerZL0cuoUbHE4nZReLT7nx9gQrQreJekYhJD9WNWhH8nEW+0c5qq7aIo2Wl30J" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="{{ asset('highchart/js/highcharts.js') }}"></script>
    <script>
        var chart;

        function requestDatta(interface) {
            $.ajax({
                url: '/monitoring?interface=' + interface,
                datatype: "json",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    var midata = JSON.parse(data);
                    console.log(data);
                    console.log(midata);
                    if (midata.length > 0) {
                        var TX = parseInt(midata[0].data);
                        var RX = parseInt(midata[1].data);
                        var x = (new Date()).getTime();
                        shift = chart.series[0].data.length > 19;
                        chart.series[0].addPoint([x, TX], true, shift);
                        chart.series[1].addPoint([x, RX], true, shift);
                        document.getElementById("tabletx").innerHTML = convert(TX);
                        document.getElementById("tablerx").innerHTML = convert(RX);
                    } else {
                        document.getElementById("tabletx").innerHTML = "0";
                        document.getElementById("tablerx").innerHTML = "0";
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.error("Status: " + textStatus + " request: " + XMLHttpRequest);
                    console.error("Error: " + errorThrown);
                }
            });
        }

        $(document).ready(function() {
            Highcharts.setOptions({
                global: {
                    useUTC: false
                }
            });
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'graph',
                    animation: Highcharts.svg,
                    type: 'spline',
                    events: {
                        load: function() {
                            setInterval(function() {
                                requestDatta(document.getElementById("interface").value);
                            }, 1000);
                        }
                    }
                },
                title: {
                    text: 'Monitoring'
                },
                xAxis: {
                    type: 'datetime',
                    tickPixelInterval: 150,
                    maxZoom: 20 * 1000
                },

                yAxis: {
                    minPadding: 0.2,
                    maxPadding: 0.2,
                    title: {
                        text: 'Traffic'
                    },
                    labels: {
                        formatter: function() {
                            var bytes = this.value;
                            var sizes = ['b/s', 'Kb/s', 'Mb/s', 'Gb/s', 'Tb/s'];
                            if (bytes == 0) return '0 b/s';
                            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                            return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
                        },
                    },
                },
                series: [{
                    name: 'TX',
                    data: []
                }, {
                    name: 'RX',
                    data: []
                }],
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br/>',
                    pointFormat: '{point.x:%Y-%m-%d %H:%M:%S}<br/>{point.y}'
                },
            });
        });

        function convert(bytes) {

            var sizes = ['b/s', 'Kb/s', 'Mb/s', 'Gb/s', 'Tb/s'];
            if (bytes == 0) return '0 b/s';
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
            return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
@endpush

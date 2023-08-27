@extends('layouts.app')

@section('title', __('Detail of Status Router'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Status Router') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of Status Router.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('statusrouters.index') }}">{{ __('Status Router') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Detail') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-info" role="alert">
                                <h5 style="text-align: center;color:white">
                                    Router Sudah Terkoneksi Saat Ini
                                </h5>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped" width="100%">
                                    <thead>
                                        <tr style="text-align: center">
                                            <th colspan="6">Identitas Router : <?= $identity ?> (<?= $date ?> -
                                                <?= $time ?> WIB) <br>
                                                <b>Router Os : Version <?= $version ?> </b>

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center;" width="5%">1</td>
                                            <td width="15%">CPU Count</td>
                                            <td width="30%"><?= $cpucount ?> Core &nbsp; ( Freq. : <?= $frequency ?> Mhz
                                                )</td>
                                            <td style="text-align: center;" width="5%">7</td>
                                            <td width="15%">Router Uptime</td>
                                            <td width="30%"><?= $uptime ?> </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center;" width="5%">2</td>
                                            <td width="15%">CPU Load</td>
                                            <td width="30%"><?= $cpuload ?> % &nbsp; ( <?= $cpuname ?> )</td>
                                            <td style="text-align: center;" width="5%">8</td>
                                            <td width="15%">Dapat IP Public</td>
                                            <td width="30%"><?= $publicrouter ?></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center;" width="5%">3</td>
                                            <td width="15%">Free Memory</td>
                                            <td width="30%">
                                                {{ formatBytes($freememory, 2) }} / {{ formatBytes($totalmemory, 2) }}
                                            </td>
                                            <td style="text-align: center;" width="5%">9</td>
                                            <td width="15%">Hotspot Active</td>
                                            <td width="30%"><?= $hotspotactive ?> Device</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center;" width="5%">4</td>
                                            <td width="15%">Free HDD</td>
                                            <td width="30%">
                                                {{ formatBytes($freehdd, 2) }} / {{ formatBytes($totalhdd, 2) }}
                                            </td>
                                            <td style="text-align: center;" width="5%">10</td>
                                            <td width="15%">Users Hotspot</td>
                                            <td width="30%"><?= $hotspotuser ?> Voucher</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center;" width="5%">5</td>
                                            <td width="15%">RouterBoard</td>
                                            <td width="30%"><?= $boardname ?> &nbsp; ( <?= $architecture ?> )</td>
                                            <td style="text-align: center;" width="5%">11</td>
                                            <td width="15%">PPP Active</td>
                                            <td width="30%"><?= $pppactive ?> Customer</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center;" width="5%">6</td>
                                            <td width="15%">Level Lisence</td>
                                            <td width="30%"><?= $level ?> &nbsp; ( SW ID : <?= $software ?> )</td>
                                            <td style="text-align: center;" width="5%">12</td>
                                            <td width="15%">Secret PPP</td>
                                            <td width="30%"><?= $pppsecrets ?> Account</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <img class="img-thumbnail" src="{{ asset('mazer/router-hacking.webp') }}" alt=""
                                    style="width: 100%">
                                <br>
                                <br>
                                <a href=""
                                    onclick="return confirm('Apakah anda yakin akan merestart Router <?= $identity ?> ?')"
                                    class="d-sm-inline-block btn btn-primary shadow-sm">
                                    <i class="fa fa-power-off fa-sm text-white-50"></i><i class="fa fa-refresh"
                                        aria-hidden="true"></i> Reboot MikroTik Now
                                </a>
                                <h4 style="margin-top: 10px">{{ getRoute()->identitas_router }}</h4>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

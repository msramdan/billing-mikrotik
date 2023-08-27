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
                                        <td>-
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

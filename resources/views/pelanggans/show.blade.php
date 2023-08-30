@extends('layouts.app')

@section('title', __('Detail of Pelanggans'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Pelanggans') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of pelanggan.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('pelanggans.index') }}">{{ __('Pelanggans') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Detail') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <tr>
                                        <td class="fw-bold">{{ __('Area Coverage') }}</td>
                                        <td>{{ $pelanggan->kode_area }} - {{ $pelanggan->nama_area }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Odc') }}</td>
                                        <td>{{ $pelanggan->kode_odc }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Odp') }}</td>
                                        <td>{{ $pelanggan->kode_odp }}</td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('No Port Odp') }}</td>
                                            <td>{{ $pelanggan->no_port_odp }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('No Layanan') }}</td>
                                            <td>{{ $pelanggan->no_layanan }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Nama') }}</td>
                                            <td>{{ $pelanggan->nama }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Tanggal Daftar') }}</td>
                                            <td>{{ $pelanggan->tanggal_daftar  }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Email') }}</td>
                                            <td>{{ $pelanggan->email }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('No Wa') }}</td>
                                            <td>{{ $pelanggan->no_wa }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('No Ktp') }}</td>
                                            <td>{{ $pelanggan->no_ktp }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Photo Ktp') }}</td>
                                        <td>
                                            @if ($pelanggan->photo_ktp == null)
                                            <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Photo Ktp"  class="rounded" width="200" height="150" style="object-fit: cover">
                                            @else
                                                <img src="{{ asset('storage/uploads/photo_ktps/' . $pelanggan->photo_ktp) }}" alt="Photo Ktp" class="rounded" width="200" height="150" style="object-fit: cover">
                                            @endif
                                        </td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Alamat') }}</td>
                                            <td>{{ $pelanggan->alamat }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Ppn') }}</td>
                                            <td>{{ $pelanggan->ppn }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Status Berlangganan') }}</td>
                                            <td>{{ $pelanggan->status_berlangganan }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Package') }}</td>
                                        <td>{{ $pelanggan->nama_layanan }} - {{ $pelanggan->harga }}</td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Jatuh Tempo') }}</td>
                                            <td>{{ $pelanggan->jatuh_tempo }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Kirim Tagihan Wa') }}</td>
                                            <td>{{ $pelanggan->kirim_tagihan_wa }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Latitude') }}</td>
                                            <td>{{ $pelanggan->latitude }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Longitude') }}</td>
                                            <td>{{ $pelanggan->longitude }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Auto Isolir') }}</td>
                                            <td>{{ $pelanggan->auto_isolir }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Tempo Isolir') }}</td>
                                            <td>{{ $pelanggan->tempo_isolir }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Settingmikrotik') }}</td>
                                        <td>{{ $pelanggan->identitas_router }}</td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('User Pppoe') }}</td>
                                            <td>{{ $pelanggan->user_pppoe }}</td>
                                        </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $pelanggan->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $pelanggan->updated_at }}</td>
                                    </tr>
                                </table>
                            </div>

                            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

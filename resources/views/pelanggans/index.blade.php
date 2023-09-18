@extends('layouts.app')

@section('title', __('Pelanggans'))


@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Pelanggans') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all pelanggans.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Pelanggans') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

            @can('pelanggan create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('pelanggans.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Create a new pelanggan') }}
                    </a>
                </div>
            @endcan

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-4">
                                <div class="alert alert-success" role="alert">
                                    <i class="fa fa-money-bill" aria-hidden="true"></i> Estimasi Pendapatan / Bulan : <br>
                                    <b>{{ rupiah($pendapatan) }}</b>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <select name="area_coverage" id="area_coverage"
                                                class="form-control  js-example-basic-single">
                                                <option value="All">All Area Coverage
                                                </option>
                                                @foreach ($areaCoverages as $row)
                                                    <option value="{{ $row->id }}">{{ $row->kode_area }} -
                                                        {{ $row->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="status" id="status"
                                                class="form-control  js-example-basic-single">
                                                <option value="All">All Status Berlangganan
                                                </option>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Non Aktif">Non Aktif</option>
                                                <option value="Menunggu">Menunggu</option>
                                                <option value="Tunggakan">Tunggakan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="packagePilihan" id="packagePilihan"
                                                class="form-control  js-example-basic-single">
                                                <option value="All">All Package</option>
                                                @foreach ($package as $row)
                                                    <option value="{{ $row->id }}">{{ $row->nama_layanan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="mikrotik" id="mikrotik"
                                                class="form-control  js-example-basic-single">
                                                <option value="All">All Route Mikrotik</option>
                                                @foreach ($router as $row)
                                                    <option value="{{ $row->id }}">{{ $row->identitas_router }}
                                                    </option>
                                                @endforeach
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
                                            <th>{{ __('Area Coverage') }}</th>
                                            <th>{{ __('No Layanan') }}</th>
                                            <th>{{ __('Nama') }}</th>
                                            <th>{{ __('Tanggal Daftar') }}</th>
                                            <th>{{ __('Wa') }}</th>
                                            <th>{{ __('No Ktp') }}</th>
                                            <th>{{ __('Status Berlangganan') }}</th>
                                            <th>{{ __('Package') }}</th>
                                            <th>{{ __('Router') }}</th>
                                            <th>{{ __('Mode User') }}</th>
                                            <th>{{ __('User') }}</th>
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
        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'area_coverage',
                name: 'area_coverage.kode_area'
            },
            {
                data: 'no_layanan',
                name: 'no_layanan',
            },
            {
                data: 'nama',
                name: 'nama',
            },
            {
                data: 'tanggal_daftar',
                name: 'tanggal_daftar',
            },
            {
                data: 'no_wa',
                name: 'no_wa',
            },
            {
                data: 'no_ktp',
                name: 'no_ktp',
            },
            {
                data: 'status_berlangganan',
                name: 'status_berlangganan',
            },
            {
                data: 'package',
                name: 'package.nama_layanan'
            },
            {
                data: 'settingmikrotik',
                name: 'settingmikrotik',
            },
            {
                data: 'mode_user',
                name: 'mode_user',
            },
            {
                data: 'user_mikrotik',
                name: 'user_mikrotik',
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
                url: "{{ route('pelanggans.index') }}",
                data: function(s) {
                    s.area_coverage = $('select[name=area_coverage] option').filter(':selected').val()
                    s.status = $('select[name=status] option').filter(':selected').val()
                    s.packagePilihan = $('select[name=packagePilihan] option').filter(':selected').val()
                    s.mikrotik = $('select[name=mikrotik] option').filter(':selected').val()
                }
            },
            columns: columns
        });

        $('#area_coverage').change(function() {
            table.draw();
        })
        $('#status').change(function() {
            table.draw();
        })
        $('#packagePilihan').change(function() {
            table.draw();
        })
        $('#mikrotik').change(function() {
            table.draw();
        })
    </script>
@endpush

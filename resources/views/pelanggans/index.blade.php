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
                                        <div class="col-md-2">
                                            <select name="packagePilihan" id="packagePilihan"
                                                class="form-control  js-example-basic-single">
                                                <option value="All">All Package</option>
                                                @foreach ($package as $row)
                                                    <option value="{{ $row->id }}">{{ $row->nama_layanan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="mikrotik" id="mikrotik"
                                                class="form-control  js-example-basic-single">
                                                <option value="All">All Route Mikrotik</option>
                                                @foreach ($router as $row)
                                                    <option value="{{ $row->id }}">{{ $row->identitas_router }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="mode_user" id="mode_user"
                                                class="form-control  js-example-basic-single">
                                                <option value="All">All Mode User
                                                </option>
                                                <option value="PPOE">PPOE</option>
                                                <option value="Static">Static</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="tgl_daftar" id="tgl_daftar"
                                                class="form-control js-example-basic-single">
                                                <option value="All">All Tanggal Daftar</option>
                                                <option value="01">1</option>
                                                <option value="02">2</option>
                                                <option value="03">3</option>
                                                <option value="04">4</option>
                                                <option value="05">5</option>
                                                <option value="06">6</option>
                                                <option value="07">7</option>
                                                <option value="08">8</option>
                                                <option value="09">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                                <option value="31">31</option>
                                            </select>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive p-1">
                                <table id="data-table" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('No Layanan') }}</th>
                                            <th>{{ __('Nama') }}</th>
                                            <th>{{ __('Otomatis Generate Tagihan') }}</th>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
@endpush

@push('js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        function format(d) {
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td>Area Coverage</td>' +
                '<td>' + d.area_coverage + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Tanggal Daftar</td>' +
                '<td>' + d.tanggal_daftar + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Wa</td>' +
                '<td>' + d.no_wa + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>No Ktp</td>' +
                '<td>' + d.no_ktp + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Status Berlangganan</td>' +
                '<td>' + d.status_berlangganan + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Package</td>' +
                '<td>' + d.package + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Router</td>' +
                '<td>' + d.settingmikrotik + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Mode User</td>' +
                '<td>' + d.mode_user + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>User</td>' +
                '<td>' + d.user_mikrotik + '</td>' +
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
                data: 'no_layanan',
                name: 'no_layanan',
            },
            {
                data: 'nama',
                name: 'nama',
            },
            {
                data: 'is_generate_tagihan',
                name: 'is_generate_tagihan',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    let checked = data === "Yes" ? "checked" : "";
                    return `
                <div class="form-check form-switch">
                    <input class="form-check-input toggle-generate" type="checkbox" data-id="${row.id}" ${checked}>
                </div>
            `;
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
                url: "{{ route('pelanggans.index') }}",
                data: function(s) {
                    s.area_coverage = $('select[name=area_coverage] option').filter(':selected').val()
                    s.status = $('select[name=status] option').filter(':selected').val()
                    s.mode_user = $('select[name=mode_user] option').filter(':selected').val()
                    s.packagePilihan = $('select[name=packagePilihan] option').filter(':selected').val()
                    s.mikrotik = $('select[name=mikrotik] option').filter(':selected').val()
                    s.tgl_daftar = $('select[name=tgl_daftar] option').filter(':selected').val()
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
        $('#mode_user').change(function() {
            table.draw();
        })

        $('#tgl_daftar').change(function() {
            table.draw();
        })
    </script>

    <script>
        $(document).on('change', '.toggle-generate', function() {
            let id = $(this).data('id');
            let is_generate = $(this).is(':checked') ? "Yes" : "No";

            $.ajax({
                url: "{{ route('pelanggans.update_generate_tagihan') }}",
                method: "POST",
                data: {
                    id: id,
                    is_generate_tagihan: is_generate,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error("Failed to update tagihan status.");
                }
            });
        });
    </script>
@endpush

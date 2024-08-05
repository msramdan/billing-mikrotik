@extends('layouts.app')

@section('title', __('Tagihans'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Tagihans') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all tagihans.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Tagihans') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

            @can('tagihan create')
                <div class="d-flex justify-content-end">
                    <button class="btn btn-success mb-3" id="sendWaBtn" disabled>
                        <i class="ace-icon bi bi-whatsapp"></i> Kirim Notif Wa
                    </button>&nbsp;
                    <a href="{{ route('tagihans.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Create a new tagihan') }}
                    </a>
                </div>
            @endcan

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="row g-3">
                                        <div class="col-md-2">
                                            <input type="month" value="{{ $thisMonth }}" name="tanggal" id="tanggal"
                                                class="form-control" />
                                        </div>
                                        <div class="col-md-2">
                                            <select name="pelanggans" id="pelanggans"
                                                class="form-control  js-example-basic-single">
                                                <option value="All">All Pelanggan</option>
                                                @foreach ($pelanggans as $row)
                                                    <option value="{{ $row->id }}"
                                                        {{ $selectedPelanggan == $row->id ? 'selected' : '' }}>
                                                        {{ $row->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <select name="metode_bayar" id="metode_bayar"
                                                class="form-control  js-example-basic-single">
                                                <option value="All">All Metode Bayar</option>
                                                <option value="Cash"
                                                    {{ $selectedMetodeBayar == 'Cash' ? 'selected' : '' }}>Cash</option>
                                                <option value="Transfer Bank"
                                                    {{ $selectedMetodeBayar == 'Transfer Bank' ? 'selected' : '' }}>
                                                    Transfer Bank</option>
                                                <option value="Payment Tripay"
                                                    {{ $selectedMetodeBayar == 'Payment Tripay' ? 'selected' : '' }}>
                                                    Payment Tripay</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <select name="status_bayar" id="status_bayar"
                                                class="form-control  js-example-basic-single">
                                                <option value="All">All Status Bayar
                                                </option>
                                                <option value="Sudah Bayar"
                                                    {{ $selectedStatusBayar == 'Sudah Bayar' ? 'selected' : '' }}>Sudah
                                                    Bayar</option>
                                                <option value="Belum Bayar"
                                                    {{ $selectedStatusBayar == 'Belum Bayar' ? 'selected' : '' }}>Belum
                                                    Bayar</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="kirim_tagihan" id="kirim_tagihan"
                                                class="form-control  js-example-basic-single">
                                                <option value="All">All Kirim Tagihan
                                                </option>
                                                <option value="Yes" {{ $isSend == 'Yes' ? 'selected' : '' }}>
                                                    Sudah Kirim</option>
                                                <option value="No" {{ $isSend == 'No' ? 'selected' : '' }}>
                                                    Belum Kirim</option>
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
                                            <th><input type="checkbox" id="checkAll"></th>
                                            <th>#</th>
                                            <th>{{ __('ID Pelanggan') }}</th>
                                            <th>{{ __('No Tagihan') }}</th>
                                            <th>{{ __('Pelanggan') }}</th>
                                            <th>{{ __('Total Bayar') }}</th>
                                            <th>{{ __('Status Bayar') }}</th>
                                            <th>{{ __('Sudah Kirim Tagihan ?') }}</th>
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
        function format(d) {
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td>Periode</td>' +
                '<td>' + d.periode + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Metode Bayar</td>' +
                '<td>' + d.metode_bayar + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Nominal Bayar</td>' +
                '<td>' + d.nominal_bayar + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Potongan Bayar</td>' +
                '<td>' + d.potongan_bayar + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>PPN</td>' +
                '<td>' + d.nominal_ppn + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Total Bayar</td>' +
                '<td>' + d.total_bayar + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>User Verifikasi</td>' +
                '<td>' + d.user + '</td>' +
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
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (row.status_bayar === 'Belum Bayar') {
                        return '<input type="checkbox" class="checkbox" value="' + data + '">';
                    } else {
                        return '';
                    }
                }
            },
            {
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
                data: 'no_tagihan',
                name: 'no_tagihan',
            },
            {
                data: 'pelanggan',
            },
            {
                data: 'total_bayar',
                name: 'total_bayar',
            },
            {
                data: 'status_bayar',
                name: 'status_bayar',
                orderable: false
            },
            {
                data: 'is_send',
                name: 'is_send',
                orderable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];

        let table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('tagihans.index') }}',
                data: function(d) {
                    d.tanggal = $('#tanggal').val();
                    d.pelanggan = $('#pelanggans').val();
                    d.metode_bayar = $('#metode_bayar').val();
                    d.status_bayar = $('#status_bayar').val();
                    d.kirim_tagihan = $('#kirim_tagihan').val();
                }
            },
            columns: columns
        });

        $('.js-example-basic-single').select2({
            theme: "bootstrap-5"
        });

        function replaceURLParams() {
            var params = new URLSearchParams();

            var tanggal = $("#tanggal").val();
            var pelanggans = $('select[name=pelanggans]').val();
            var metode_bayar = $('select[name=metode_bayar]').val();
            var status_bayar = $('select[name=status_bayar]').val();
            var kirim_tagihan = $('select[name=kirim_tagihan]').val();

            if (tanggal) params.set('tanggal', tanggal);
            if (pelanggans) params.set('pelanggans', pelanggans);
            if (metode_bayar) params.set('metode_bayar', metode_bayar);
            if (status_bayar) params.set('status_bayar', status_bayar);
            if (kirim_tagihan) params.set('kirim_tagihan', kirim_tagihan);

            var newURL = "{{ route('tagihans.index') }}" + '?' + params.toString();
            history.replaceState(null, null, newURL);
        }

        $('#tanggal').change(function() {
            table.draw();
            replaceURLParams()
        })

        $('#pelanggans').change(function() {
            table.draw();
            replaceURLParams()
        })
        $('#metode_bayar').change(function() {
            table.draw();
            replaceURLParams()
        })
        $('#status_bayar').change(function() {
            table.draw();
            replaceURLParams()
        })
        $('#kirim_tagihan').change(function() {
            table.draw();
            replaceURLParams()
        })


        $('#checkAll').change(function() {
            var checkboxes = $('.checkbox');
            checkboxes.prop('checked', $(this).prop('checked'));
            updateSendWaButtonState();
        });

        $('#data-table tbody').on('change', '.checkbox', function() {
            var checkAll = $('#checkAll');
            var checkboxes = $('.checkbox');
            checkAll.prop('checked', checkboxes.length === checkboxes.filter(':checked').length);
            updateSendWaButtonState();
        });

        function updateSendWaButtonState() {
            var sendWaBtn = $('#sendWaBtn');
            var checkedCheckboxes = $('.checkbox:checked');
            sendWaBtn.prop('disabled', checkedCheckboxes.length === 0);
        }

        $('#sendWaBtn').click(function() {
            var checkedIds = $('.checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (checkedIds.length === 0) {
                return;
            }

            if (!confirm('Apakah Anda yakin ingin mengirim tagihan WA untuk pelanggan yang dipilih?')) {
                return;
            }

            $.ajax({
                url: '{{ route('tagihans.sendWa') }}',
                method: 'POST',
                data: {
                    ids: checkedIds,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response.message);
                    table.draw();
                },
                error: function(xhr) {
                    if (xhr.status === 400 && xhr.responseJSON.message === 'Gateway WA tidak aktif.') {
                        alert('Gateway WA tidak aktif.');
                    } else {
                        alert('Terjadi kesalahan. Mohon coba lagi.');
                    }
                }
            });
        });
    </script>
@endpush

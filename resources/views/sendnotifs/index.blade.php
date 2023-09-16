@extends('layouts.app')

@section('title', __('Send Notif WA'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Send Notif WA') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Form For Send Notif WA.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/dashboard">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Send Notif WA') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>
        <section class="section">
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('kirim_pesan') }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="coverage-area">{{ __('Area Coverage') }}</label>
                                            <select class="form-select js-example-basic-single" name="coverage_area"
                                                id="coverage-area" class="form-control" required>
                                                <option value="" selected disabled>-- {{ __('Select area coverage') }}
                                                    --</option>

                                                @foreach ($areaCoverages as $areaCoverage)
                                                    <option value="{{ $areaCoverage->id }}"
                                                        {{ isset($pelanggan) && $pelanggan->coverage_area == $areaCoverage->id ? 'selected' : (old('coverage_area') == $areaCoverage->id ? 'selected' : '') }}>
                                                        {{ $areaCoverage->kode_area }} - {{ $areaCoverage->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="odc">{{ __('Odc') }}</label>
                                            <select class="form-select " name="odc" id="odc" class="form-control">
                                                <option value="" selected disabled>-- {{ __('Select') }} --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="odp">{{ __('Odp') }}</label>
                                            <select class="form-select  @error('odp') is-invalid @enderror" name="odp"
                                                id="odp" class="form-control">
                                                <option value="" selected disabled>-- {{ __('Select') }} --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Pesan WA">{{ __('Pesan WA') }}</label>
                                            <textarea name="pesan" id="pesan" rows="5" class="form-control" required></textarea>
                                            @error('Pesan WA')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Kirim') }}</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-info" role="alert">
                                LIST DAFTAR PELANGGAN YANG AKAN DI KIRIM PESAN
                            </div>
                            <table class="table table-bordered" id="data-table">
                                <thead>
                                    <th style="width: 8%">#</th>
                                    <th style="width: 46%">Nama</th>
                                    <th style="width: 46%">No Wa</th>
                                </thead>
                                <tbody class="tbody" id="tbodyid">
                                </tbody>
                            </table>
                        </div>
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
        $(document).ready(function() {
            $('#data-table').DataTable({
                "paging": true,
                "ordering": false,
                "info": false
            });
        });
    </script>

    <script>
        const options_temp = '<option value="" selected disabled>-- Select --</option>';
        $('#coverage-area').change(function() {
            $('#odc, #odp').html(options_temp);
            if ($(this).val() != "") {
                getOdc($(this).val());
            }
        })

        $('#odc').change(function() {
            $('#odp').html(options_temp);
            if ($(this).val() != "") {
                getOdp($(this).val());
            }
        })

        function getOdc(areaId) {
            let url = '{{ route('api.odc', ':id') }}';
            url = url.replace(':id', areaId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#odc').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.kode_odc}</option>`
                    });
                    $('#odc').html(options_temp + options)
                    $('#odc').prop('disabled', false);
                },
                error: function(err) {
                    $('#odc').prop('disabled', false);
                    alert(JSON.stringify(err))
                }

            })
        }

        function getOdp(odcId) {
            let url = '{{ route('api.odp', ':id') }}';
            url = url.replace(':id', odcId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#odp').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.kode_odp}</option>`
                    });
                    $('#odp').html(options_temp + options);
                    $('#odp').prop('disabled', false);
                },
                error: function(err) {
                    alert(JSON.stringify(err))
                    $('#odp').prop('disabled', false);
                }
            })
        }
    </script>

    <script>
        $('#coverage-area').change(function() {
            if ($(this).val() != "") {
                let url = '{{ route('api.getTableArea', ':id') }}';
                url = url.replace(':id', $(this).val())
                $.ajax({
                    url,
                    method: 'GET',
                    success: function(res) {
                        var tableSearch = $('#table-search');
                        var result = res.data;
                        $("#tbodyid").empty();
                        $.each(result, function(index, value) {
                            var oneIndexed = index + 1
                            $('tbody').append(
                                '<tr><td>' + oneIndexed + '</td><td>' + value.nama +
                                '</td><td>' +
                                value.no_wa + '</td></tr>');
                        });
                    },
                })
            }

        })
    </script>

    <script>
        $('#odc').change(function() {
            if ($(this).val() != "") {
                let url = '{{ route('api.getTableOdc', ':id') }}';
                url = url.replace(':id', $(this).val())
                $.ajax({
                    url,
                    method: 'GET',
                    success: function(res) {
                        var tableSearch = $('#table-search');
                        var result = res.data;
                        $("#tbodyid").empty();
                        $.each(result, function(index, value) {
                            var oneIndexed = index + 1
                            $('tbody').append(
                                '<tr><td>' + oneIndexed + '</td><td>' + value.nama +
                                '</td><td>' +
                                value.no_wa + '</td></tr>');
                        });
                    },
                })
            }

        })
    </script>

    <script>
        $('#odp').change(function() {
            if ($(this).val() != "") {
                let url = '{{ route('api.getTableOdp', ':id') }}';
                url = url.replace(':id', $(this).val())
                $.ajax({
                    url,
                    method: 'GET',
                    success: function(res) {
                        var tableSearch = $('#table-search');
                        var result = res.data;
                        $("#tbodyid").empty();
                        $.each(result, function(index, value) {
                            var oneIndexed = index + 1
                            $('tbody').append(
                                '<tr><td>' + oneIndexed + '</td><td>' + value.nama +
                                '</td><td>' +
                                value.no_wa + '</td></tr>');
                        });
                    },
                })
            }

        })
    </script>
@endpush

@extends('layouts.app')

@section('title', __('Create Pelanggans'))

@push('css')
<style>
    /* Set the size of the map container */
    #map {
        height: 400px;
        width: 100%;
        border-radius: 5px;
    }
</style>
@endpush
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Pelanggans') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Create a new pelanggan.') }}
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
                        {{ __('Create') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('pelanggans.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')

                                @include('pelanggans.include.form')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('js')

    <script>
        const options_temp = '<option value="" selected disabled>-- Select --</option>';
        $('#coverage-area').change(function() {
            $('#odc, #odp, #no_port_odp').html(options_temp);
            if ($(this).val() != "") {
                getOdc($(this).val());
            }
        })

        $('#odc').change(function() {
            $('#odp, #no_port_odp').html(options_temp);
            if ($(this).val() != "") {
                getOdp($(this).val());
            }
        })


        $('#odp').change(function() {
            $('#no_port_odp').html(options_temp);
            if ($(this).val() != "") {
                getPort($(this).val());
            }
        });


        $(document).ready(function() {
            $('#router').change(function() {
                $('#mode_user').html(options_temp);
                $('#user_static').html(options_temp);
                $('#user_pppoe').html(options_temp);
                if ($(this).val() != "") {
                    $("#alert").show();
                    $("#user_static_mode").hide();
                    $("#user_ppoe_mode").hide();
                    $('#user_static').attr('required', false);
                    $('#user_pppoe').attr('required', false);

                    if ($(this).val() != "") {
                        $("#mode_user").append(new Option("PPOE", "PPOE"));
                        $("#mode_user").append(new Option("Static", "Static"));
                    }
                }
            })
        });

        $(document).ready(function() {
            $("#mode_user").change(function() {
                $("#alert").hide();
                $('#user_static').html(options_temp);
                $('#user_pppoe').html(options_temp);
                var id = $('#router').val();
                if (this.value == 'Static') {
                    $('#user_static').html(options_temp);
                    $("#user_static_mode").show();
                    $("#user_ppoe_mode").hide();
                    $('#user_static').attr('required', true);
                    $('#user_pppoe').attr('required', false);
                    getStatic(id);
                } else {
                    $('#user_pppoe').html(options_temp);
                    $("#user_static_mode").hide();
                    $("#user_ppoe_mode").show();
                    $('#user_static').attr('required', false);
                    $('#user_pppoe').attr('required', true);
                    getProfile(id);
                }
            });
        });


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

        function getPort(odpId) {
            let url = '{{ route('api.getPort', ':id') }}';
            url = url.replace(':id', odpId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#no_port_odp').prop('disabled', true);
                },
                success: function(res) {
                    dataArray = res.array
                    const options = $.each(dataArray, function(key, value) {
                        if (value == 'Kosong') {
                            $('#no_port_odp').append('<option value="' + key + '">Port ' + key +
                                ' || ' + value + '</option>');
                        } else {
                            $('#no_port_odp').append('<option disabled value="' + key + '">Port ' +
                                key + ' || ' + value + '</option>');
                        }

                    });
                    $('#no_port_odp').prop('disabled', false);
                },
                error: function(err) {
                    alert(JSON.stringify(err))
                    $('#no_port_odp').prop('disabled', false);
                }
            })
        }

        function getProfile(router) {
            let url = '{{ route('api.getProfile', ':id') }}';
            url = url.replace(':id', router)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#user_pppoe').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.name}">${value.name}</option>`
                    });
                    $('#user_pppoe').html(options_temp + options);
                    $('#user_pppoe').prop('disabled', false);
                },
                error: function(err) {
                    alert(JSON.stringify(err))
                    $('#user_pppoe').prop('disabled', false);
                }
            })
        }

        function getStatic(router) {
            let url = '{{ route('api.getStatic', ':id') }}';
            url = url.replace(':id', router)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#user_static').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.name}">${value.name}</option>`
                    });
                    $('#user_static').html(options_temp + options);
                    $('#user_static').prop('disabled', false);
                },
                error: function(err) {
                    alert(JSON.stringify(err))
                    $('#user_static').prop('disabled', false);
                }
            })
        }
    </script>
@endpush

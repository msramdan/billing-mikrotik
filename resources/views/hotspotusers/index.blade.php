@extends('layouts.app')

@section('title', __('Hotspot Users'))

@push('css')
    <style>
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.5);
            /* warna latar belakang dengan opacity */
            z-index: 9999;
            /* pastikan lebih tinggi dari konten lain */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .overlay-content {
            text-align: center;
        }
    </style>
@endpush
@section('content')
    <div id="overlay" style="display: none;">
        <div class="overlay-content">
            <!-- Isi indikator loading di sini -->
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Hotspot Users') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all Hotspot Users.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/dashboard">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Hotspot Users') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>
            <div class="d-flex justify-content-end">
                @can('voucher create')
                    <a href="{{ route('vouchers.create') }}" class="btn btn-success mb-3">
                        <i class="fas fa-file"></i>
                        {{ __('Generate Voucher') }}
                    </a>&nbsp;
                @endcan
                @can('hotspotuser create')
                    <a href="{{ route('hotspotusers.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Create Manual') }}
                    </a>
                @endcan
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <select id="filter_profile" name="filter_profile" class="form-control">
                                                <option value="">All Profile
                                                </option>
                                                <?php
                                                $TotalReg = count($getprofile);
                                                ?>
                                                @for ($i = 0; $i < $TotalReg; $i++)
                                                    <option value="{{ $getprofile[$i]['name'] }}"
                                                        @if (request()->input('filter_profile') == $getprofile[$i]['name']) selected @endif>
                                                        {{ $getprofile[$i]['name'] }}
                                                    </option>
                                                @endfor

                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select id="filter_comment" name="filter_comment" class="form-control">
                                                    <option value="">All Comment</option>
                                                    <?php
                                                    $TotalReg = count($getuser);
                                                    $acomment = '';
                                                    for ($i = 0; $i < $TotalReg; $i++) {
                                                        $ucomment = isset($getuser[$i]['comment']) ? $getuser[$i]['comment'] : 'Nan Comment';
                                                        $uprofile = isset($getuser[$i]['profile']) ? $getuser[$i]['profile'] : 'Nan Profile';
                                                        $acomment .= ',' . $ucomment . '#' . $uprofile;
                                                    }
                                                    $ocomment = explode(',', $acomment);
                                                    $comments = array_count_values($ocomment);
                                                    foreach ($comments as $tcomment => $value) {
                                                        if (is_numeric(substr($tcomment, 3, 3))) {
                                                            $selected = request()->input('filter_comment') == explode('#', $tcomment)[0] ? 'selected' : '';
                                                            echo "<option value='" . explode('#', $tcomment)[0] . "' $selected>" . explode('#', $tcomment)[0] . ' ' . explode('#', $tcomment)[1] . ' [' . $value . ']</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <?php if (request()->input('filter_comment')): ?>
                                                <div class="input-group-append">
                                                    <button id="confirmButton" class="btn btn-danger" type="button"><i
                                                            class="fa fa-trash" aria-hidden="true"></i> By Comment</button>
                                                    <button id="" class="btn btn-secondary" type="button"><i
                                                            class="fa fa-print" aria-hidden="true"></i> Cetak</button>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Password') }}</th>
                                            <th>{{ __('Profile') }}</th>
                                            <th>{{ __('Uptime') }}</th>
                                            <th>{{ __('Download') }}</th>
                                            <th>{{ __('Upload') }}</th>
                                            <th>{{ __('Disable') }}</th>
                                            <th>{{ __('Comment') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hotspotusers as $row)
                                            <tr>
                                                <td>{{ $row['name'] }}</td>
                                                @if (isset($row['password']) && $row['password'] !== 'undefined')
                                                    <td>{{ $row['password'] }}</td>
                                                @else
                                                    <td>-</td>
                                                @endif
                                                <td>{{ isset($row['profile']) ? $row['profile'] : null }}</td>
                                                <td>{{ $row['uptime'] }}</td>
                                                <td>{{ formatBytes($row['bytes-out'], 2) }}</td>
                                                <td>{{ formatBytes($row['bytes-in'], 2) }}</td>
                                                @if ($row['disabled'] == 'true')
                                                    <td><button type="button" class="btn btn-danger btn-sm">Ya</button>
                                                    </td>
                                                @else
                                                    <td><button type="button" class="btn btn-success btn-sm">Tidak</button>
                                                    </td>
                                                @endif
                                                <td>{{ isset($row['comment']) ? $row['comment'] : null }}</td>
                                                <td>
                                                    @can('hotspotuser enable')
                                                        <form action="{{ route('hotspotusers.enable', $row['.id']) }}"
                                                            method="post" class="d-inline"
                                                            onsubmit="return confirm('Are you sure to enable this hotspot ?')">
                                                            @csrf
                                                            @method('PUT')
                                                            <button class="btn btn-outline-success btn-sm" title="Enable">
                                                                <i class="ace-icon fa fa-check"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                    <?php
                                                    $dataUser = $row['name'] ? $row['name'] : ' ';
                                                    ?>
                                                    @can('hotspotuser disable')
                                                        <form
                                                            action="{{ route('hotspotusers.disable', ['id' => $row['.id'], 'user' => $dataUser]) }}"
                                                            method="post" class="d-inline"
                                                            onsubmit="return confirm('Are you sure to disable this hotspot ?')">
                                                            @csrf
                                                            @method('PUT')
                                                            <button class="btn btn-outline-warning btn-sm" title="Disable">
                                                                <i class="ace-icon fa fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                    @can('hotspotuser reset')
                                                        <form action="{{ route('hotspotusers.reset', $row['.id']) }}"
                                                            method="post" class="d-inline"
                                                            onsubmit="return confirm('Are you sure to reset counter this hotspot ?')">
                                                            @csrf
                                                            @method('PUT')
                                                            <button class="btn btn-outline-secondary btn-sm" title="Reset">
                                                                <i class="ace-icon fa fa-refresh"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                    @can('hotspotuser delete')
                                                        <form
                                                            action="{{ route('hotspotusers.delete', ['id' => $row['.id'], 'user' => $dataUser]) }}"
                                                            method="post" class="d-inline"
                                                            onsubmit="return confirm('Are you sure to delete this record?')">
                                                            @csrf
                                                            @method('delete')

                                                            <button class="btn btn-outline-danger btn-sm">
                                                                <i class="ace-icon fa fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>


                                            </tr>
                                        @endforeach
                                    </tbody>
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
        new DataTable('#data-table', {
            // info: false,
            // ordering: false,
            // paging: false
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#filter_profile').change(function() {
                var filterProfile = $(this).val(); // Mendapatkan nilai terpilih dari select
                // Membangun URL dengan parameter
                var url = 'hotspotusers';
                if (filterProfile) {
                    url += '?filter_profile=' + encodeURIComponent(filterProfile);
                }
                window.location.href = url;
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#filter_comment').change(function() {
                var filter_comment = $(this).val(); // Mendapatkan nilai terpilih dari select
                // Membangun URL dengan parameter
                var url = 'hotspotusers';
                if (filter_comment) {
                    url += '?filter_comment=' + encodeURIComponent(filter_comment);
                }
                window.location.href = url;
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#confirmButton').click(function() {
                var filterComment = $('#filter_comment').val();
                var confirmation = confirm("Apakah Anda yakin ingin melanjutkan?");
                if (confirmation) {
                    $('#overlay').show();
                    $.ajax({
                        url: "{{ route('hotspotusers.deleteByComment') }}",
                        type: 'GET',
                        data: {
                            filter_comment: filterComment
                        },
                        success: function(response) {
                            $('#overlay').hide();
                            alert(response.message);
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            $('#overlay').hide();
                            console.error(xhr.responseText);
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        }
                    });
                }
            });
        });
    </script>
@endpush

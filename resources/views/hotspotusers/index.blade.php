@extends('layouts.app')

@section('title', __('Hotspot Users'))

@section('content')
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
                                            <select id="profile" name="profile" class="form-control">
                                                <option value="All">All Profile
                                                </option>
                                                <?php
                                                $TotalReg = count($getprofile);
                                                for ($i = 0; $i < $TotalReg; $i++) {
                                                    echo '<option>' . $getprofile[$i]['name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select id="comment" name="comment" class="form-control">
                                                <option value="All">All Comment
                                                </option>
                                                <?php
                                                $TotalReg = count($getuser);
                                                $acomment = '';
                                                for ($i = 0; $i < $TotalReg; $i++) {
                                                    $ucomment = isset($getuser[$i]['comment']) ? $getuser[$i]['comment'] : "Nan Comment";
                                                    $uprofile =  isset($getuser[$i]['profile']) ? $getuser[$i]['profile'] : "Nan Profile";
                                                    $acomment .= ',' . $ucomment . '#' . $uprofile;
                                                }
                                                $ocomment = explode(',', $acomment);
                                                $comments = array_count_values($ocomment);
                                                foreach ($comments as $tcomment => $value) {
                                                    if (is_numeric(substr($tcomment, 3, 3))) {
                                                        echo "<option value='" . explode('#', $tcomment)[0] . "' >" . explode('#', $tcomment)[0] . ' ' . explode('#', $tcomment)[1] . ' [' . $value . ']</option>';
                                                    }
                                                }
                                            ?>
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
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Password') }}</th>
                                            <th>{{ __('Profile') }}</th>
                                            <th>{{ __('Uptime') }}</th>
                                            <th>{{ __('Download') }}</th>
                                            <th>{{ __('Upload') }}</th>
                                            <th>{{ __('Disable') }}</th>
                                            <th>Comment</th>
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
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            // info: false,
            searching: false,
            ajax: "{{ route('hotspotusers.index') }}",
            columns: [{
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'password',
                    name: 'password',
                    render: function(data, type, full, meta) {
                        if (typeof data !== 'undefined') {
                            return `${data}`;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    data: 'profile',
                    name: 'profile',
                },
                {
                    data: 'uptime',
                    name: 'uptime',
                },
                {
                    data: 'bytes_out',
                    name: 'bytes_out',
                },
                {
                    data: 'bytes_in',
                    name: 'bytes_in',
                },
                {
                    data: 'disabled',
                    name: 'disabled',
                    render: function(data, type, full, meta) {
                        if (data == 'true') {
                            return '<button type="button" class="btn btn-danger btn-sm">Ya</button>';
                        } else {
                            return '<button type="button" class="btn btn-success btn-sm">Tidak</button>';
                        }
                    }
                },
                {
                    data: 'comment',
                    name: 'comment',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    </script>
@endpush

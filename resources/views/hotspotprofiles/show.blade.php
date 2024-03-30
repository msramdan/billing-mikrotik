@extends('layouts.app')

@section('title', __('Detail of Hotspot profiles'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Hotspot profiles') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of hotspotprofile.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('hotspotprofiles.index') }}">{{ __('Hotspot profiles') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Detail') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th class="pointer">Name</th>
                                            <th class="pointer">Profile</th>
                                            <th class="pointer"> Uptime</th>
                                            <th class="pointer"> Bytes In </th>
                                            <th class="pointer"> Bytes Out </th>
                                            <th class="pointer"> Mac Address</th>
                                            <th class="pointer"> Server</th>
                                            <th class="pointer">Comment</th>
                                        </tr>
                                    </thead>

                                    <tbody id="tbody">
                                        <?php
    for ($i = 0; $i < count($counttuser); $i++) {
      $userdetails = $counttuser[$i];
      $uid = $userdetails['.id'];
      $userver =isset($userdetails['server']) ? $userdetails['server'] : null;
      $uname = $userdetails['name'];
      $upass = isset($userdetails['password']) ? $userdetails['password'] : null;
      $uprofile = $userdetails['profile'];
      $umacadd = isset($userdetails['mac-address']) ? $userdetails['mac-address'] : null;
      $uuptime = $userdetails['uptime'];
      $ubytesi = formatBytes($userdetails['bytes-in'], 2);
      $ubyteso = formatBytes($userdetails['bytes-out'], 2);

      $ucomment = isset($userdetails['comment']) ? $userdetails['comment'] : null;
      $udisabled = $userdetails['disabled'];
      $utimelimit = isset($userdetails['limit-uptime']) ? $userdetails['limit-uptime'] : null;
      if ($utimelimit == '1s') {
        $utimelimit = ' expired';
      } else {
        $utimelimit = ' ' . $utimelimit;
      }
      $udatalimit = isset($userdetails['limit-bytes-total']) ? $userdetails['limit-bytes-total'] : null;
      if ($udatalimit == '') {
        $udatalimit = '';
      } else {
        $udatalimit = ' ' . formatBytes($udatalimit, 2);
      }

      echo "<tr>";
      ?>

                                        <?php
    if ($udisabled == "true") {
        $uriprocess = '';
        echo '<td>
            <a href="' . route('hotspotprofiles.enable', ['id' => $uid]) . '" class="text-warning pointer" title="Enable User ' . $uname . '"><i class="fa fa-lock"></i></a>&nbsp
            <a title="Print ' . $uname . '" href=""><i class="fa fa-print"></i></a>&nbsp
            <a title="Print ' . $uname . '" href=""><i class="fa fa-qrcode"></i> </a>
            </td>';
    } else {
        $uriprocess = '/?';
        echo '<td>
            <a href="' . route('hotspotprofiles.disable', ['id' => $uid]) . '" class="pointer" title="Disable User ' . $uname . '"><i class="fa fa-unlock"></i></a>&nbsp
            <a title="Print ' . $uname . '" href=""><i class="fa fa-print"></i></a>&nbsp
            <a title="Print ' . $uname . '" href=""><i class="fa fa-qrcode"></i> </a>
            </td>';
    }
      if ($uname == $upass) {
        $usermode = "vc";
      } else {
        $usermode = "up";
      }
      $popup = "javascript:window.open('').print();";
      $popupQR = "javascript:window.open('').print();";
      echo "<td>" . $uname . "</td>";
      echo "<td>" . $uprofile . "</td>";
      echo "<td>" . $uuptime . "</td>";
      echo "<td>" . $ubytesi . "</td>";
      echo "<td>" . $ubyteso . "</td>";
      echo "<td>" . $umacadd . "</td>";
      echo "<td>" . $userver . "</td>";
      echo "<td>";
        if ($uname == "default-trial") {
        } else if (substr($ucomment, 0, 3) == "vc-" || substr($ucomment, 0, 3) == "up-") {
            echo "<span>" . $ucomment . " " . $udatalimit . " " . $utimelimit . "</span>";
        } else if ($utimelimit == ' expired') {
            echo "<span>" . $ucomment . " " . $udatalimit . " " . $utimelimit . "</span>";
        } else {
            echo "<span>" . $ucomment . "</span>";
        }
      echo  "</td>";
    }
    ?>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                            <a href="{{ route('hotspotprofiles.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script>
        $('#data-table').DataTable({
            processing: true,
        });
    </script>
@endpush

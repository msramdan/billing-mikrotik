<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{ getCompany()->nama_perusahaan }} </title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('frontend') }}/admin/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/admin/dist/css/adminlte.min.css">
    <link rel="icon"
        @if (getCompany()->favicon != null) href="{{ Storage::url('public/uploads/favicons/') . getCompany()->favicon }}" @endif
        type="image/x-icon">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('dashboardCustomer')}}" class="brand-link" style="margin-left: 10px">
                <i class="fa fa-wifi fa-lg" aria-hidden="true"></i>
                <span class="brand-text font-weight-light"> <b>{{ getCompany()->nama_perusahaan }}</b> </span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('frontend') }}/admin/dist/img/default.png"
                            class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{getCustomer()->nama}}</a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logoutCustomer') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        @yield('content')
    </div>
    <script src="{{ asset('frontend') }}/admin/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('frontend') }}/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend') }}/admin/dist/js/adminlte.min.js"></script>
</body>

</html>

@extends('layouts.app')

@section('title', __('Monitorings'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Monitorings') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Below is a list of all monitorings.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Monitorings') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="container mt-5">
                            <div class="card"
                                style="background: linear-gradient(to right, #4CAF50, #3498db); color: #fff;">
                                <div class="card-body">
                                    <div class="col-md-3">
                                        <select name="status" id="status" class="form-control">
                                            <option value="" selected disabled>-- Select OLT -- </option>
                                            @foreach ($olts as $row)
                                                <option value="{{ $row->id }}">
                                                    {{ $row->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="row">
                    <div class="col-xl-3 col-sm-6 box-col-3">
                        <div class="card radius-10 border-start border-0 border-3 border-secondary">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Waiting Authorization</p>
                                        <h4 class="my-1 text-primary">
                                            <a href="/hotspotactives" class=""> XX Data </a>
                                        </h4>

                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                            class="fa fa-wifi"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 box-col-3">
                        <div class="card radius-10 border-start border-0 border-3 border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Online</p>
                                        <h4 class="my-1 text-primary"><a href="#" class="">
                                                XX Data </a>
                                        </h4>

                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                            class="fa fa-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 box-col-3">
                        <div class="card radius-10 border-start border-0 border-3 border-danger">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Offline</p>
                                        <h4 class="my-1 text-primary"><a href="#" class="">
                                                XX Data </a>
                                        </h4>

                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                            class="fa fa-times"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 box-col-3">
                        <div class="card radius-10 border-start border-0 border-3 border-warning">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Low Signals</p>
                                        <h4 class="my-1 text-primary"><a href="#" class="">
                                                XX Data </a>
                                        </h4>

                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                            class="fa fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Onu ID') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('SN/Mac/Loid') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('OLT RX Signal') }}</th>
                                            <th>{{ __('Reason') }}</th>
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

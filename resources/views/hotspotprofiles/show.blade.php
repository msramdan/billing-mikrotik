@extends('layouts.app')

@section('title', __('Detail of Hotspotprofiles'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Hotspotprofiles') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of hotspotprofile.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('hotspotprofiles.index') }}">{{ __('Hotspotprofiles') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Detail') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="min-width:50px;" class="align-middle text-center" id="cuser">3</th>
                                            <th style="min-width:50px;" class="pointer"> Server</th>
                                            <th class="pointer">Name</th>
                                            <th>Print</th>
                                            <th class="pointer">Profile</th>
                                            <th class="pointer"> Mac Address</th>
                                            <th class="text-right align-middle pointer"> Terkoneksi</th>
                                            <th class="pointer">Comment</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

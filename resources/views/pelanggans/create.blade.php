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

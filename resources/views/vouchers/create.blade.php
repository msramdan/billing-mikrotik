@extends('layouts.app')

@section('title', __('Create Vouchers'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Vouchers') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Create a new voucher.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('vouchers.index') }}">{{ __('Vouchers') }}</a>
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
                            <form action="{{ route('vouchers.store') }}" method="POST">
                                @csrf
                                @method('POST')

                                @include('vouchers.include.form')
                                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

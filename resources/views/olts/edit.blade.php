@extends('layouts.app')

@section('title', __('Edit Olts'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Olts') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Edit a olt.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('olts.index') }}">{{ __('Olts') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Edit') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('olts.update', $olt->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                @include('olts.include.form')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>

                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

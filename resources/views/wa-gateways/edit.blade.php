@extends('layouts.app')

@section('title', __('Edit Wa Gateways'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Wa Gateways') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Edit a wa gateway.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/dashboard">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('wa-gateways.index') }}">{{ __('Wa Gateways') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Edit') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>
            <form action="{{ route('wa-gateways.update', $waGateway->id) }}" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">

                                @csrf
                                @method('PUT')
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="url">{{ __('Url') }}</label>
                                            <input type="url" name="url" id="url"
                                                class="form-control @error('url') is-invalid @enderror"
                                                value="{{ isset($waGateway) ? $waGateway->url : old('url') }}"
                                                placeholder="{{ __('Url') }}" required />
                                            @error('url')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="api-key">{{ __('Api Key') }}</label>
                                            <input type="text" name="api_key" id="api-key"
                                                class="form-control @error('api_key') is-invalid @enderror"
                                                value="{{ isset($waGateway) ? $waGateway->api_key : old('api_key') }}"
                                                placeholder="{{ __('Api Key') }}" required />
                                            @error('api_key')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="is-active">{{ __('Is Active') }}</label>
                                            <select class="form-select @error('is_active') is-invalid @enderror"
                                                name="is_active" id="is-active" class="form-control" required>
                                                <option value="" selected disabled>-- {{ __('Select is active') }} --
                                                </option>
                                                <option value="Yes"
                                                    {{ isset($waGateway) && $waGateway->is_active == 'Yes' ? 'selected' : (old('is_active') == 'Yes' ? 'selected' : '') }}>
                                                    Yes</option>
                                                <option value="No"
                                                    {{ isset($waGateway) && $waGateway->is_active == 'No' ? 'selected' : (old('is_active') == 'No' ? 'selected' : '') }}>
                                                    No</option>
                                            </select>
                                            @error('is_active')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label
                                                for="footer_pesan_wa_tagihan">{{ __('Footer pesan wa tagihan') }}</label>
                                            <textarea rows="7" name="footer_pesan_wa_tagihan" id="footer_pesan_wa_tagihan"
                                                class="form-control @error('footer_pesan_wa_pembayaran') is-invalid @enderror"
                                                placeholder="" required>{{ isset($waGateway) ? $waGateway->footer_pesan_wa_tagihan : old('footer_pesan_wa_tagihan') }}</textarea>
                                            @error('footer_pesan_wa_tagihan')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label
                                                for="footer_pesan_wa_pembayaran">{{ __('Footer pesan wa pembayaran') }}</label>
                                            <textarea name="footer_pesan_wa_pembayaran" rows="7" id="footer_pesan_wa_pembayaran"
                                                class="form-control @error('footer_pesan_wa_pembayaran') is-invalid @enderror"
                                                placeholder="" required>{{ isset($waGateway) ? $waGateway->footer_pesan_wa_pembayaran : old('footer_pesan_wa_pembayaran') }}</textarea>
                                            @error('footer_pesan_wa_pembayaran')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                    </div>
                                </div>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection

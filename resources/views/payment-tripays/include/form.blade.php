<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="kode-merchant">{{ __('Kode Merchant') }}</label>
            <input type="text" name="kode_merchant" id="kode-merchant" class="form-control @error('kode_merchant') is-invalid @enderror" value="{{ isset($paymentTripay) ? $paymentTripay->kode_merchant : old('kode_merchant') }}" placeholder="{{ __('Kode Merchant') }}" required />
            @error('kode_merchant')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="api-key">{{ __('Api Key') }}</label>
            <input type="text" name="api_key" id="api-key" class="form-control @error('api_key') is-invalid @enderror" value="{{ isset($paymentTripay) ? $paymentTripay->api_key : old('api_key') }}" placeholder="{{ __('Api Key') }}" required />
            @error('api_key')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="private-key">{{ __('Private Key') }}</label>
            <input type="text" name="private_key" id="private-key" class="form-control @error('private_key') is-invalid @enderror" value="{{ isset($paymentTripay) ? $paymentTripay->private_key : old('private_key') }}" placeholder="{{ __('Private Key') }}" required />
            @error('private_key')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
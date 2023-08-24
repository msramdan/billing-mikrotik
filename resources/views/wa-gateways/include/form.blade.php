<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="url">{{ __('Url') }}</label>
            <input type="url" name="url" id="url" class="form-control @error('url') is-invalid @enderror" value="{{ isset($waGateway) ? $waGateway->url : old('url') }}" placeholder="{{ __('Url') }}" required />
            @error('url')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="api-key">{{ __('Api Key') }}</label>
            <input type="text" name="api_key" id="api-key" class="form-control @error('api_key') is-invalid @enderror" value="{{ isset($waGateway) ? $waGateway->api_key : old('api_key') }}" placeholder="{{ __('Api Key') }}" required />
            @error('api_key')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="is-active">{{ __('Is Active') }}</label>
            <select class="form-select @error('is_active') is-invalid @enderror" name="is_active" id="is-active" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select is active') }} --</option>
                <option value="Yes" {{ isset($waGateway) && $waGateway->is_active == 'Yes' ? 'selected' : (old('is_active') == 'Yes' ? 'selected' : '') }}>Yes</option>
		<option value="No" {{ isset($waGateway) && $waGateway->is_active == 'No' ? 'selected' : (old('is_active') == 'No' ? 'selected' : '') }}>No</option>			
            </select>
            @error('is_active')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
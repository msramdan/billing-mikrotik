<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="privacy-policy">{{ __('Privacy Policy') }}</label>
            <textarea name="privacy_policy" id="privacy-policy" class="form-control @error('privacy_policy') is-invalid @enderror" placeholder="{{ __('Privacy Policy') }}" required>{{ isset($privacyPolicy) ? $privacyPolicy->privacy_policy : old('privacy_policy') }}</textarea>
            @error('privacy_policy')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="identitas-router">{{ __('Identitas Router') }}</label>
            <input type="text" name="identitas_router" id="identitas-router"
                class="form-control @error('identitas_router') is-invalid @enderror"
                value="{{ isset($settingmikrotik) ? $settingmikrotik->identitas_router : old('identitas_router') }}"
                placeholder="{{ __('Identitas Router') }}" required />
            @error('identitas_router')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="host">{{ __('Host') }}</label>
            <input type="text" name="host" id="host" class="form-control @error('host') is-invalid @enderror"
                value="{{ isset($settingmikrotik) ? $settingmikrotik->host : old('host') }}"
                placeholder="{{ __('Host') }}" required />
            @error('host')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="port">{{ __('Port') }}</label>
            <input type="number" name="port" id="port" class="form-control @error('port') is-invalid @enderror"
                value="{{ isset($settingmikrotik) ? $settingmikrotik->port : old('port') }}"
                placeholder="{{ __('Port') }}" required />
            @error('port')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="username">{{ __('Username') }}</label>
            <input type="text" name="username" id="username"
                class="form-control @error('username') is-invalid @enderror"
                value="{{ isset($settingmikrotik) ? $settingmikrotik->username : old('username') }}"
                placeholder="{{ __('Username') }}" required />
            @error('username')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input type="password" name="password" id="password"
                class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}"
                {{ empty($settingmikrotik) ? ' required' : '' }} />
            @error('password')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
            @isset($settingmikrotik)
                <div id="PasswordHelpBlock" class="form-text">
                    {{ __('Leave the Password & Password Confirmation blank if you don`t want to change them.') }}
                </div>
            @endisset
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="password-confirmation">{{ __('Password Confirmation') }}</label>
            <input type="password" name="password_confirmation" id="password-confirmation" class="form-control"
                placeholder="{{ __('Password Confirmation') }}" {{ empty($settingmikrotik) ? ' required' : '' }} />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="is-active">{{ __('Is Active') }}</label>
            <select class="form-select @error('is_active') is-invalid @enderror" name="is_active" id="is-active"
                class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select is active') }} --</option>
                <option value="Yes"
                    {{ isset($settingmikrotik) && $settingmikrotik->is_active == 'Yes' ? 'selected' : (old('is_active') == 'Yes' ? 'selected' : '') }}>
                    Yes</option>
                <option value="No"
                    {{ isset($settingmikrotik) && $settingmikrotik->is_active == 'No' ? 'selected' : (old('is_active') == 'No' ? 'selected' : '') }}>
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

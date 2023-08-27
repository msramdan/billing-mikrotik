<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="username">{{ __('Username') }}</label>
            <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ isset($secretPpp) ? $secretPpp->username : old('username') }}" placeholder="{{ __('Username') }}" required />
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
            <input type="text" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{ isset($secretPpp) ? $secretPpp->password : old('password') }}" placeholder="{{ __('Password') }}" required />
            @error('password')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="service">{{ __('Service') }}</label>
            <input type="text" name="service" id="service" class="form-control @error('service') is-invalid @enderror" value="{{ isset($secretPpp) ? $secretPpp->service : old('service') }}" placeholder="{{ __('Service') }}" required />
            @error('service')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="profile">{{ __('Profile') }}</label>
            <input type="text" name="profile" id="profile" class="form-control @error('profile') is-invalid @enderror" value="{{ isset($secretPpp) ? $secretPpp->profile : old('profile') }}" placeholder="{{ __('Profile') }}" required />
            @error('profile')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="last-logout">{{ __('Last Logout') }}</label>
            <input type="text" name="last_logout" id="last-logout" class="form-control @error('last_logout') is-invalid @enderror" value="{{ isset($secretPpp) ? $secretPpp->last_logout : old('last_logout') }}" placeholder="{{ __('Last Logout') }}" required />
            @error('last_logout')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="komentar">{{ __('Komentar') }}</label>
            <input type="text" name="komentar" id="komentar" class="form-control @error('komentar') is-invalid @enderror" value="{{ isset($secretPpp) ? $secretPpp->komentar : old('komentar') }}" placeholder="{{ __('Komentar') }}" required />
            @error('komentar')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="status">{{ __('Status') }}</label>
            <input type="text" name="status" id="status" class="form-control @error('status') is-invalid @enderror" value="{{ isset($secretPpp) ? $secretPpp->status : old('status') }}" placeholder="{{ __('Status') }}" required />
            @error('status')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="username">{{ __('Username') }}</label>
            <input type="text" name="username" id="username"
                class="form-control @error('username') is-invalid @enderror"
                value="{{ isset($secretPpp) ? $secretPpp->username : old('username') }}"
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
            <input type="text" name="password" id="password"
                class="form-control @error('password') is-invalid @enderror"
                value="{{ isset($secretPpp) ? $secretPpp->password : old('password') }}"
                placeholder="{{ __('Password') }}" required />
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
            <select class="form-select @error('service') is-invalid @enderror" name="service" id="service"
                class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select service') }} --</option>
                <option value="pppoe"
                    {{ isset($pelanggan) && $pelanggan->service == 'pppoe' ? 'selected' : (old('service') == 'pppoe' ? 'selected' : '') }}>
                    pppoe</option>
                <option value="any"
                    {{ isset($pelanggan) && $pelanggan->service == 'any' ? 'selected' : (old('service') == 'any' ? 'selected' : '') }}>
                    any</option>
                <option value="async"
                    {{ isset($pelanggan) && $pelanggan->service == 'async' ? 'selected' : (old('service') == 'async' ? 'selected' : '') }}>
                    async</option>
                <option value="l2tp"
                    {{ isset($pelanggan) && $pelanggan->service == 'l2tp' ? 'selected' : (old('service') == 'l2tp' ? 'selected' : '') }}>
                    l2tp</option>
                <option value="ovpn"
                    {{ isset($pelanggan) && $pelanggan->service == 'ovpn' ? 'selected' : (old('service') == 'ovpn' ? 'selected' : '') }}>
                    ovpn</option>
                <option value="pptp"
                    {{ isset($pelanggan) && $pelanggan->service == 'pptp' ? 'selected' : (old('service') == 'pptp' ? 'selected' : '') }}>
                    pptp</option>
                <option value="sstp"
                    {{ isset($pelanggan) && $pelanggan->service == 'sstp' ? 'selected' : (old('service') == 'sstp' ? 'selected' : '') }}>
                    sstp</option>
            </select>
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

            <select class="form-select @error('profile') is-invalid @enderror" name="profile" id="profile"
                class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select profile') }} --</option>
                @foreach ($profiles as $profile)
                    <option value="{{ $profile['name'] }}"
                        {{ isset($secretPpp) && $secretPpp['name'] == $profile['name'] ? 'selected' : (old('profile_id') == $profile['name'] ? 'selected' : '') }}>
                        {{ $profile['name'] }}
                    </option>
                @endforeach
            </select>

            @error('profile')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="komentar">{{ __('Komentar') }}</label>
            <input type="text" name="komentar" id="komentar"
                class="form-control @error('komentar') is-invalid @enderror"
                value="{{ isset($secretPpp) ? $secretPpp->komentar : old('komentar') }}"
                placeholder="{{ __('Komentar') }}" required />
            @error('komentar')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>

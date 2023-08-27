<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ isset($hotspotuser) ? $hotspotuser->name : old('name') }}" placeholder="{{ __('Name') }}" required />
            @error('name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input type="text" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{ isset($hotspotuser) ? $hotspotuser->password : old('password') }}" placeholder="{{ __('Password') }}" required />
            @error('password')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="profile">{{ __('Profile') }}</label>
            <input type="text" name="profile" id="profile" class="form-control @error('profile') is-invalid @enderror" value="{{ isset($hotspotuser) ? $hotspotuser->profile : old('profile') }}" placeholder="{{ __('Profile') }}" required />
            @error('profile')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="uptime">{{ __('Uptime') }}</label>
            <input type="text" name="uptime" id="uptime" class="form-control @error('uptime') is-invalid @enderror" value="{{ isset($hotspotuser) ? $hotspotuser->uptime : old('uptime') }}" placeholder="{{ __('Uptime') }}" required />
            @error('uptime')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="bytes-out">{{ __('Bytes Out') }}</label>
            <input type="text" name="bytes_out" id="bytes-out" class="form-control @error('bytes_out') is-invalid @enderror" value="{{ isset($hotspotuser) ? $hotspotuser->bytes_out : old('bytes_out') }}" placeholder="{{ __('Bytes Out') }}" required />
            @error('bytes_out')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="bytes-in">{{ __('Bytes In') }}</label>
            <input type="text" name="bytes_in" id="bytes-in" class="form-control @error('bytes_in') is-invalid @enderror" value="{{ isset($hotspotuser) ? $hotspotuser->bytes_in : old('bytes_in') }}" placeholder="{{ __('Bytes In') }}" required />
            @error('bytes_in')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
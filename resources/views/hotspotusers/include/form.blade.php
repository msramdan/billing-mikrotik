<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">{{ __('Username') }}</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ isset($hotspotuser) ? $hotspotuser->name : old('name') }}" placeholder="{{ __('Username') }}" required />
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
            <select class="form-select @error('profile') is-invalid @enderror" name="profile" id="profile"
                class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select Profile') }} --</option>
                @foreach ($hotspotprofile as $datagua)
                    <option value="{{ $datagua['name'] }}"
                        {{ isset($hotspotuser) && $hotspotuser->profile == $datagua['name'] ? 'selected' : (old('profile') == $datagua['name'] ? 'selected' : '') }}>
                        {{ $datagua['name'] }}
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
            <label for="server_hotspot">{{ __('Server') }}</label>
            <select class="form-select @error('server_hotspot') is-invalid @enderror" name="server_hotspot" id="server"
                class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select Server') }} --</option>
                @foreach ($hotspotserver as $mydata)
                    <option value="{{ $mydata['name'] }}"
                        {{ isset($hotspotuser) && $hotspotuser->server_hotspot == $mydata['name'] ? 'selected' : (old('server_hotspot') == $mydata['name'] ? 'selected' : '') }}>
                        {{ $mydata['name'] }}
                    </option>
                @endforeach
            </select>
            @error('server_hotspot')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>



    <div class="col-md-6">
        <div class="form-group">
            <label for="comment">{{ __('Komentar') }}</label>
            <input type="text" name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror" value="{{ isset($hotspotuser) ? $hotspotuser->comment : old('comment') }}" placeholder="{{ __('Komentar') }}" required />
            @error('comment')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>

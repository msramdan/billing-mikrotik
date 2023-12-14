<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ isset($olt) ? $olt->name : old('name') }}" placeholder="{{ __('Name') }}" required />
            @error('name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="type">{{ __('Type') }}</label>
            <select class="form-select @error('type') is-invalid @enderror" name="type" id="type" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select type') }} --</option>
                <option value="Zte" {{ isset($olt) && $olt->type == 'Zte' ? 'selected' : (old('type') == 'Zte' ? 'selected' : '') }}>Zte</option>
		        {{-- <option value="Huawei" {{ isset($olt) && $olt->type == 'Huawei' ? 'selected' : (old('type') == 'Huawei' ? 'selected' : '') }}>Huawei</option> --}}
            </select>
            @error('type')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="host">{{ __('Host') }}</label>
            <input type="text" name="host" id="host" class="form-control @error('host') is-invalid @enderror" value="{{ isset($olt) ? $olt->host : old('host') }}" placeholder="{{ __('Host') }}" required />
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
            <input type="number" name="port" id="port" class="form-control @error('port') is-invalid @enderror" value="{{ isset($olt) ? $olt->port : old('port') }}" placeholder="{{ __('Port') }}" required />
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
            <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ isset($olt) ? $olt->username : old('username') }}" placeholder="{{ __('Username') }}" required />
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
            <input type="text" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{ isset($olt) ? $olt->password : old('password') }}" placeholder="{{ __('Password') }}" required />
            @error('password')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>

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
            <label for="ro">{{ __('RO (Read Only)') }}</label>
            <input type="text" name="ro" id="ro" class="form-control @error('ro') is-invalid @enderror" value="{{ isset($olt) ? $olt->ro : old('ro') }}" placeholder="{{ __('RO (Read Only)') }}" required />
            @error('ro')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="rw">{{ __('RW (Read Write)') }}</label>
            <input type="text" name="rw" id="rw" class="form-control @error('rw') is-invalid @enderror" value="{{ isset($olt) ? $olt->rw : old('rw') }}" placeholder="{{ __('RW (Read Write)') }}" required />
            @error('rw')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>

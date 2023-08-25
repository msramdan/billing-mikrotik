<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="kode-area">{{ __('Kode Area') }}</label>
            <input type="text" name="kode_area" id="kode-area" class="form-control @error('kode_area') is-invalid @enderror" value="{{ isset($areaCoverage) ? $areaCoverage->kode_area : old('kode_area') }}" placeholder="{{ __('Kode Area') }}" required />
            @error('kode_area')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tampilkan-register">{{ __('Tampilkan Register') }}</label>
            <select class="form-select @error('tampilkan_register') is-invalid @enderror" name="tampilkan_register" id="tampilkan-register" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select tampilkan register') }} --</option>
                <option value="Yes" {{ isset($areaCoverage) && $areaCoverage->tampilkan_register == 'Yes' ? 'selected' : (old('tampilkan_register') == 'Yes' ? 'selected' : '') }}>Yes</option>
		<option value="No" {{ isset($areaCoverage) && $areaCoverage->tampilkan_register == 'No' ? 'selected' : (old('tampilkan_register') == 'No' ? 'selected' : '') }}>No</option>			
            </select>
            @error('tampilkan_register')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama">{{ __('Nama') }}</label>
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ isset($areaCoverage) ? $areaCoverage->nama : old('nama') }}" placeholder="{{ __('Nama') }}" required />
            @error('nama')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="alamat">{{ __('Alamat') }}</label>
            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="{{ __('Alamat') }}" required>{{ isset($areaCoverage) ? $areaCoverage->alamat : old('alamat') }}</textarea>
            @error('alamat')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="keterangan">{{ __('Keterangan') }}</label>
            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" placeholder="{{ __('Keterangan') }}" required>{{ isset($areaCoverage) ? $areaCoverage->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="jangkauan">{{ __('Jangkauan') }}</label>
            <input type="number" name="jangkauan" id="jangkauan" class="form-control @error('jangkauan') is-invalid @enderror" value="{{ isset($areaCoverage) ? $areaCoverage->jangkauan : old('jangkauan') }}" placeholder="{{ __('Jangkauan') }}" required />
            @error('jangkauan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="latitude">{{ __('Latitude') }}</label>
            <input type="text" name="latitude" id="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ isset($areaCoverage) ? $areaCoverage->latitude : old('latitude') }}" placeholder="{{ __('Latitude') }}" required />
            @error('latitude')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="longitude">{{ __('Longitude') }}</label>
            <input type="text" name="longitude" id="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ isset($areaCoverage) ? $areaCoverage->longitude : old('longitude') }}" placeholder="{{ __('Longitude') }}" required />
            @error('longitude')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
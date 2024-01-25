<div class="row mb-3">
    <div class="col-md-3">
        <div class="form-group">
            <label for="kode-area">{{ __('Kode Area') }}</label>
            <input type="text" name="kode_area" id="kode-area"
                class="form-control @error('kode_area') is-invalid @enderror"
                value="{{ isset($areaCoverage) ? $areaCoverage->kode_area : old('kode_area') }}"
                placeholder="{{ __('Kode Area') }}" required />
            @error('kode_area')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="nama">{{ __('Nama') }}</label>
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                value="{{ isset($areaCoverage) ? $areaCoverage->nama : old('nama') }}" placeholder="{{ __('Nama') }}"
                required />
            @error('nama')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tampilkan-register">{{ __('Tampilkan Register') }}</label>
            <select class="form-select @error('tampilkan_register') is-invalid @enderror" name="tampilkan_register"
                id="tampilkan-register" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select tampilkan register') }} --</option>
                <option value="Yes"
                    {{ isset($areaCoverage) && $areaCoverage->tampilkan_register == 'Yes' ? 'selected' : (old('tampilkan_register') == 'Yes' ? 'selected' : '') }}>
                    Yes</option>
                <option value="No"
                    {{ isset($areaCoverage) && $areaCoverage->tampilkan_register == 'No' ? 'selected' : (old('tampilkan_register') == 'No' ? 'selected' : '') }}>
                    No</option>
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
            <label for="alamat">{{ __('Alamat') }}</label>
            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror"
                placeholder="{{ __('Alamat') }}" required>{{ isset($areaCoverage) ? $areaCoverage->alamat : old('alamat') }}</textarea>
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
            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                placeholder="{{ __('Keterangan') }}" required>{{ isset($areaCoverage) ? $areaCoverage->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="radius">{{ __('Radius') }}</label>
                    <input type="number" name="radius" id="radius"
                        class="form-control @error('radius') is-invalid @enderror"
                        value="{{ isset($areaCoverage) ? $areaCoverage->radius : old('radius') }}"
                        placeholder="{{ __('Radius') }}" required />
                    @error('radius')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="latitude">{{ __('Latitude') }}</label>
                    <input type="text" name="latitude" id="latitude"
                        class="form-control @error('latitude') is-invalid @enderror"
                        value="{{ isset($areaCoverage) ? $areaCoverage->latitude : old('latitude') }}"
                        placeholder="{{ __('Latitude') }}" required readonly />
                    @error('latitude')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="longitude">{{ __('Longitude') }}</label>
                    <input type="text" name="longitude" id="longitude"
                        class="form-control @error('longitude') is-invalid @enderror"
                        value="{{ isset($areaCoverage) ? $areaCoverage->longitude : old('longitude') }}"
                        placeholder="{{ __('Longitude') }}" required readonly />
                    @error('longitude')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="card px-2 py-1">
                <div class="mb-3 search-box">
                    <div class="input-group" style="width: 100%">
                        <input type="text" class="form-control @error('place') is-invalid @enderror"
                            name="place" id="search_place" placeholder="Cari Lokasi"
                            value="{{ old('place') }}" autocomplete="off">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><button type="button"
                                    class="btn" onclick="getCurrentLocation()">
                                    <i class='fas fa-map-marker-alt'></i>
                                </button></span>
                        </div>
                        <span class="d-none" style="color: red;" id="error-place"></span>
                        @error('place')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <ul class="results">
                        <li style="text-align: center;padding: 50% 0; max-height: 25hv;">Masukan Pencarian</li>
                    </ul>
                </div>
                <div class="map-embed" id="map" style="border-radius: 5px"></div>
            </div>
        </div>

    </div>


</div>

<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="kode-odc">{{ __('Odc') }}</label>
            <select class="form-select @error('kode_odc') is-invalid @enderror" name="kode_odc" id="kode-odc" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select odc') }} --</option>

                        @foreach ($odcs as $odc)
                            <option value="{{ $odc->id }}" {{ isset($odp) && $odp->kode_odc == $odc->id ? 'selected' : (old('kode_odc') == $odc->id ? 'selected' : '') }}>
                                {{ $odc->kode_odc }}
                            </option>
                        @endforeach
            </select>
            @error('kode_odc')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nomor-port-odc">{{ __('Nomor Port Odc') }}</label>
            <input type="number" name="nomor_port_odc" id="nomor-port-odc" class="form-control @error('nomor_port_odc') is-invalid @enderror" value="{{ isset($odp) ? $odp->nomor_port_odc : old('nomor_port_odc') }}" placeholder="{{ __('Nomor Port Odc') }}" required />
            @error('nomor_port_odc')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="kode-odp">{{ __('Kode Odp') }}</label>
            <input type="text" name="kode_odp" id="kode-odp" class="form-control @error('kode_odp') is-invalid @enderror" value="{{ isset($odp) ? $odp->kode_odp : old('kode_odp') }}" placeholder="{{ __('Kode Odp') }}" required />
            @error('kode_odp')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="wilayah-odcp">{{ __('Area Coverage') }}</label>
            <select class="form-select @error('wilayah_odp') is-invalid @enderror" name="wilayah_odp" id="wilayah-odcp" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select area coverage') }} --</option>

                        @foreach ($areaCoverages as $areaCoverage)
                            <option value="{{ $areaCoverage->id }}" {{ isset($odp) && $odp->wilayah_odp == $areaCoverage->id ? 'selected' : (old('wilayah_odp') == $areaCoverage->id ? 'selected' : '') }}>
                                {{ $areaCoverage->kode_area }}
                            </option>
                        @endforeach
            </select>
            @error('wilayah_odp')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="warna-tube-fo">{{ __('Warna Tube Fo') }}</label>
            <input type="text" name="warna_tube_fo" id="warna-tube-fo" class="form-control @error('warna_tube_fo') is-invalid @enderror" value="{{ isset($odp) ? $odp->warna_tube_fo : old('warna_tube_fo') }}" placeholder="{{ __('Warna Tube Fo') }}" required />
            @error('warna_tube_fo')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nomor-tiang">{{ __('Nomor Tiang') }}</label>
            <input type="number" name="nomor_tiang" id="nomor-tiang" class="form-control @error('nomor_tiang') is-invalid @enderror" value="{{ isset($odp) ? $odp->nomor_tiang : old('nomor_tiang') }}" placeholder="{{ __('Nomor Tiang') }}" required />
            @error('nomor_tiang')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="jumlah-port">{{ __('Jumlah Port') }}</label>
            <input type="number" name="jumlah_port" id="jumlah-port" class="form-control @error('jumlah_port') is-invalid @enderror" value="{{ isset($odp) ? $odp->jumlah_port : old('jumlah_port') }}" placeholder="{{ __('Jumlah Port') }}" required />
            @error('jumlah_port')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    @isset($odp)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($odp->document == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Document" class="rounded mb-2 mt-2" alt="Document" width="100%" height="150" style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/documents/' . $odp->document) }}" alt="Document" class="rounded mb-2 mt-2" width="100%" height="150" style="object-fit: cover">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="document">{{ __('Document') }}</label>
                        <input type="file" name="document" class="form-control @error('document') is-invalid @enderror" id="document">

                        @error('document')
                          <span class="text-danger">
                                {{ $message }}
                           </span>
                        @enderror
                        <div id="documentHelpBlock" class="form-text">
                            {{ __('Leave the document blank if you don`t want to change it.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="form-group">
                <label for="document">{{ __('Document') }}</label>
                <input type="file" name="document" class="form-control @error('document') is-invalid @enderror" id="document">

                @error('document')
                   <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
    <div class="col-md-6">
        <div class="form-group">
            <label for="description">{{ __('Description') }}</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="{{ __('Description') }}" required>{{ isset($odp) ? $odp->description : old('description') }}</textarea>
            @error('description')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="latitude">{{ __('Latitude') }}</label>
                    <input type="text" name="latitude" id="latitude"
                        class="form-control @error('latitude') is-invalid @enderror"
                        value="{{ isset($odc) ? $odc->latitude : old('latitude') }}"
                        placeholder="{{ __('Latitude') }}" required readonly />
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
                    <input type="text" name="longitude" id="longitude"
                        class="form-control @error('longitude') is-invalid @enderror"
                        value="{{ isset($odc) ? $odc->longitude : old('longitude') }}"
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

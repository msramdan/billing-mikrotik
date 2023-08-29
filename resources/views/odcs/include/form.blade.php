<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="kode-odc">{{ __('Kode Odc') }}</label>
            <input type="text" name="kode_odc" id="kode-odc" class="form-control @error('kode_odc') is-invalid @enderror" value="{{ isset($odc) ? $odc->kode_odc : old('kode_odc') }}" placeholder="{{ __('Kode Odc') }}" required />
            @error('kode_odc')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="wilayah-odc">{{ __('Area Coverage') }}</label>
            <select class="form-select @error('wilayah_odc') is-invalid @enderror" name="wilayah_odc" id="wilayah-odc" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select area coverage') }} --</option>
                
                        @foreach ($areaCoverages as $areaCoverage)
                            <option value="{{ $areaCoverage->id }}" {{ isset($odc) && $odc->wilayah_odc == $areaCoverage->id ? 'selected' : (old('wilayah_odc') == $areaCoverage->id ? 'selected' : '') }}>
                                {{ $areaCoverage->kode_area }}
                            </option>
                        @endforeach
            </select>
            @error('wilayah_odc')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nomor-port-olt">{{ __('Nomor Port Olt') }}</label>
            <input type="number" name="nomor_port_olt" id="nomor-port-olt" class="form-control @error('nomor_port_olt') is-invalid @enderror" value="{{ isset($odc) ? $odc->nomor_port_olt : old('nomor_port_olt') }}" placeholder="{{ __('Nomor Port Olt') }}" required />
            @error('nomor_port_olt')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="warna-tube-fo">{{ __('Warna Tube Fo') }}</label>
            <input type="text" name="warna_tube_fo" id="warna-tube-fo" class="form-control @error('warna_tube_fo') is-invalid @enderror" value="{{ isset($odc) ? $odc->warna_tube_fo : old('warna_tube_fo') }}" placeholder="{{ __('Warna Tube Fo') }}" required />
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
            <input type="number" name="nomor_tiang" id="nomor-tiang" class="form-control @error('nomor_tiang') is-invalid @enderror" value="{{ isset($odc) ? $odc->nomor_tiang : old('nomor_tiang') }}" placeholder="{{ __('Nomor Tiang') }}" required />
            @error('nomor_tiang')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    @isset($odc)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($odc->document == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Document" class="rounded mb-2 mt-2" alt="Document" width="200" height="150" style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/documents/' . $odc->document) }}" alt="Document" class="rounded mb-2 mt-2" width="200" height="150" style="object-fit: cover">
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
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="{{ __('Description') }}" required>{{ isset($odc) ? $odc->description : old('description') }}</textarea>
            @error('description')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="latitude">{{ __('Latitude') }}</label>
            <input type="text" name="latitude" id="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ isset($odc) ? $odc->latitude : old('latitude') }}" placeholder="{{ __('Latitude') }}" required />
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
            <input type="text" name="longitude" id="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ isset($odc) ? $odc->longitude : old('longitude') }}" placeholder="{{ __('Longitude') }}" required />
            @error('longitude')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
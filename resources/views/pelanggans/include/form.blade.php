<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="coverage-area">{{ __('Area Coverage') }}</label>
            <select class="form-select @error('coverage_area') is-invalid @enderror" name="coverage_area" id="coverage-area" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select area coverage') }} --</option>

                        @foreach ($areaCoverages as $areaCoverage)
                            <option value="{{ $areaCoverage->id }}" {{ isset($pelanggan) && $pelanggan->coverage_area == $areaCoverage->id ? 'selected' : (old('coverage_area') == $areaCoverage->id ? 'selected' : '') }}>
                                {{ $areaCoverage->kode_area }} - {{ $areaCoverage->nama }}
                            </option>
                        @endforeach
            </select>
            @error('coverage_area')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="odc">{{ __('Odc') }}</label>
            <select class="form-select @error('odc') is-invalid @enderror" name="odc" id="odc" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select odc') }} --</option>

                        @foreach ($odcs as $odc)
                            <option value="{{ $odc->id }}" {{ isset($pelanggan) && $pelanggan->odc == $odc->id ? 'selected' : (old('odc') == $odc->id ? 'selected' : '') }}>
                                {{ $odc->kode_odc }}
                            </option>
                        @endforeach
            </select>
            @error('odc')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="odp">{{ __('Odp') }}</label>
            <select class="form-select @error('odp') is-invalid @enderror" name="odp" id="odp" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select odp') }} --</option>

                        @foreach ($odps as $odp)
                            <option value="{{ $odp->id }}" {{ isset($pelanggan) && $pelanggan->odp == $odp->id ? 'selected' : (old('odp') == $odp->id ? 'selected' : '') }}>
                                {{ $odp->kode_odp }}
                            </option>
                        @endforeach
            </select>
            @error('odp')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="no-port-odp">{{ __('No Port Odp') }}</label>
            <select class="form-select @error('no_port_odp') is-invalid @enderror" name="no_port_odp" id="no-port-odp" class="form-control">
                <option value="" selected disabled>-- {{ __('Select no port odp') }} --</option>
                <option value="1" {{ isset($pelanggan) && $pelanggan->no_port_odp == '1' ? 'selected' : (old('no_port_odp') == '1' ? 'selected' : '') }}>1</option>
		<option value="2" {{ isset($pelanggan) && $pelanggan->no_port_odp == '2' ? 'selected' : (old('no_port_odp') == '2' ? 'selected' : '') }}>2</option>
            </select>
            @error('no_port_odp')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="no-layanan">{{ __('No Layanan') }}</label>
            <input type="number" name="no_layanan" id="no-layanan" class="form-control @error('no_layanan') is-invalid @enderror" value="{{ isset($pelanggan) ? $pelanggan->no_layanan : old('no_layanan') }}" placeholder="{{ __('No Layanan') }}" />
            @error('no_layanan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama">{{ __('Nama') }}</label>
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ isset($pelanggan) ? $pelanggan->nama : old('nama') }}" placeholder="{{ __('Nama') }}" required />
            @error('nama')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tanggal-daftar">{{ __('Tanggal Daftar') }}</label>
            <input type="date" name="tanggal_daftar" id="tanggal-daftar" class="form-control @error('tanggal_daftar') is-invalid @enderror" value="{{ isset($pelanggan) && $pelanggan->tanggal_daftar ? $pelanggan->tanggal_daftar->format('Y-m-d') : old('tanggal_daftar') }}" placeholder="{{ __('Tanggal Daftar') }}" required />
            @error('tanggal_daftar')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ isset($pelanggan) ? $pelanggan->email : old('email') }}" placeholder="{{ __('Email') }}" required />
            @error('email')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="no-wa">{{ __('No Wa') }}</label>
            <input type="number" name="no_wa" id="no-wa" class="form-control @error('no_wa') is-invalid @enderror" value="{{ isset($pelanggan) ? $pelanggan->no_wa : old('no_wa') }}" placeholder="{{ __('No Wa') }}" required />
            @error('no_wa')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="no-ktp">{{ __('No Ktp') }}</label>
            <input type="text" name="no_ktp" id="no-ktp" class="form-control @error('no_ktp') is-invalid @enderror" value="{{ isset($pelanggan) ? $pelanggan->no_ktp : old('no_ktp') }}" placeholder="{{ __('No Ktp') }}" required />
            @error('no_ktp')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    @isset($pelanggan)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($pelanggan->photo_ktp == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Photo Ktp" class="rounded mb-2 mt-2" alt="Photo Ktp" width="200" height="150" style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/photo_ktps/' . $pelanggan->photo_ktp) }}" alt="Photo Ktp" class="rounded mb-2 mt-2" width="200" height="150" style="object-fit: cover">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="photo_ktp">{{ __('Photo Ktp') }}</label>
                        <input type="file" name="photo_ktp" class="form-control @error('photo_ktp') is-invalid @enderror" id="photo_ktp">

                        @error('photo_ktp')
                          <span class="text-danger">
                                {{ $message }}
                           </span>
                        @enderror
                        <div id="photo_ktpHelpBlock" class="form-text">
                            {{ __('Leave the photo ktp blank if you don`t want to change it.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="form-group">
                <label for="photo_ktp">{{ __('Photo Ktp') }}</label>
                <input type="file" name="photo_ktp" class="form-control @error('photo_ktp') is-invalid @enderror" id="photo_ktp" required>

                @error('photo_ktp')
                   <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
    <div class="col-md-6">
        <div class="form-group">
            <label for="alamat">{{ __('Alamat') }}</label>
            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="{{ __('Alamat') }}" required>{{ isset($pelanggan) ? $pelanggan->alamat : old('alamat') }}</textarea>
            @error('alamat')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" {{ empty($pelanggan) ? ' required' : '' }}/>
            @error('password')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
            @isset($pelanggan)
                <div id="PasswordHelpBlock" class="form-text">
                    {{ __('Leave the Password & Password Confirmation blank if you don`t want to change them.') }}
                </div>
            @endisset
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="password-confirmation">{{ __('Password Confirmation') }}</label>
            <input type="password" name="password_confirmation" id="password-confirmation" class="form-control" placeholder="{{ __('Password Confirmation') }}" {{ empty($pelanggan) ? ' required' : '' }}/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="ppn">{{ __('Ppn') }}</label>
            <select class="form-select @error('ppn') is-invalid @enderror" name="ppn" id="ppn" class="form-control">
                <option value="" selected disabled>-- {{ __('Select ppn') }} --</option>
                <option value="Yes" {{ isset($pelanggan) && $pelanggan->ppn == 'Yes' ? 'selected' : (old('ppn') == 'Yes' ? 'selected' : '') }}>Yes</option>
		<option value="No" {{ isset($pelanggan) && $pelanggan->ppn == 'No' ? 'selected' : (old('ppn') == 'No' ? 'selected' : '') }}>No</option>
            </select>
            @error('ppn')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="status-berlangganan">{{ __('Status Berlangganan') }}</label>
            <select class="form-select @error('status_berlangganan') is-invalid @enderror" name="status_berlangganan" id="status-berlangganan" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select status berlangganan') }} --</option>
                <option value="Aktif" {{ isset($pelanggan) && $pelanggan->status_berlangganan == 'Aktif' ? 'selected' : (old('status_berlangganan') == 'Aktif' ? 'selected' : '') }}>Aktif</option>
		<option value="Non Aktif" {{ isset($pelanggan) && $pelanggan->status_berlangganan == 'Non Aktif' ? 'selected' : (old('status_berlangganan') == 'Non Aktif' ? 'selected' : '') }}>Non Aktif</option>
		<option value="Menungu" {{ isset($pelanggan) && $pelanggan->status_berlangganan == 'Menungu' ? 'selected' : (old('status_berlangganan') == 'Menungu' ? 'selected' : '') }}>Menungu</option>
            </select>
            @error('status_berlangganan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="paket-layanan">{{ __('Package') }}</label>
            <select class="form-select @error('paket_layanan') is-invalid @enderror" name="paket_layanan" id="paket-layanan" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select package') }} --</option>

                        @foreach ($packages as $package)
                            <option value="{{ $package->id }}" {{ isset($pelanggan) && $pelanggan->paket_layanan == $package->id ? 'selected' : (old('paket_layanan') == $package->id ? 'selected' : '') }}>
                                {{ $package->nama_layanan }} - {{ $package->harga }}
                            </option>
                        @endforeach
            </select>
            @error('paket_layanan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="jatuh-tempo">{{ __('Jatuh Tempo') }}</label>
            <input type="number" name="jatuh_tempo" id="jatuh-tempo" class="form-control @error('jatuh_tempo') is-invalid @enderror" value="{{ isset($pelanggan) ? $pelanggan->jatuh_tempo : old('jatuh_tempo') }}" placeholder="{{ __('Jatuh Tempo') }}" />
            @error('jatuh_tempo')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="kirim-tagihan-wa">{{ __('Kirim Tagihan Wa') }}</label>
            <select class="form-select @error('kirim_tagihan_wa') is-invalid @enderror" name="kirim_tagihan_wa" id="kirim-tagihan-wa" class="form-control">
                <option value="" selected disabled>-- {{ __('Select kirim tagihan wa') }} --</option>
                <option value="Yes" {{ isset($pelanggan) && $pelanggan->kirim_tagihan_wa == 'Yes' ? 'selected' : (old('kirim_tagihan_wa') == 'Yes' ? 'selected' : '') }}>Yes</option>
		<option value="No" {{ isset($pelanggan) && $pelanggan->kirim_tagihan_wa == 'No' ? 'selected' : (old('kirim_tagihan_wa') == 'No' ? 'selected' : '') }}>No</option>
            </select>
            @error('kirim_tagihan_wa')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="latitude">{{ __('Latitude') }}</label>
            <input type="text" name="latitude" id="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ isset($pelanggan) ? $pelanggan->latitude : old('latitude') }}" placeholder="{{ __('Latitude') }}" />
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
            <input type="text" name="longitude" id="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ isset($pelanggan) ? $pelanggan->longitude : old('longitude') }}" placeholder="{{ __('Longitude') }}" />
            @error('longitude')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="auto-isolir">{{ __('Auto Isolir') }}</label>
            <select class="form-select @error('auto_isolir') is-invalid @enderror" name="auto_isolir" id="auto-isolir" class="form-control">
                <option value="" selected disabled>-- {{ __('Select auto isolir') }} --</option>
                <option value="Yes" {{ isset($pelanggan) && $pelanggan->auto_isolir == 'Yes' ? 'selected' : (old('auto_isolir') == 'Yes' ? 'selected' : '') }}>Yes</option>
		<option value="No" {{ isset($pelanggan) && $pelanggan->auto_isolir == 'No' ? 'selected' : (old('auto_isolir') == 'No' ? 'selected' : '') }}>No</option>
            </select>
            @error('auto_isolir')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tempo-isolir">{{ __('Tempo Isolir') }}</label>
            <input type="number" name="tempo_isolir" id="tempo-isolir" class="form-control @error('tempo_isolir') is-invalid @enderror" value="{{ isset($pelanggan) ? $pelanggan->tempo_isolir : old('tempo_isolir') }}" placeholder="{{ __('Tempo Isolir') }}" />
            @error('tempo_isolir')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="router">{{ __('Settingmikrotik') }}</label>
            <select class="form-select @error('router') is-invalid @enderror" name="router" id="router" class="form-control">
                <option value="" selected disabled>-- {{ __('Select settingmikrotik') }} --</option>

                        @foreach ($settingmikrotiks as $settingmikrotik)
                            <option value="{{ $settingmikrotik->id }}" {{ isset($pelanggan) && $pelanggan->router == $settingmikrotik->id ? 'selected' : (old('router') == $settingmikrotik->id ? 'selected' : '') }}>
                                {{ $settingmikrotik->identitas_router }}
                            </option>
                        @endforeach
            </select>
            @error('router')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="user-pppoe">{{ __('User Pppoe') }}</label>
            <input type="text" name="user_pppoe" id="user-pppoe" class="form-control @error('user_pppoe') is-invalid @enderror" value="{{ isset($pelanggan) ? $pelanggan->user_pppoe : old('user_pppoe') }}" placeholder="{{ __('User Pppoe') }}" />
            @error('user_pppoe')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
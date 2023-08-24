<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama-perusahaan">{{ __('Nama Perusahaan') }}</label>
            <input type="text" name="nama_perusahaan" id="nama-perusahaan"
                class="form-control @error('nama_perusahaan') is-invalid @enderror"
                value="{{ isset($company) ? $company->nama_perusahaan : old('nama_perusahaan') }}"
                placeholder="{{ __('Nama Perusahaan') }}" required />
            @error('nama_perusahaan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama-pemilik">{{ __('Nama Pemilik') }}</label>
            <input type="text" name="nama_pemilik" id="nama-pemilik"
                class="form-control @error('nama_pemilik') is-invalid @enderror"
                value="{{ isset($company) ? $company->nama_pemilik : old('nama_pemilik') }}"
                placeholder="{{ __('Nama Pemilik') }}" required />
            @error('nama_pemilik')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="telepon-perusahaan">{{ __('Telepon Perusahaan') }}</label>
            <input type="tel" name="telepon_perusahaan" id="telepon-perusahaan"
                class="form-control @error('telepon_perusahaan') is-invalid @enderror"
                value="{{ isset($company) ? $company->telepon_perusahaan : old('telepon_perusahaan') }}"
                placeholder="{{ __('Telepon Perusahaan') }}" required />
            @error('telepon_perusahaan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="no-wa">{{ __('No Wa') }}</label>
            <input type="tel" name="no_wa" id="no-wa"
                class="form-control @error('no_wa') is-invalid @enderror"
                value="{{ isset($company) ? $company->no_wa : old('no_wa') }}" placeholder="{{ __('No Wa') }}"
                required />
            @error('no_wa')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ isset($company) ? $company->email : old('email') }}" placeholder="{{ __('Email') }}"
                required />
            @error('email')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="alamat">{{ __('Alamat') }}</label>
            <textarea rows="7" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror"
                placeholder="{{ __('Alamat') }}" required>{{ isset($company) ? $company->alamat : old('alamat') }}</textarea>
            @error('alamat')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="deskripsi-perusahaan">{{ __('Deskripsi Perusahaan') }}</label>
            <textarea rows="7" name="deskripsi_perusahaan" id="deskripsi_perusahaan"
                class="form-control @error('deskripsi_perusahaan') is-invalid @enderror"
                placeholder="{{ __('Deskripsi Perusahaan') }}" required>{{ isset($company) ? $company->deskripsi_perusahaan : old('deskripsi_perusahaan') }}</textarea>

            @error('deskripsi_perusahaan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-4 text-center">
                @if ($company->logo == null)
                    <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Logo"
                        class="rounded mb-2 mt-2" alt="Logo" width="150" height="150"
                        style="object-fit: cover">
                @else
                    <img src="{{ asset('storage/uploads/logos/' . $company->logo) }}" alt="Logo"
                        class="rounded mb-2 mt-2" style="object-fit: cover; width:100%">
                @endif
            </div>

            <div class="col-md-8">
                <div class="form-group ms-3">
                    <label for="logo">{{ __('Logo') }}</label>
                    <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                        id="logo">
                    @error('logo')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    <div id="logoHelpBlock" class="form-text" style="font-size: 12px">
                        {{ __('Dimensions suggestion : 660x220 pixels | Max size : 2048 Kb') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-2 text-center">
                @if ($company->favicon == null)
                    <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Favicon"
                        class="rounded mb-2 mt-2" alt="Favicon" width="150" height="150"
                        style="object-fit: cover">
                @else
                    <img src="{{ asset('storage/uploads/favicons/' . $company->favicon) }}" alt="Favicon"
                        class="rounded mb-2 mt-2" style="object-fit: cover;width:100%">
                @endif
            </div>

            <div class="col-md-10">
                <div class="form-group ms-3">
                    <label for="favicon">{{ __('Favicon') }}</label>
                    <input type="file" name="favicon" class="form-control @error('favicon') is-invalid @enderror"
                        id="favicon">
                    @error('favicon')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    <div id="logoHelpBlock" class="form-text" style="font-size: 12px">
                        {{ __('Dimensions suggestion : 512x512 pixels | Max size : 2048 Kb') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

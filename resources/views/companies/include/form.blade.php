<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama-perusahaan">{{ __('Nama Perusahaan') }}</label>
            <input type="text" name="nama_perusahaan" id="nama-perusahaan" class="form-control @error('nama_perusahaan') is-invalid @enderror" value="{{ isset($company) ? $company->nama_perusahaan : old('nama_perusahaan') }}" placeholder="{{ __('Nama Perusahaan') }}" required />
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
            <input type="text" name="nama_pemilik" id="nama-pemilik" class="form-control @error('nama_pemilik') is-invalid @enderror" value="{{ isset($company) ? $company->nama_pemilik : old('nama_pemilik') }}" placeholder="{{ __('Nama Pemilik') }}" required />
            @error('nama_pemilik')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="telepon-perusahaan">{{ __('Telepon Perusahaan') }}</label>
            <input type="text" name="telepon_perusahaan" id="telepon-perusahaan" class="form-control @error('telepon_perusahaan') is-invalid @enderror" value="{{ isset($company) ? $company->telepon_perusahaan : old('telepon_perusahaan') }}" placeholder="{{ __('Telepon Perusahaan') }}" />
            @error('telepon_perusahaan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ isset($company) ? $company->email : old('email') }}" placeholder="{{ __('Email') }}" />
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
            <input type="text" name="no_wa" id="no-wa" class="form-control @error('no_wa') is-invalid @enderror" value="{{ isset($company) ? $company->no_wa : old('no_wa') }}" placeholder="{{ __('No Wa') }}" required />
            @error('no_wa')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="alamat">{{ __('Alamat') }}</label>
            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="{{ __('Alamat') }}">{{ isset($company) ? $company->alamat : old('alamat') }}</textarea>
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
            <textarea name="deskripsi_perusahaan" id="deskripsi-perusahaan" class="form-control @error('deskripsi_perusahaan') is-invalid @enderror" placeholder="{{ __('Deskripsi Perusahaan') }}">{{ isset($company) ? $company->deskripsi_perusahaan : old('deskripsi_perusahaan') }}</textarea>
            @error('deskripsi_perusahaan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    @isset($company)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($company->logo == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Logo" class="rounded mb-2 mt-2" alt="Logo" width="150" height="150" style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/logos/' . $company->logo) }}" alt="Logo" class="rounded mb-2 mt-2" width="150" height="150" style="object-fit: cover">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="logo">{{ __('Logo') }}</label>
                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" id="logo">

                        @error('logo')
                          <span class="text-danger">
                                {{ $message }}
                           </span>
                        @enderror
                        <div id="logoHelpBlock" class="form-text">
                            {{ __('Leave the logo blank if you don`t want to change it.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="form-group">
                <label for="logo">{{ __('Logo') }}</label>
                <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" id="logo">

                @error('logo')
                   <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
    @isset($company)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($company->favicon == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Favicon" class="rounded mb-2 mt-2" alt="Favicon" width="150" height="150" style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/favicons/' . $company->favicon) }}" alt="Favicon" class="rounded mb-2 mt-2" width="150" height="150" style="object-fit: cover">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="favicon">{{ __('Favicon') }}</label>
                        <input type="file" name="favicon" class="form-control @error('favicon') is-invalid @enderror" id="favicon">

                        @error('favicon')
                          <span class="text-danger">
                                {{ $message }}
                           </span>
                        @enderror
                        <div id="faviconHelpBlock" class="form-text">
                            {{ __('Leave the favicon blank if you don`t want to change it.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="form-group">
                <label for="favicon">{{ __('Favicon') }}</label>
                <input type="file" name="favicon" class="form-control @error('favicon') is-invalid @enderror" id="favicon">

                @error('favicon')
                   <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
    <div class="col-md-6">
        <div class="form-group">
            <label for="url-wa-gateway">{{ __('Url Wa Gateway') }}</label>
            <input type="url" name="url_wa_gateway" id="url-wa-gateway" class="form-control @error('url_wa_gateway') is-invalid @enderror" value="{{ isset($company) ? $company->url_wa_gateway : old('url_wa_gateway') }}" placeholder="{{ __('Url Wa Gateway') }}" required />
            @error('url_wa_gateway')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="api-key-wa-gateway">{{ __('Api Key Wa Gateway') }}</label>
            <input type="text" name="api_key_wa_gateway" id="api-key-wa-gateway" class="form-control @error('api_key_wa_gateway') is-invalid @enderror" value="{{ isset($company) ? $company->api_key_wa_gateway : old('api_key_wa_gateway') }}" placeholder="{{ __('Api Key Wa Gateway') }}" required />
            @error('api_key_wa_gateway')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="is-active">{{ __('Is Active WA') }}</label>
            <select class="form-select @error('is_active') is-invalid @enderror" name="is_active" id="is-active" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select is active') }} --</option>
                <option value="Yes" {{ isset($company) && $company->is_active == 'Yes' ? 'selected' : (old('is_active') == 'Yes' ? 'selected' : '') }}>Yes</option>
		<option value="No" {{ isset($company) && $company->is_active == 'No' ? 'selected' : (old('is_active') == 'No' ? 'selected' : '') }}>No</option>
            </select>
            @error('is_active')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="footer-pesan-wa-tagihan">{{ __('Footer Pesan Wa Tagihan') }}</label>
            <textarea name="footer_pesan_wa_tagihan" id="footer-pesan-wa-tagihan" class="form-control @error('footer_pesan_wa_tagihan') is-invalid @enderror" placeholder="{{ __('Footer Pesan Wa Tagihan') }}">{{ isset($company) ? $company->footer_pesan_wa_tagihan : old('footer_pesan_wa_tagihan') }}</textarea>
            @error('footer_pesan_wa_tagihan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="footer-pesan-wa-pembayaran">{{ __('Footer Pesan Wa Pembayaran') }}</label>
            <textarea name="footer_pesan_wa_pembayaran" id="footer-pesan-wa-pembayaran" class="form-control @error('footer_pesan_wa_pembayaran') is-invalid @enderror" placeholder="{{ __('Footer Pesan Wa Pembayaran') }}">{{ isset($company) ? $company->footer_pesan_wa_pembayaran : old('footer_pesan_wa_pembayaran') }}</textarea>
            @error('footer_pesan_wa_pembayaran')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="url-tripay">{{ __('Url Tripay') }}</label>
            <input type="text" name="url_tripay" id="url-tripay" class="form-control @error('url_tripay') is-invalid @enderror" value="{{ isset($company) ? $company->url_tripay : old('url_tripay') }}" placeholder="{{ __('Url Tripay') }}" required />
            @error('url_tripay')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="api-key-tripay">{{ __('Api Key Tripay') }}</label>
            <input type="text" name="api_key_tripay" id="api-key-tripay" class="form-control @error('api_key_tripay') is-invalid @enderror" value="{{ isset($company) ? $company->api_key_tripay : old('api_key_tripay') }}" placeholder="{{ __('Api Key Tripay') }}" required />
            @error('api_key_tripay')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="kode-merchant">{{ __('Kode Merchant') }}</label>
            <input type="text" name="kode_merchant" id="kode-merchant" class="form-control @error('kode_merchant') is-invalid @enderror" value="{{ isset($company) ? $company->kode_merchant : old('kode_merchant') }}" placeholder="{{ __('Kode Merchant') }}" required />
            @error('kode_merchant')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="private-key">{{ __('Private Key') }}</label>
            <input type="text" name="private_key" id="private-key" class="form-control @error('private_key') is-invalid @enderror" value="{{ isset($company) ? $company->private_key : old('private_key') }}" placeholder="{{ __('Private Key') }}" required />
            @error('private_key')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="paket-id">{{ __('Paket') }}</label>
            <select class="form-select @error('paket_id') is-invalid @enderror" name="paket_id" id="paket-id" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select paket') }} --</option>

                        @foreach ($pakets as $paket)
                            <option value="{{ $paket->id }}" {{ isset($company) && $company->paket_id == $paket->id ? 'selected' : (old('paket_id') == $paket->id ? 'selected' : '') }}>
                                {{ $paket->nama_paket }}
                            </option>
                        @endforeach
            </select>
            @error('paket_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="expired">{{ __('Expired') }}</label>
            <input type="date" name="expired" id="expired" class="form-control @error('expired') is-invalid @enderror" value="{{ isset($company) ? $company->expired : old('expired') }}" placeholder="{{ __('Expired') }}" required />
            @error('expired')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>

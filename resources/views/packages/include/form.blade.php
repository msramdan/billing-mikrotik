<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama-layanan">{{ __('Nama Layanan') }}</label>
            <input type="text" name="nama_layanan" id="nama-layanan"
                class="form-control @error('nama_layanan') is-invalid @enderror"
                value="{{ isset($package) ? $package->nama_layanan : old('nama_layanan') }}"
                placeholder="{{ __('Nama Layanan') }}" required />
            @error('nama_layanan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="harga">{{ __('Harga') }}</label>
            <input type="number" name="harga" id="harga"
                class="form-control @error('harga') is-invalid @enderror"
                value="{{ isset($package) ? $package->harga : old('harga') }}" placeholder="{{ __('Harga') }}"
                required />
            @error('harga')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="kategori-paket-id">{{ __('Package Category') }}</label>
            <select class="form-select @error('kategori_paket_id') is-invalid @enderror" name="kategori_paket_id"
                id="kategori-paket-id" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select package category') }} --</option>

                @foreach ($packageCategories as $packageCategory)
                    <option value="{{ $packageCategory->id }}"
                        {{ isset($package) && $package->kategori_paket_id == $packageCategory->id ? 'selected' : (old('kategori_paket_id') == $packageCategory->id ? 'selected' : '') }}>
                        {{ $packageCategory->nama_kategori }}
                    </option>
                @endforeach
            </select>
            @error('kategori_paket_id')
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
                placeholder="{{ __('Keterangan') }}" required>{{ isset($package) ? $package->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="is-active">{{ __('Is Active') }}</label>
            <select class="form-select @error('is_active') is-invalid @enderror" name="is_active" id="is-active"
                class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select is active') }} --</option>
                <option value="Yes"
                    {{ isset($package) && $package->is_active == 'Yes' ? 'selected' : (old('is_active') == 'Yes' ? 'selected' : '') }}>
                    Yes</option>
                <option value="No"
                    {{ isset($package) && $package->is_active == 'No' ? 'selected' : (old('is_active') == 'No' ? 'selected' : '') }}>
                    No</option>
            </select>
            @error('is_active')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>

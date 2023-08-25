<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama-kategori">{{ __('Nama Kategori') }}</label>
            <input type="text" name="nama_kategori" id="nama-kategori" class="form-control @error('nama_kategori') is-invalid @enderror" value="{{ isset($packageCategory) ? $packageCategory->nama_kategori : old('nama_kategori') }}" placeholder="{{ __('Nama Kategori') }}" required />
            @error('nama_kategori')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="keterangan">{{ __('Keterangan') }}</label>
            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" placeholder="{{ __('Keterangan') }}">{{ isset($packageCategory) ? $packageCategory->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
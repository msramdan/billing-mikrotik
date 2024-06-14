<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama-kategori-pemasukan">{{ __('Nama Kategori Pemasukan') }}</label>
            <input type="text" name="nama_kategori_pemasukan" id="nama-kategori-pemasukan" class="form-control @error('nama_kategori_pemasukan') is-invalid @enderror" value="{{ isset($categoryPemasukan) ? $categoryPemasukan->nama_kategori_pemasukan : old('nama_kategori_pemasukan') }}" placeholder="{{ __('Nama Kategori Pemasukan') }}" required />
            @error('nama_kategori_pemasukan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
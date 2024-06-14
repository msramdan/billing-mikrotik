<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama-kategori-pengeluaran">{{ __('Nama Kategori Pengeluaran') }}</label>
            <input type="text" name="nama_kategori_pengeluaran" id="nama-kategori-pengeluaran" class="form-control @error('nama_kategori_pengeluaran') is-invalid @enderror" value="{{ isset($categoryPengeluaran) ? $categoryPengeluaran->nama_kategori_pengeluaran : old('nama_kategori_pengeluaran') }}" placeholder="{{ __('Nama Kategori Pengeluaran') }}" required />
            @error('nama_kategori_pengeluaran')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
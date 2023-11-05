<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama-paket">{{ __('Nama Paket') }}</label>
            <input type="text" name="nama_paket" id="nama-paket" class="form-control @error('nama_paket') is-invalid @enderror" value="{{ isset($paket) ? $paket->nama_paket : old('nama_paket') }}" placeholder="{{ __('Nama Paket') }}" required />
            @error('nama_paket')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="jumlah-router">{{ __('Jumlah Router') }}</label>
            <input type="number" name="jumlah_router" id="jumlah-router" class="form-control @error('jumlah_router') is-invalid @enderror" value="{{ isset($paket) ? $paket->jumlah_router : old('jumlah_router') }}" placeholder="{{ __('Jumlah Router') }}" required />
            @error('jumlah_router')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="jumlah-pelanggan">{{ __('Jumlah Pelanggan') }}</label>
            <input type="number" name="jumlah_pelanggan" id="jumlah-pelanggan" class="form-control @error('jumlah_pelanggan') is-invalid @enderror" value="{{ isset($paket) ? $paket->jumlah_pelanggan : old('jumlah_pelanggan') }}" placeholder="{{ __('Jumlah Pelanggan') }}" required />
            @error('jumlah_pelanggan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
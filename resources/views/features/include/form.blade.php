<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="icon">{{ __('Icon') }}</label>
            <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror"
                value="{{ isset($feature) ? $feature->icon : old('icon') }}" placeholder="Contoh Input : <i class='fa fa-download'></i> " required />
            <div id="passwordHelpBlock" class="form-text">
                Untuk mendapatkan icon bisa kunjungi <a href="https://fontawesome.com/v4/icons/" target="_blank">LINK INI</a>
            </div>
            @error('icon')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="judul">{{ __('Judul') }}</label>
            <input type="text" name="judul" id="judul"
                class="form-control @error('judul') is-invalid @enderror"
                value="{{ isset($feature) ? $feature->judul : old('judul') }}" placeholder="{{ __('Judul') }}"
                required />
            @error('judul')
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
                placeholder="{{ __('Keterangan') }}" required>{{ isset($feature) ? $feature->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>

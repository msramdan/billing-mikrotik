<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nominal">{{ __('Nominal') }}</label>
            <input type="number" name="nominal" id="nominal" class="form-control @error('nominal') is-invalid @enderror" value="{{ isset($pemasukan) ? $pemasukan->nominal : old('nominal') }}" placeholder="{{ __('Nominal') }}" required />
            @error('nominal')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tanggal">{{ __('Tanggal') }}</label>
            <input type="datetime-local" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ isset($pemasukan) && $pemasukan->tanggal ? $pemasukan->tanggal->format('Y-m-d\TH:i') : old('tanggal') }}" placeholder="{{ __('Tanggal') }}" required />
            @error('tanggal')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="keterangan">{{ __('Keterangan') }}</label>
            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" placeholder="{{ __('Keterangan') }}" required>{{ isset($pemasukan) ? $pemasukan->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
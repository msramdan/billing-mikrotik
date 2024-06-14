<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nominal">{{ __('Nominal') }}</label>
            <input type="number" name="nominal" id="nominal" class="form-control @error('nominal') is-invalid @enderror"
                value="{{ isset($pemasukan) ? $pemasukan->nominal : old('nominal') }}" placeholder="{{ __('Nominal') }}"
                required />
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
            <input type="datetime-local" name="tanggal" id="tanggal"
                class="form-control @error('tanggal') is-invalid @enderror"
                value="{{ isset($pemasukan) && $pemasukan->tanggal ? $pemasukan->tanggal->format('Y-m-d\TH:i') : old('tanggal') }}"
                placeholder="{{ __('Tanggal') }}" required />
            @error('tanggal')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="wilayah-odcp">{{ __('Kategori pemasukan') }}</label>
            <select class="form-select @error('category_pemasukan_id') is-invalid @enderror" name="category_pemasukan_id" id="wilayah-odcp"
                class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select') }} --</option>

                @foreach ($categoryPemasukans as $row)
                    <option value="{{ $row->id }}"
                        {{ isset($pemasukan) && $pemasukan->category_pemasukan_id == $row->id ? 'selected' : (old('category_pemasukan_id') == $row->id ? 'selected' : '') }}>
                        {{ $row->nama_kategori_pemasukan }}
                    </option>
                @endforeach
            </select>
            @error('category_pemasukan_id')
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
                placeholder="{{ __('Keterangan') }}" required>{{ isset($pemasukan) ? $pemasukan->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>

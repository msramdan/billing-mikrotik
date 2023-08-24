<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="bank-id">{{ __('Bank') }}</label>
            <select class="form-select @error('bank_id') is-invalid @enderror" name="bank_id" id="bank-id"
                class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select bank') }} --</option>

                @foreach ($banks as $bank)
                    <option value="{{ $bank->id }}"
                        {{ isset($bankAccount) && $bankAccount->bank_id == $bank->id ? 'selected' : (old('bank_id') == $bank->id ? 'selected' : '') }}>
                        {{ $bank->nama_bank }}
                    </option>
                @endforeach
            </select>
            @error('bank_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="pemilik-rekening">{{ __('Pemilik Rekening') }}</label>
            <input type="text" name="pemilik_rekening" id="pemilik-rekening"
                class="form-control @error('pemilik_rekening') is-invalid @enderror"
                value="{{ isset($bankAccount) ? $bankAccount->pemilik_rekening : old('pemilik_rekening') }}"
                placeholder="{{ __('Pemilik Rekening') }}" required />
            @error('pemilik_rekening')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nomor-rekening">{{ __('Nomor Rekening') }}</label>
            <input type="number" name="nomor_rekening" id="nomor-rekening"
                class="form-control @error('nomor_rekening') is-invalid @enderror"
                value="{{ isset($bankAccount) ? $bankAccount->nomor_rekening : old('nomor_rekening') }}"
                placeholder="{{ __('Nomor Rekening') }}" required />
            @error('nomor_rekening')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>

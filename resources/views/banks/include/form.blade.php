<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama-bank">{{ __('Nama Bank') }}</label>
            <input type="text" name="nama_bank" id="nama-bank" class="form-control @error('nama_bank') is-invalid @enderror" value="{{ isset($bank) ? $bank->nama_bank : old('nama_bank') }}" placeholder="{{ __('Nama Bank') }}" required />
            @error('nama_bank')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    @isset($bank)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($bank->logo_bank == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Logo Bank" class="rounded mb-2 mt-2" alt="Logo Bank" width="200" height="150" style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/logo_banks/' . $bank->logo_bank) }}" alt="Logo Bank" class="rounded mb-2 mt-2" width="200" height="150" style="object-fit: cover">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="logo_bank">{{ __('Logo Bank') }}</label>
                        <input type="file" name="logo_bank" class="form-control @error('logo_bank') is-invalid @enderror" id="logo_bank">

                        @error('logo_bank')
                          <span class="text-danger">
                                {{ $message }}
                           </span>
                        @enderror
                        <div id="logo_bankHelpBlock" class="form-text">
                            {{ __('Leave the logo bank blank if you don`t want to change it.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="form-group">
                <label for="logo_bank">{{ __('Logo Bank') }}</label>
                <input type="file" name="logo_bank" class="form-control @error('logo_bank') is-invalid @enderror" id="logo_bank" required>

                @error('logo_bank')
                   <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
</div>
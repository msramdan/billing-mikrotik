<div class="row mb-2">
    <div class="col-md-4">
        <div class="form-group">
            <label for="no-tagihan">{{ __('No Tagihan') }}</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">INV-SSL-</span>
                </div>
                <input type="text" name="no_tagihan" required readonly id="no-tagihan"
                    class="form-control @error('no_tagihan') is-invalid @enderror"
                    value="{{ isset($tagihan) ? substr($tagihan->no_tagihan, 8) : old('no_tagihan') }}"
                    placeholder="{{ __('No Tagihan') }}" />
                <div class="input-group-prepend">
                    <button class="btn btn-success" type="button" onclick="generateNoLayanan()">Generate</button>
                </div>
            </div>
            @error('no_tagihan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="pelanggan-id">{{ __('Pelanggan') }}</label>
            <select class="form-select  js-example-basic-single @error('pelanggan_id') is-invalid @enderror"
                name="pelanggan_id" id="pelanggan-id" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select pelanggan') }} --</option>

                @foreach ($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->id }}"
                        {{ isset($tagihan) && $tagihan->pelanggan_id == $pelanggan->id ? 'selected' : (old('pelanggan_id') == $pelanggan->id ? 'selected' : '') }}>
                        {{ $pelanggan->nama }}
                    </option>
                @endforeach
            </select>
            @error('pelanggan_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="periode">{{ __('Periode Tagihan') }}</label>
            <input type="month" name="periode" id="periode"
                class="form-control @error('periode') is-invalid @enderror"
                value="{{ isset($tagihan) ? $tagihan->periode : old('periode') }}"
                placeholder="{{ __('No Tagihan') }}" required />
            @error('periode')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="nominal-bayar">{{ __('Nominal Bayar') }}</label>
            <input type="number" name="nominal_bayar" id="nominal-bayar"
                class="form-control @error('nominal_bayar') is-invalid @enderror"
                value="{{ isset($tagihan) ? $tagihan->nominal_bayar : old('nominal_bayar') }}"
                placeholder="{{ __('Nominal Bayar') }}" required />
            @error('nominal_bayar')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="potongan-bayar">{{ __('Potongan Bayar') }}</label>
            <input type="number" name="potongan_bayar" id="potongan-bayar"
                class="form-control @error('potongan_bayar') is-invalid @enderror"
                value="{{ isset($tagihan) ? $tagihan->potongan_bayar : old('potongan_bayar') }}"
                placeholder="{{ __('Potongan Bayar') }}" />
            @error('potongan_bayar')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="total-bayar">{{ __('Total Bayar') }}</label>
            <input readonly type="number" name="total_bayar" id="total-bayar"
                class="form-control @error('total_bayar') is-invalid @enderror"
                value="{{ isset($tagihan) ? $tagihan->total_bayar : old('total_bayar') }}"
                placeholder="{{ __('Total Bayar') }}" required />
            @error('total_bayar')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>

@push('js')
    <script>
        function generateNoLayanan() {
            let password = "";
            const allChars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            passwordLength = 10;
            for (let i = 0; i < passwordLength; i++) {
                const randomNumber = Math.floor(Math.random() * allChars.length);
                password += allChars.substring(randomNumber, randomNumber + 1);
            }

            const shuffled = password.split('').sort(function() {
                return 0.5 - Math.random()
            }).join('');
            $('#no-tagihan').val(shuffled);
        }
    </script>


    <script>
        function calculate() {
            var nominal = $('#nominal-bayar').val()
            var potongan = $('#potongan-bayar').val()
            var total_bayar = nominal - potongan
            if (isNaN(total_bayar)) {
                $('#total-bayar').val(0)
            } else {
                $('#total-bayar').val(total_bayar)
            }
        }

        $(document).ready(function() { //pertamakan document di load function ini d panggil
            calculate()
        })

        $(document).on('keyup mouseup', '#nominal-bayar,#potongan-bayar', function() {
            calculate()
        })
    </script>
@endpush

<td>
    @can('tagihan view')
        <a href="{{ route('tagihans.show', $model->id) }}" class="btn btn-outline-success btn-sm" title="Detail Tagihan">
            <i class="fa fa-eye"></i>
        </a>
        <a href="{{ route('invoice.pdf', $model->id) }}" class="btn btn-secondary btn-sm" target="_blank" title="Cetak Invoice">
            <i class="fa fa-print"></i>
        </a>
        @if ($model->status_bayar == 'Sudah Bayar')
            <button disabled class="btn btn-outline-warning btn-sm" title="Bayar Tagihan">
                <i class="fa fa-money-bill" aria-hidden="true"></i>
            </button>
        @else
            <button type="button" class="btn btn-outline-warning btn-sm identifyingClass" data-bs-toggle="modal"
                data-bs-target="#exampleModal{{ $model->id }}">
                <i class="fa fa-money-bill" aria-hidden="true"></i>
            </button>

            <div class="modal fade" id="exampleModal{{ $model->id }}" tabindex="-1" aria-labelledby="exampleModallview"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Bayar Tagihan</h5>
                        </div>

                        @php
                            $tunggakanCount = \App\Models\Tagihan::where('pelanggan_id', $model->pelanggan_id)
                                ->where('status_bayar', 'Belum Bayar')
                                ->count();
                        @endphp


                        <form action="{{ route('bayarTagihan') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div class="alert alert-danger" role="alert">
                                    Anda mempunya tunggakan {{$tunggakanCount}} bulan pembayaran. Harap segera bayarkan !!!
                                </div>

                                <input type="hidden" name="tagihan_id" value="{{ $model->id }}">
                                <input type="hidden" name="pelanggan_id" value="{{ $model->pelanggan_id }}">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="no-tagihan">{{ __('ID Pelanggan') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="no_layanan" required class="form-control" readonly
                                                value="{{ $model->no_layanan }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="no-tagihan">{{ __('No Tagihan') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="no_tagihan" required class="form-control" readonly
                                                value="{{ $model->no_tagihan }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="no-tagihan">{{ __('Nama Pelanggan') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="nama_pelanggan" required class="form-control"
                                                readonly value="{{ $model->nama }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="no-tagihan">{{ __('Periode') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="periode_waktu" required class="form-control"
                                                readonly value="{{ $model->periode }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="no-tagihan">{{ __('Nominal') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="number" name="nominal" readonly required class="form-control"
                                                value="{{ $model->total_bayar }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="no-tagihan">{{ __('Tanggal Bayar') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="date" name="tanggal_bayar" required class="form-control"
                                                value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="ppn">{{ __('Metode Bayar') }}</label>
                                        <select class="form-select" name="metode_bayar" required class="form-control">
                                            <option value="" selected disabled>-- {{ __('Select metode bayar') }} --
                                            </option>
                                            <option value="Cash">Cash</option>
                                            <option value="Transfer Bank">Transfer Bank</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 bank-account-field">
                                    <div class="form-group">
                                        <label for="ppn">{{ __('Bank Account') }}</label>
                                        <select class="form-select" name="bank_account_id" required class="form-control">
                                            <option value="" selected disabled>-- {{ __('Select bank account') }} --
                                            </option>
                                            @php
                                                $bankAccount = DB::table('bank_accounts')
                                                    ->join('banks', 'bank_accounts.bank_id', '=', 'banks.id')
                                                    ->select('bank_accounts.*', 'banks.nama_bank')
                                                    ->where('bank_accounts.company_id', '=', session('sessionCompany'))
                                                    ->get();
                                            @endphp
                                            @foreach ($bankAccount as $row)
                                                <option value="{{ $row->id }}">{{ $row->nama_bank }} -
                                                    {{ $row->pemilik_rekening }} - {{ $row->nomor_rekening }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Yes" id="notif"
                                        name="notif" checked>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Kirim Notif WA Pembayaran
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        @endif
    @endcan
    @if ($model->status_bayar == 'Sudah Bayar')
        <button disabled class="btn btn-outline-success btn-sm" title="Kirim Notif Tagihan WA"><i
                class="ace-icon bi bi-whatsapp"></i></button>

        @can('tagihan edit')
            <button disabled class="btn btn-outline-primary btn-sm" title="Edit Tagihan"><i
                    class="fa fa-pencil-alt"></i></button>
        @endcan
        @can('tagihan delete')
            @can('tagihan edit')
                <form action="{{ route('tagihans.destroy', $model->id) }}" method="post" class="d-inline"
                    onsubmit="return confirm('Are you sure to delete this record?')">
                    @csrf
                    @method('delete')

                    <button class="btn btn-outline-danger btn-sm" title="Hapus Tagihan">
                        <i class="ace-icon fa fa-trash-alt"></i>
                    </button>
                </form>
            @endcan
        @endcan
    @else
        <form action="{{ route('sendTagihanWa', $model->id) }}" method="POST" class="d-inline"
            onsubmit="return confirm('yakin kirim notifikasi tagihan wa ?')">
            @csrf
            @method('POST')
            <button class="btn btn-outline-success btn-sm" title="Kirim Notif Tagihan WA">
                <i class="ace-icon bi bi-whatsapp"></i>
            </button>
        </form>

        @can('tagihan edit')
            <a href="{{ route('tagihans.edit', $model->id) }}" class="btn btn-outline-primary btn-sm"
                title="Edit Tagihan">
                <i class="fa fa-pencil-alt"></i>
            </a>
        @endcan

        @can('tagihan delete')
            <form action="{{ route('tagihans.destroy', $model->id) }}" method="post" class="d-inline"
                onsubmit="return confirm('Are you sure to delete this record?')">
                @csrf
                @method('delete')

                <button class="btn btn-outline-danger btn-sm" title="Hapus Tagihan">
                    <i class="ace-icon fa fa-trash-alt"></i>
                </button>
            </form>
        @endcan
    @endif
</td>

<script>
    $(document).ready(function() {
        // Semula sembunyikan input Bank Account
        $('.bank-account-field').hide();

        // Ketika dropdown Metode Bayar berubah
        $('select[name="metode_bayar"]').change(function() {
            // Periksa apakah nilai yang dipilih adalah "Transfer Bank"
            if ($(this).val() === 'Transfer Bank') {
                // Jika ya, tampilkan input Bank Account
                $('.bank-account-field').show();
                // Jadikan input Bank Account wajib diisi
                $('select[name="bank_account_id"]').prop('required', true);
            } else {
                // Jika tidak, sembunyikan input Bank Account
                $('.bank-account-field').hide();
                // Buat input Bank Account tidak wajib diisi
                $('select[name="bank_account_id"]').prop('required', false);
            }
        });
    });
</script>

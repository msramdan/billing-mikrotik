<td>
    @can('tagihan view')
        <a href="{{ route('tagihans.show', $model->id) }}" class="btn btn-outline-success btn-sm" title="Detail Tagihan">
            <i class="fa fa-eye"></i>
        </a>
        <a href="{{ route('invoice.pdf', $model->id) }}" class="btn btn-secondary btn-sm" target="_blank" title="Cetak Invoice">
            <i class="fa fa-print"></i>
        </a>
        @if ($model->status_bayar == 'Sudah Bayar')
            <button disabled class="btn btn-outline-success btn-sm" title="Bayar Tagihan">
                <i class="fa fa-money-bill" aria-hidden="true"></i>
            </button>
        @else
            <button type="button" class="btn btn-outline-success btn-sm identifyingClass" data-bs-toggle="modal"
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
                        <form action="{{ route('bayarTagihan') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <input type="hidden" name="tagihan_id" value="{{$model->id}}">
                                <input type="hidden" name="pelanggan_id" value="{{$model->pelanggan_id}}">
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
                                            <input type="text" name="nama_pelanggan" required class="form-control" readonly
                                                value="{{ $model->nama }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="no-tagihan">{{ __('Periode') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="periode_waktu" required class="form-control" readonly
                                                value="{{ $model->periode }}" />
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
                                        <select class="form-select" name="metode_bayar"required class="form-control">
                                            <option value="" selected disabled>-- {{ __('Select metode bayar') }} --
                                            </option>
                                            <option value="Cash">Cash</option>
                                            <option value="Transfer Bank">Transfer Bank</option>
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

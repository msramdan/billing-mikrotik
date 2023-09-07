<td>
    @if ( $model->status_bayar =='Belum Bayar')
    <a href="{{ route('paymentList', $model->id) }}" class="btn btn-primary btn-sm" title="Bayar Tagihan">
        <i class="fa fa-dollar"></i> Bayar Tagihan
    </a>
    @else
    <button class="btn btn-primary btn-sm" title="Bayar Tagihan" disabled>
        <i class="fa fa-dollar"></i> Bayar Tagihan
    </button>
    @endif
    <a href="{{ route('showTagihan', $model->id) }}" class="btn btn-outline-success btn-sm" title="Detail Tagihan">
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('invoiceTagihan', $model->id) }}" class="btn btn-secondary btn-sm" target="_blank" title="Cetak Invoice">
        <i class="fa fa-print"></i>
    </a>
</td>

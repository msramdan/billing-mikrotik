<td>
    <a href="{{ route('showTagihan', $model->id) }}" class="btn btn-primary btn-sm" title="Detail Tagihan">
        <i class="fa fa-dollar"></i> Bayar Tagihan
    </a>
    <a href="{{ route('showTagihan', $model->id) }}" class="btn btn-outline-success btn-sm" title="Detail Tagihan">
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('invoiceTagihan', $model->id) }}" class="btn btn-secondary btn-sm" target="_blank" title="Cetak Invoice">
        <i class="fa fa-print"></i>
    </a>
</td>

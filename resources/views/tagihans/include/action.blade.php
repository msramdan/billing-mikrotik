<td>
    @can('tagihan view')
        <a href="{{ route('tagihans.show', $model->id) }}" class="btn btn-outline-success btn-sm" title="Detail Tagihan">
            <i class="fa fa-eye"></i>
        </a>
        {{-- @if ($model->status_bayar == 'Sudah Bayar')
            <form action="#" method="post" class="d-inline"
                onsubmit="return confirm('Kirim Wa Notifikasi sudah bayar tagihan ?')">
                @csrf
                @method('delete')

                <button class="btn btn-success btn-sm">
                    <span class="bi bi-whatsapp"></span>
                </button>
            </form>
        @else
            <form action="#" method="post" class="d-inline"
                onsubmit="return confirm('Kirim Wa Notifikasi belum bayar tagihan ?')">
                @csrf
                @method('delete')

                <button class="btn btn-success btn-sm">
                    <span class="bi bi-whatsapp"></span>
                </button>
            </form>
        @endif --}}
        <a href="#" class="btn btn-secondary btn-sm"  title="Cetak Invoice">
            <i class="fa fa-print"></i>
        </a>

        @if ($model->status_bayar == 'Sudah Bayar')
            <button disabled class="btn btn-outline-success btn-sm" title="Bayar Tagihan">
                <i class="fa fa-money-bill" aria-hidden="true"></i>
            </button>
        @else
            <a href="" class="btn btn-outline-success btn-sm" title="Bayar Tagihan">
                <i class="fa fa-money-bill" aria-hidden="true"></i>
            </a>
        @endif


    @endcan
    @if ($model->status_bayar == 'Sudah Bayar')
        @can('tagihan edit')
            <button disabled class="btn btn-outline-primary btn-sm" title="Edit Tagihan"><i class="fa fa-pencil-alt"></i></button>
        @endcan
        @can('tagihan delete')
            @can('tagihan edit')
                <button disabled class="btn btn-outline-danger btn-sm" title="Hapus Tagihan"><i class="ace-icon fa fa-trash-alt"></i></button>
            @endcan
        @endcan
    @else
        @can('tagihan edit')
            <a href="{{ route('tagihans.edit', $model->id) }}" class="btn btn-outline-primary btn-sm" title="Edit Tagihan">
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

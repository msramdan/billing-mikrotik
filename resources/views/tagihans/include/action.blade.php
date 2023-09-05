<td>
    @can('tagihan view')
        <a href="{{ route('tagihans.show', $model->id) }}" class="btn btn-outline-success btn-sm">
            <i class="fa fa-eye"></i>
        </a>

        @if ($model->status_bayar == 'Sudah Bayar')
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
        @endif

        <a href="#" class="btn btn-secondary btn-sm">
            <i class="fa fa-print"></i>
        </a>
    @endcan
    @if ($model->status_bayar == 'Sudah Bayar')
        @can('tagihan edit')
            <button disabled class="btn btn-outline-primary btn-sm"><i class="fa fa-pencil-alt"></i></button>
        @endcan
        @can('tagihan delete')
            @can('tagihan edit')
                <button disabled class="btn btn-outline-danger btn-sm"><i class="ace-icon fa fa-trash-alt"></i></button>
            @endcan
        @endcan
    @else
        @can('tagihan edit')
            <a href="{{ route('tagihans.edit', $model->id) }}" class="btn btn-outline-primary btn-sm">
                <i class="fa fa-pencil-alt"></i>
            </a>
        @endcan

        @can('tagihan delete')
            <form action="{{ route('tagihans.destroy', $model->id) }}" method="post" class="d-inline"
                onsubmit="return confirm('Are you sure to delete this record?')">
                @csrf
                @method('delete')

                <button class="btn btn-outline-danger btn-sm">
                    <i class="ace-icon fa fa-trash-alt"></i>
                </button>
            </form>
        @endcan
    @endif
</td>

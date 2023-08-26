<td>
    @can('secret ppp enable')
        <a href="" class="btn btn-outline-success btn-sm" title="Enable">
            <i class="fa fa-check"></i>
        </a>
    @endcan

    @can('secret ppp disable')
        <a href="" class="btn btn-outline-warning btn-sm" title="Disable">
            <i class="fa fa-times"></i>
        </a>
    @endcan

    @can('secret ppp delete')
        <form action="{{ route('secret-ppps.destroy', $model['.id']) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-outline-danger btn-sm" title="Delete">
                <i class="ace-icon fa fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>

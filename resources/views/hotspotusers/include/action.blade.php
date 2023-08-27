<td>
    @can('hotspotuser enable')
        <form action="{{ route('secret-ppps.enable', $model['.id']) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to enable this hotspot ?')">
            @csrf
            @method('PUT')
            <button class="btn btn-outline-success btn-sm" title="Enable">
                <i class="ace-icon fa fa-check"></i>
            </button>
        </form>
    @endcan
    @can('hotspotuser disable')
        <form action="{{ route('secret-ppps.disable', ['id' => $model['.id'], 'name' => $model['name']]) }}" method="post"
            class="d-inline" onsubmit="return confirm('Are you sure to disable this hotspot ?')">
            @csrf
            @method('PUT')
            <button class="btn btn-outline-warning btn-sm" title="Disable">
                <i class="ace-icon fa fa-times"></i>
            </button>
        </form>
    @endcan
    @can('hotspotuser reset')
        <form action="{{ route('secret-ppps.enable', $model['.id']) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to reset this hotspot ?')">
            @csrf
            @method('PUT')
            <button class="btn btn-outline-secondary btn-sm" title="Reset">
                <i class="ace-icon fa fa-refresh"></i>
            </button>
        </form>
    @endcan
    @can('hotspotuser delete')
        <form action="{{ route('hotspotusers.destroy', $model['.id']) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-outline-danger btn-sm">
                <i class="ace-icon fa fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>

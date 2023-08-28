<td>
    @can('hotspotuser enable')
        <form action="{{ route('hotspotusers.enable', $model['.id']) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to enable this hotspot ?')">
            @csrf
            @method('PUT')
            <button class="btn btn-outline-success btn-sm" title="Enable">
                <i class="ace-icon fa fa-check"></i>
            </button>
        </form>
    @endcan
    <?php
    $dataUser = $model['name'] ? $model['name'] : ' ';
    ?>
    @can('hotspotuser disable')
        <form action="{{ route('hotspotusers.disable', ['id' => $model['.id'], 'user' =>$dataUser]) }}" method="post"
            class="d-inline" onsubmit="return confirm('Are you sure to disable this hotspot ?')">
            @csrf
            @method('PUT')
            <button class="btn btn-outline-warning btn-sm" title="Disable">
                <i class="ace-icon fa fa-times"></i>
            </button>
        </form>
    @endcan
    @can('hotspotuser reset')
        <form action="{{ route('hotspotusers.reset', $model['.id']) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to reset counter this hotspot ?')">
            @csrf
            @method('PUT')
            <button class="btn btn-outline-secondary btn-sm" title="Reset">
                <i class="ace-icon fa fa-refresh"></i>
            </button>
        </form>
    @endcan
    @can('hotspotuser delete')
        <form action="{{ route('hotspotusers.delete',['id' => $model['.id'], 'user' =>$dataUser]) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-outline-danger btn-sm">
                <i class="ace-icon fa fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>

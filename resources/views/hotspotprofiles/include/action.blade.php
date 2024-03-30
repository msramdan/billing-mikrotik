<td>
    @can('hotspotprofile view')
    <a href="{{ route('hotspotprofiles.showDetail', ['name' => $model['name']]) }}" class="btn btn-outline-success btn-sm">
        <i class="fa fa-users"></i>
    </a>
    @endcan
    @can('hotspotprofile delete')
        <form action="{{ route('hotspotprofiles.deleteSecret', ['id' => $model['.id'], 'name' => $model['name']]) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')
            <button class="btn btn-outline-danger btn-sm">
                <i class="ace-icon fa fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>

<td>
    @can('hotspotprofile delete')
        <form action="{{ route('hotspotprofiles.deleteProfile', ['id' => $model['.id'], 'name' => $model['name']]) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')
            <button class="btn btn-outline-danger btn-sm">
                <i class="ace-icon fa fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>

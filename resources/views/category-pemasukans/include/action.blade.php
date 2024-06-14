<td>
    @can('category pemasukan view')
        <a href="{{ route('category-pemasukans.show', $model->id) }}" class="btn btn-outline-success btn-sm">
            <i class="fa fa-eye"></i>
        </a>
    @endcan
    @if ($model->id != '1')
        @can('category pemasukan edit')
            <a href="{{ route('category-pemasukans.edit', $model->id) }}" class="btn btn-outline-primary btn-sm">
                <i class="fa fa-pencil-alt"></i>
            </a>
        @endcan
        @can('category pemasukan delete')
            <form action="{{ route('category-pemasukans.destroy', $model->id) }}" method="post" class="d-inline"
                onsubmit="return confirm('Are you sure to delete this record?')">
                @csrf
                @method('delete')

                <button class="btn btn-outline-danger btn-sm">
                    <i class="ace-icon fa fa-trash-alt"></i>
                </button>
            </form>
        @endcan
    @endif

<td>
    @can('static view')
        <a href="{{ route('statics.show', $model['.id']) }}" class="btn btn-outline-success btn-sm">
            <i class="fa fa-eye"></i>
        </a>
    @endcan
</td>

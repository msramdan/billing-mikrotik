<td>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-gear"></i>
        </button>
        <ul class="dropdown-menu">
            @can('pelanggan view')
                <li>
                    <a href="{{ route('pelanggans.show', $model->id) }}" class="dropdown-item">Detail</a>
                </li>
            @endcan
            @can('pelanggan edit')
                <li>
                    <a href="{{ route('pelanggans.edit', $model->id) }}" class="dropdown-item">Edit</a>
                </li>
            @endcan
            <li><a class="dropdown-item"
                    href="{{ route('pelanggans.setNonToExpired', ['user_pppoe' => $model->user_pppoe]) }}">Set to Non
                    Expired</a></li>
            <li><a class="dropdown-item"
                    href="{{ route('pelanggans.setToExpired', ['user_pppoe' => $model->user_pppoe]) }}">Set to
                    Expired</a></li>
            @can('pelanggan delete')
                <li>
                    <form action="{{ route('pelanggans.destroy', $model->id) }}" method="post" class="d-inline"
                        onsubmit="return confirm('Are you sure to delete this record?')">
                        @csrf
                        @method('delete')
                        <button class="dropdown-item">Delete</button>
                    </form>
                </li>
            @endcan
        </ul>
    </div>
</td>

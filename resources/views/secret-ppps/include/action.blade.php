<td>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-gear"></i>
        </button>
        <ul class="dropdown-menu">
            @can('secret ppp enable')
                <li>
                    <form action="{{ route('secret-ppps.enable', $model['.id']) }}" method="post" class="d-inline"
                        onsubmit="return confirm('Are you sure to enable this secret ?')">
                        @csrf
                        @method('PUT')
                        <button class="dropdown-item" title="Enable">
                            Enable PPP
                        </button>
                    </form>
                </li>
            @endcan
            @can('secret ppp disable')
                <li>
                    <form action="{{ route('secret-ppps.disable', ['id' => $model['.id'], 'name' => $model['name']]) }}"
                        method="post" class="d-inline" onsubmit="return confirm('Are you sure to disable this secret ?')">
                        @csrf
                        @method('PUT')
                        <button class="dropdown-item" title="Disable">
                            Disable PPP
                        </button>
                    </form>
                </li>
            @endcan
            @can('secret ppp delete')
                <li>
                    <form
                        action="{{ route('secret-ppps.deleteSecret', ['id' => $model['.id'], 'name' => $model['name']]) }}"
                        method="post" class="d-inline" onsubmit="return confirm('Are you sure to delete this secret ?')">
                        @csrf
                        @method('delete')

                        <button class="dropdown-item" title="Delete">
                            Delete
                        </button>
                    </form>
                </li>
            @endcan
        </ul>
    </div>
</td>

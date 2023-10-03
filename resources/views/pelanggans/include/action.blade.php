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

            @if ($model->mode_user == 'Static')
                @if ($model->status_berlangganan == 'Menunggu')
                    <li><button class="dropdown-item" disabled>Set to Non Expired</button></li>
                    <li><button class="dropdown-item" disabled>Set to Expired</button></li>
                @else
                    <li><a class="dropdown-item"
                            href="{{ route('pelanggans.setNonToExpiredStatic', [
                                'id' => $model->id,
                                'user_static' => $model->user_static,
                            ]) }}">Set
                            to Non Expired</a></li>
                    <li><a class="dropdown-item"
                            href="{{ route('pelanggans.setToExpiredStatic', [
                                'id' => $model->id,
                                'user_static' => $model->user_static,
                            ]) }}">Set
                            to Expired</a></li>
                @endif
            @else
                @if ($model->status_berlangganan == 'Menunggu')
                    <li><button class="dropdown-item" disabled>Set to Non Expired</button></li>
                    <li><button class="dropdown-item" disabled>Set to Expired</button></li>
                @else
                    <li><a class="dropdown-item"
                            href="{{ route('pelanggans.setNonToExpired', [
                                'id' => $model->id,
                                'user_pppoe' => $model->user_pppoe,
                            ]) }}">Set
                            to Non Expired</a></li>
                    <li><a class="dropdown-item"
                            href="{{ route('pelanggans.setToExpired', [
                                'id' => $model->id,
                                'user_pppoe' => $model->user_pppoe,
                            ]) }}">Set
                            to Expired</a></li>
                @endif
            @endif

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
            <li>
                <a target="_blank" href="http://maps.google.com/?q={{ $model->latitude }},{{ $model->longitude }}"
                    class="dropdown-item">Direct Gmaps</a>
            </li>
        </ul>
    </div>
</td>

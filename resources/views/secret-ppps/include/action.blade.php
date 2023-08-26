<td>
    @can('secret ppp enable')
        <form action="{{ route('secret-ppps.enable', $model['.id']) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to enable this secret ?')">
            @csrf
            @method('PUT')
            <button class="btn btn-outline-success btn-sm" title="Enable">
                <i class="ace-icon fa fa-check"></i>
            </button>
        </form>
    @endcan

    @can('secret ppp disable')
        <form action="{{ route('secret-ppps.disable', $model['.id']) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to disable this secret ?')">
            @csrf
            @method('PUT')
            <button class="btn btn-outline-warning btn-sm" title="Disable">
                <i class="ace-icon fa fa-times"></i>
            </button>
        </form>
    @endcan

    @can('secret ppp delete')
        <form action="{{ route('secret-ppps.destroy', $model['.id']) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this secret ?')">
            @csrf
            @method('delete')

            <button class="btn btn-outline-danger btn-sm" title="Delete">
                <i class="ace-icon fa fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>

@push('js')
    <script>
        function validateForm() {
            event.preventDefault(); // prevent form submit
            var form = document.forms["myForm"]; // storing the form
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    } else {
                        swal("Your imaginary file is safe!");
                    }
                });
        }
    </script>
@endpush

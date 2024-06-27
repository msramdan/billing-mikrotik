</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('mazer') }}/js/app.js"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>

<script>
    $(document).ready(function() {
        $('#changeCompany').change(function() {
            var selectedValue = $(this).val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: '{{ route('updateSession') }}',
                data: {
                    selectedValue: selectedValue,
                    _token: csrfToken
                },
                success: function(res) {
                    if (res.success) {
                        window.location.href = '/dashboard';
                        // location.reload();
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#routerSelect').change(function() {
            var selectedValue = $(this).val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: '{{ route('routerSelect') }}',
                data: {
                    selectedValue: selectedValue,
                    _token: csrfToken
                },
                success: function(res) {
                    if (res.success) {
                        window.location.href = '/dashboard';
                        // location.reload();
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>


@include('sweetalert::alert')
@stack('js')
</body>

</html>

</div>
<!-- JQVMap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('mazer/assets/jqvmap/dist/jquery.vmap.js') }}"></script>
<script src="{{ asset('mazer/assets/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('mazer/assets/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
<script src="{{ asset('mazer') }}/js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

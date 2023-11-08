</div>
<!-- JQVMap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('mazer/assets/jqvmap/dist/jquery.vmap.js') }}"></script>
<script src="{{ asset('mazer/assets/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('mazer/assets/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
    integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
    crossorigin=""></script>
<script src="{{ asset('mazer') }}/js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src=" {{ asset('dist/leaflet.awesome-markers.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>

<script>
    $(document).ready(function() {
        $('#changeCompany').change(function() {
            var selectedValue = $(this).val();

            // Get the CSRF token value
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Make an Ajax request to set the session
            $.ajax({
                type: 'POST',
                url: '{{ route('updateSession') }}',
                data: {
                    selectedValue: selectedValue,
                    _token: csrfToken
                },
                success: function(response) {
                    // Reload the page or perform any other actions after successful session setting
                    if (response.success) {
                        window.location.href = '/dashboard';
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

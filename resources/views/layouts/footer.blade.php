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
@include('sweetalert::alert')
@stack('js')
</body>

</html>

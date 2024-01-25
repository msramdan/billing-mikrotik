<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="kode-odc">{{ __('Kode Odc') }}</label>
            <input type="text" name="kode_odc" id="kode-odc" class="form-control @error('kode_odc') is-invalid @enderror" value="{{ isset($odc) ? $odc->kode_odc : old('kode_odc') }}" placeholder="{{ __('Kode Odc') }}" required />
            @error('kode_odc')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="wilayah-odc">{{ __('Area Coverage') }}</label>
            <select class="form-select @error('wilayah_odc') is-invalid @enderror" name="wilayah_odc" id="wilayah-odc" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select area coverage') }} --</option>

                        @foreach ($areaCoverages as $areaCoverage)
                            <option value="{{ $areaCoverage->id }}" {{ isset($odc) && $odc->wilayah_odc == $areaCoverage->id ? 'selected' : (old('wilayah_odc') == $areaCoverage->id ? 'selected' : '') }}>
                                {{ $areaCoverage->kode_area }}
                            </option>
                        @endforeach
            </select>
            @error('wilayah_odc')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nomor-port-olt">{{ __('Nomor Port Olt') }}</label>
            <input type="number" name="nomor_port_olt" id="nomor-port-olt" class="form-control @error('nomor_port_olt') is-invalid @enderror" value="{{ isset($odc) ? $odc->nomor_port_olt : old('nomor_port_olt') }}" placeholder="{{ __('Nomor Port Olt') }}" required />
            @error('nomor_port_olt')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="warna-tube-fo">{{ __('Warna Tube Fo') }}</label>
            <input type="text" name="warna_tube_fo" id="warna-tube-fo" class="form-control @error('warna_tube_fo') is-invalid @enderror" value="{{ isset($odc) ? $odc->warna_tube_fo : old('warna_tube_fo') }}" placeholder="{{ __('Warna Tube Fo') }}" required />
            @error('warna_tube_fo')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nomor-tiang">{{ __('Nomor Tiang') }}</label>
            <input type="number" name="nomor_tiang" id="nomor-tiang" class="form-control @error('nomor_tiang') is-invalid @enderror" value="{{ isset($odc) ? $odc->nomor_tiang : old('nomor_tiang') }}" placeholder="{{ __('Nomor Tiang') }}" required />
            @error('nomor_tiang')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    @isset($odc)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($odc->document == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Document" class="rounded mb-2 mt-2" alt="Document" width="100%" height="150" style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/documents/' . $odc->document) }}" alt="Document" class="rounded mb-2 mt-2" width="100%" height="150" style="object-fit: cover">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="document">{{ __('Document') }}</label>
                        <input type="file" name="document" class="form-control @error('document') is-invalid @enderror" id="document">

                        @error('document')
                          <span class="text-danger">
                                {{ $message }}
                           </span>
                        @enderror
                        <div id="documentHelpBlock" class="form-text">
                            {{ __('Leave the document blank if you don`t want to change it.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="form-group">
                <label for="document">{{ __('Document') }}</label>
                <input type="file" name="document" class="form-control @error('document') is-invalid @enderror" id="document">

                @error('document')
                   <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
    <div class="col-md-6">
        <div class="form-group">
            <label for="description">{{ __('Description') }}</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="{{ __('Description') }}" required>{{ isset($odc) ? $odc->description : old('description') }}</textarea>
            @error('description')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="latitude">{{ __('Latitude') }}</label>
                    <input type="text" name="latitude" id="latitude"
                        class="form-control @error('latitude') is-invalid @enderror"
                        value="{{ isset($odc) ? $odc->latitude : old('latitude') }}"
                        placeholder="{{ __('Latitude') }}" required readonly />
                    @error('latitude')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="longitude">{{ __('Longitude') }}</label>
                    <input type="text" name="longitude" id="longitude"
                        class="form-control @error('longitude') is-invalid @enderror"
                        value="{{ isset($odc) ? $odc->longitude : old('longitude') }}"
                        placeholder="{{ __('Longitude') }}" required readonly />
                    @error('longitude')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <input type="text" id="locationInput" class="form-control" placeholder="Enter location"
                        style="margin-bottom: 5px">
                    <button type="button" class="btn btn-success" onclick="showMyLocation()"
                        style="margin-bottom: 5px">
                        <i class="fa fa-map-marker" aria-hidden="true"></i> Show My Location
                    </button>
                    <div class="map-embed" id="map"></div>
                </div>
            </div>
        </div>

    </div>


</div>
@push('js')
    <script>
        let map;
        let geocoder;
        let autocomplete;
        let initialMarker; // Marker dari database
        let markers = [];

        function initMap() {
            var initialLatitude = parseFloat("{{ isset($odc) ? $odc->latitude : -6.2088 }}");
            var initialLongitude = parseFloat("{{ isset($odc) ? $odc->longitude : 106.8456 }}");

            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: initialLatitude,
                    lng: initialLongitude
                },
                zoom: 12
            });

            // Tambahkan marker di posisi awal dari database
            initialMarker = new google.maps.Marker({
                position: {
                    lat: initialLatitude,
                    lng: initialLongitude
                },
                map: map,
                draggable: true // Sesuaikan dengan kebutuhan
            });

            markers.push(initialMarker);

            geocoder = new google.maps.Geocoder();

            autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('locationInput'), {
                    types: ['geocode']
                }
            );
            autocomplete.addListener('place_changed', onPlaceChanged);

            map.addListener('click', onMapClick);
        }

        function onMapClick(event) {
            const clickedLatLng = event.latLng;

            // Periksa apakah ada marker di posisi yang sama
            const existingMarkerIndex = findExistingMarkerIndex(clickedLatLng);

            if (existingMarkerIndex !== -1) {
                // Jika marker sudah ada, ganti posisi marker yang sudah ada
                markers[existingMarkerIndex].setPosition(clickedLatLng);
            } else {
                // Jika tidak ada, tambahkan marker baru
                clearMarkers();

                const marker = new google.maps.Marker({
                    position: clickedLatLng,
                    map: map,
                    draggable: true
                });

                document.getElementById('latitude').value = clickedLatLng.lat();
                document.getElementById('longitude').value = clickedLatLng.lng();

                marker.addListener('dragend', onMarkerDragEnd);

                markers.push(marker);
            }
        }

        function onMarkerDragEnd() {
            document.getElementById('latitude').value = markers[0].getPosition().lat();
            document.getElementById('longitude').value = markers[0].getPosition().lng();
        }

        function onPlaceChanged() {
            clearMarkers();

            const place = autocomplete.getPlace();
            if (place.geometry) {
                map.panTo(place.geometry.location);
                map.setZoom(15);

                const marker = new google.maps.Marker({
                    position: place.geometry.location,
                    map: map
                });

                document.getElementById('latitude').value = place.geometry.location.lat();
                document.getElementById('longitude').value = place.geometry.location.lng();

                markers.push(marker);
            } else {
                document.getElementById('locationInput').placeholder = 'Enter location';
            }
        }

        function showMyLocation() {
            clearMarkers();

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const myLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                    map.panTo(myLocation);
                    map.setZoom(15);

                    const marker = new google.maps.Marker({
                        position: myLocation,
                        map: map,
                        title: 'My Location'
                    });

                    document.getElementById('latitude').value = myLocation.lat();
                    document.getElementById('longitude').value = myLocation.lng();

                    markers.push(marker);
                }, function(error) {
                    console.error('Error getting location:', error.message);
                    alert('Error getting your location. Please make sure location services are enabled.');
                });
            } else {
                alert('Geolocation is not supported by your browser.');
            }
        }

        function clearMarkers() {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
            // Tambahkan marker dari database kembali setelah menghapus marker
            markers.push(initialMarker);
        }

        function findExistingMarkerIndex(latLng) {
            // Fungsi untuk mencari indeks marker yang sudah ada di dalam array
            for (let i = 0; i < markers.length; i++) {
                if (markers[i].getPosition().equals(latLng)) {
                    return i;
                }
            }
            return -1; // Mengembalikan -1 jika marker tidak ditemukan
        }
    </script>

    <script>
        const googleMapsApiKey = '{{ config('app.google_maps_api_key') }}';
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api_key') }}&libraries=places&callback=initMap">
    </script>
@endpush

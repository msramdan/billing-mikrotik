<div class="row mb-3">
    <div class="col-md-3">
        <div class="form-group">
            <label for="kode-area">{{ __('Kode Area') }}</label>
            <input type="text" name="kode_area" id="kode-area"
                class="form-control @error('kode_area') is-invalid @enderror"
                value="{{ isset($areaCoverage) ? $areaCoverage->kode_area : old('kode_area') }}"
                placeholder="{{ __('Kode Area') }}" required />
            @error('kode_area')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="nama">{{ __('Nama') }}</label>
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                value="{{ isset($areaCoverage) ? $areaCoverage->nama : old('nama') }}" placeholder="{{ __('Nama') }}"
                required />
            @error('nama')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tampilkan-register">{{ __('Tampilkan Register') }}</label>
            <select class="form-select @error('tampilkan_register') is-invalid @enderror" name="tampilkan_register"
                id="tampilkan-register" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select tampilkan register') }} --</option>
                <option value="Yes"
                    {{ isset($areaCoverage) && $areaCoverage->tampilkan_register == 'Yes' ? 'selected' : (old('tampilkan_register') == 'Yes' ? 'selected' : '') }}>
                    Yes</option>
                <option value="No"
                    {{ isset($areaCoverage) && $areaCoverage->tampilkan_register == 'No' ? 'selected' : (old('tampilkan_register') == 'No' ? 'selected' : '') }}>
                    No</option>
            </select>
            @error('tampilkan_register')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="alamat">{{ __('Alamat') }}</label>
            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror"
                placeholder="{{ __('Alamat') }}" required>{{ isset($areaCoverage) ? $areaCoverage->alamat : old('alamat') }}</textarea>
            @error('alamat')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="keterangan">{{ __('Keterangan') }}</label>
            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                placeholder="{{ __('Keterangan') }}" required>{{ isset($areaCoverage) ? $areaCoverage->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="radius">{{ __('Radius') }}</label>
                    <input type="number" name="radius" id="radius"
                        class="form-control @error('radius') is-invalid @enderror"
                        value="{{ isset($areaCoverage) ? $areaCoverage->radius : old('radius') }}"
                        placeholder="{{ __('Radius') }}" required />
                    @error('radius')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="latitude">{{ __('Latitude') }}</label>
                    <input type="text" name="latitude" id="latitude"
                        class="form-control @error('latitude') is-invalid @enderror"
                        value="{{ isset($areaCoverage) ? $areaCoverage->latitude : old('latitude') }}"
                        placeholder="{{ __('Latitude') }}" required readonly />
                    @error('latitude')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="longitude">{{ __('Longitude') }}</label>
                    <input type="text" name="longitude" id="longitude"
                        class="form-control @error('longitude') is-invalid @enderror"
                        value="{{ isset($areaCoverage) ? $areaCoverage->longitude : old('longitude') }}"
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

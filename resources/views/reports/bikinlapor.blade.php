<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ ('Buat Laporan Kerusakan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label for="title" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ __('Judul Singkat (Opsional)') }}</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                   class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200">
                            @error('title')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="category" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ __('Kategori Laporan') }} <span class="text-red-500">*</span></label>
                            <select name="category" id="category"
                                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200"
                                    required>
                                <option value="" disabled {{ old('category') ? '' : 'selected' }}>Pilih Kategori</option>
                                <option value="infrastruktur" {{ old('category') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                                <option value="lingkungan" {{ old('category') == 'lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                                <option value="pelayanan_publik" {{ old('category') == 'pelayanan_publik' ? 'selected' : '' }}>Pelayanan Publik</option>
                            </select>
                            @error('category')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ __('Deskripsi Kerusakan') }} <span class="text-red-500">*</span></label>
                            <textarea name="description" id="description" rows="5"
                                      class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200"
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="location_text" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ __('Deskripsi Alamat/Lokasi') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="location_text" id="location_text" value="{{ old('location_text') }}"
                                   class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200"
                                   required>
                            @error('location_text')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="map-picker-label" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ __('Pilih Lokasi di Peta (Klik pada peta)') }} <span class="text-red-500">*</span></label>
                            <div id="map-picker" style="height: 400px;" class="mt-1 rounded-lg border-gray-300 dark:border-gray-700 shadow-sm overflow-hidden bg-gray-200 dark:bg-gray-700/50">
                            </div>
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                            @error('latitude')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-2">Lokasi di peta wajib dipilih.</p>
                            @enderror
                        </div>

                        <div class="mb-8">
                            <label for="image" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ __('Upload Gambar Kerusakan') }} <span class="text-red-500">*</span></label>
                            <input type="file" name="image" id="image"
                                   class="mt-1 block w-full text-sm text-gray-700 dark:text-gray-300
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-lg file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-primary file:text-white
                                   hover:file:bg-primary-dark
                                   dark:file:bg-primary-dark dark:file:text-white dark:hover:file:bg-primary
                                   cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-light"
                                   required>
                            @error('image')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('laporan.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mr-6">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-primary border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-dark active:bg-primary-dark focus:outline-none focus:border-primary-dark focus:ring-2 focus:ring-offset-2 focus:ring-primary-light disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                                {{ __('Kirim Laporan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof L === 'undefined') { 
            console.error('Leaflet (L) tidak terdefinisi. Pastikan leaflet.js sudah dimuat.');
            alert('Pustaka peta gagal dimuat. Harap segarkan halaman.');
            return;
        }
        if (typeof L.Control.Geocoder === 'undefined') { 
            console.error('Leaflet Geocoder (L.Control.Geocoder) tidak terdefinisi. Pastikan Control.Geocoder.js sudah dimuat.');
            alert('Pustaka pencarian lokasi gagal dimuat. Harap segarkan halaman.');
            return;
        }

        const mapPickerElement = document.getElementById('map-picker');
        if (!mapPickerElement) {
            console.error("Elemen #map-picker tidak ditemukan untuk form create!");
            return;
        }

        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        const locationTextInput = document.getElementById('location_text'); 

        if (!latInput || !lngInput || !locationTextInput) {
            console.error("Satu atau lebih elemen input (latitude, longitude, location_text) tidak ditemukan!");
            return;
        }

        const oldLat = parseFloat(latInput.value);
        const oldLng = parseFloat(lngInput.value);

        const initialLat = (!isNaN(oldLat) && oldLat >= -90 && oldLat <= 90) ? oldLat : -8.170087;
        const initialLng = (!isNaN(oldLng) && oldLng >= -180 && oldLng <= 180) ? oldLng : 115.091095;
        const initialZoom = (!isNaN(oldLat) && !isNaN(oldLng)) ? 16 : 10;

        var map;
        try {
            map = L.map('map-picker').setView([initialLat, initialLng], initialZoom);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
            }).addTo(map);
        } catch (e) {
            console.error("Error saat inisialisasi peta L.map atau tileLayer:", e);
            mapPickerElement.innerHTML = '<p class="p-4 text-red-600 dark:text-red-400">Gagal memuat peta dasar. Periksa console.</p>';
            return;
        }

        var marker;
        var geocoder = L.Control.Geocoder.nominatim({
            geocodingQueryParams: { "countrycodes": "id" } 
        });

        function updateMarkerAndInputs(latlng, addressText = null, fromUserInput = false) {
            console.log('updateMarkerAndInputs dipanggil dengan:', latlng, 'Alamat Teks:', addressText, 'Dari User Input:', fromUserInput);

            latInput.value = latlng.lat.toFixed(7);
            lngInput.value = latlng.lng.toFixed(7);

            if (marker) {
                marker.setLatLng(latlng);
            } else {
                marker = L.marker(latlng, { draggable: true }).addTo(map);
                marker.on('dragend', function(event){
                    var markerLatLng = marker.getLatLng();
                    console.log('Marker di-drag ke:', markerLatLng);
                    geocoder.reverse(markerLatLng, map.options.crs.scale(map.getZoom()), function(results) {
                        if (results && results.length > 0 && results[0].name) {
                            console.log('Reverse geocode dari drag marker:', results[0].name);
                            updateMarkerAndInputs(markerLatLng, results[0].name, false); 
                        } else {
                            updateMarkerAndInputs(markerLatLng, null, false); 
                        }
                    });
                });
            }
            if (!fromUserInput) { 
                map.panTo(latlng);
            }


            if (addressText !== null && locationTextInput) {
                console.log('Mengupdate input teks alamat menjadi:', addressText);
                locationTextInput.value = addressText;
            }
            else if (marker && locationTextInput && addressText === null) {
                console.log('Melakukan reverse geocode untuk posisi marker:', marker.getLatLng());
                geocoder.reverse(marker.getLatLng(), map.options.crs.scale(map.getZoom()), function(results) {
                    if (results && results.length > 0 && results[0].name) {
                        console.log('Hasil reverse geocode:', results[0].name);
                        locationTextInput.value = results[0].name;
                    } else {
                        console.log('Reverse geocode tidak menemukan hasil.');
                    }
                });
            }
        }

        L.Control.geocoder({
            query: '', 
            placeholder: 'Cari alamat atau tempat...',
            defaultMarkGeocode: false, 
            geocoder: geocoder, 
            errorMessage: 'Pencarian tidak menemukan hasil.'
        })
        .on('markgeocode', function(e) { 
            var latlng = e.geocode.center;
            var addressName = e.geocode.name;
            console.log('Geocoder search box result:', e.geocode);
            map.fitBounds(e.geocode.bbox);
            updateMarkerAndInputs(latlng, addressName, false);
        })
        .addTo(map);
        if (!isNaN(oldLat) && !isNaN(oldLng)) {
            console.log('Memuat marker dari old value:', oldLat, oldLng);
            updateMarkerAndInputs(L.latLng(initialLat, initialLng), locationTextInput.value || null, false);
        }

        map.on('click', function(e) {
            console.log('Peta diklik pada:', e.latlng);
            updateMarkerAndInputs(e.latlng, null, false); 
        });

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        if (locationTextInput) {
            locationTextInput.addEventListener('input', debounce(function() {
                var query = locationTextInput.value.trim(); 
                console.log('Input teks alamat berubah. Query:', query);
                if (query.length > 3) {
                    console.log('Mencari (forward geocode) untuk:', query);
                    geocoder.geocode(query, function(results) { 
                        console.log('Hasil forward geocode dari input teks:', results);
                        if (results && results.length > 0) {
                            var bestResult = results[0];
                            console.log('Hasil terbaik dari input teks:', bestResult);
                            updateMarkerAndInputs(bestResult.center, bestResult.name, true); 
                            map.fitBounds(bestResult.bbox); 
                        } else {
                            console.log('Forward geocode dari input teks tidak menemukan hasil untuk:', query);
                        }
                    });
                } else {
                    console.log('Query dari input teks terlalu pendek, tidak melakukan geocode.');
                }
            }, 1200)); 
        } else {
            console.error('Elemen input #location_text tidak ditemukan untuk event listener.');
        }

        setTimeout(function() {
            if (map) {
                map.invalidateSize();
                console.log('Final map.invalidateSize() dipanggil.');
            }
        }, 500); 
    });
    </script>
    @endpush
</x-app-layout>
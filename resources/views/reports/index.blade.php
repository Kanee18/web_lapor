<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Peta dan Daftar Laporan Kerusakan') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Pesan Sukses --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 dark:bg-green-700/30 dark:text-green-300 dark:border-green-600 rounded-md shadow" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 dark:text-green-400 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div>
                            <p class="font-bold">Sukses!</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Jelajahi Laporan Terkini
                    </h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Lihat laporan kerusakan pada peta interaktif dan daftar di samping.
                    </p>
                </div>
                
                @auth
                    <a href="{{ route('laporan.bikinlapor') }}" class="w-full sm:w-auto shrink-0 inline-flex items-center justify-center px-6 py-3 bg-primary border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-primary-dark active:bg-primary-dark focus:outline-none focus:border-primary-dark focus:ring ring-primary-light disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                        Buat Laporan Baru
                    </a>
                @else
                     <button x-data @click.prevent="$dispatch('open-login-modal')" 
                        class="w-full sm:w-auto shrink-0 inline-flex items-center justify-center px-6 py-3 bg-primary border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-primary-dark active:bg-primary-dark focus:outline-none focus:border-primary-dark focus:ring ring-primary-light disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                        Login untuk Buat Laporan
                     </button>
                @endauth
            </div>

            <div class="flex flex-col md:flex-row md:gap-x-6 lg:gap-x-8">

                <div class="w-full md:w-2/5 lg:w-1/3 mb-8 md:mb-0">
                    <div class="md:sticky md:top-20 rounded-xl shadow-lg border dark:border-gray-700 overflow-hidden bg-gray-200 dark:bg-gray-800">
                        <div id="reports-map" style="height: 65vh; min-height: 450px;">
                            <div class="flex items-center justify-center h-full">
                                <p class="text-gray-500 dark:text-gray-400">Memuat peta...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-3/5 lg:w-2/3">
                    @if($reports->count() > 0) 
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            @foreach ($reports as $report)
                                <div id="report-card-{{ $report->id }}" class="report-card-item bg-white dark:bg-slate-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden group cursor-pointer"
                                     data-latitude="{{ $report->latitude ?? '' }}" data-longitude="{{ $report->longitude ?? '' }}">
                                    <a href="{{ route('laporan.show', $report->id) }}" class="block relative report-image-link">
                                        @if($report->image_path)
                                            <div class="aspect-w-16 aspect-h-9 bg-gray-200 dark:bg-slate-700">
                                                <img src="{{ asset('storage/' . $report->image_path) }}" alt="{{ $report->title ?? 'Gambar Laporan' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                            </div>
                                        @else
                                            <div class="aspect-w-16 aspect-h-9 w-full bg-gray-200 dark:bg-slate-700 flex items-center justify-center text-gray-400 dark:text-slate-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            </div>
                                        @endif
                                        {{-- Status Badge --}}
                                        <div class="absolute top-2 left-2 z-10">
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-md shadow
                                                @if($report->status == 'dilaporkan') bg-red-500 text-white @endif
                                                @if($report->status == 'diproses') bg-blue-500 text-white @endif
                                                @if($report->status == 'selesai') bg-green-500 text-white @endif">
                                                {{ Str::ucfirst($report->status) }}
                                            </span>
                                        </div>
                                    </a>
                                    <div class="p-4 flex flex-col flex-grow">
                                        <div class="flex-grow mb-2">
                                            <h3 class="text-md font-semibold text-gray-800 dark:text-gray-100 mb-1">
                                                <a href="{{ route('laporan.show', $report->id) }}" class="hover:text-primary dark:hover:text-primary-light transition duration-150 line-clamp-2">
                                                    {{ $report->title ?: 'Laporan Kerusakan' }} 
                                                </a>
                                            </h3>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center mb-1" title="{{ $report->location_text }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 text-gray-400 dark:text-gray-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                                                <span class="line-clamp-1">{{ Str::limit($report->location_text, 35) }}</span>
                                            </p>
                                        </div>
                                        <div class="mt-auto pt-2 border-t border-gray-200 dark:border-slate-700 text-xs flex items-center justify-between">
                                            <div class="flex items-center text-gray-500 dark:text-gray-400" title="{{ $report->user->name ?? 'Anonim' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                                                <span class="line-clamp-1">{{ Str::limit($report->user->name ?? 'Anonim', 15) }}</span>
                                            </div>
                                            <span class="text-gray-500 dark:text-gray-400" title="{{ $report->created_at->format('d M Y H:i') }}">
                                                {{ $report->created_at->diffForHumans(null, true, true) }}
                                            </span> 
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if ($reports->hasPages())
                            <div class="mt-10">
                                {{ $reports->links() }} 
                            </div>
                        @endif
                    @else
                        <div class="bg-white dark:bg-slate-800 text-center py-12 px-6 rounded-xl shadow-lg">
                           <svg class="mx-auto h-16 w-16 text-gray-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0zM12 6.344A5.656 5.656 0 0117.657 12 5.656 5.656 0 0112 17.657 5.656 5.656 0 016.343 12 5.656 5.656 0 0112 6.344z" /></svg>
                            <h3 class="mt-4 text-xl font-semibold text-gray-800 dark:text-gray-100">Belum Ada Laporan</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Jadilah yang pertama melaporkan kerusakan atau periksa kembali nanti.
                            </p>
                            <div class="mt-8">
                                @auth
                                    <a href="{{ route('laporan.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-primary-dark active:bg-primary-dark focus:outline-none focus:border-primary-dark focus:ring ring-primary-light disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                                        Buat Laporan Baru
                                    </a>
                                @else
                                     <button x-data @click.prevent="$dispatch('open-login-modal')" class="inline-flex items-center justify-center px-6 py-3 bg-primary border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-primary-dark active:bg-primary-dark focus:outline-none focus:border-primary-dark focus:ring ring-primary-light disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                                        Login untuk Buat Laporan
                                     </button>
                                @endauth
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .report-card-highlight {
             @apply ring-2 ring-offset-2 ring-primary dark:ring-primary-light shadow-2xl scale-[1.03] z-10;
        }
        .leaflet-popup-content-wrapper { border-radius: 8px; box-shadow: theme('boxShadow.lg'); }
        .leaflet-popup-content { margin: 12px !important; font-size: 13px; line-height: 1.6; }
        .leaflet-popup-content b { font-weight: 600; color: theme('colors.gray.800'); display: block; margin-bottom: 4px;}
        .leaflet-popup-content a { color: theme colors.primary.600 ; font-weight: 500; }
        .leaflet-popup-content a:hover { text-decoration: underline; }
        .leaflet-popup-content { max-width: 200px !important; }
    </style>
    @endpush

    @push('scripts')
    <script>
        const StrHelper = {
            limit: function(value, limit = 100, end = '...') {
                if (!value) return '';
                value = String(value);
                return value.length <= limit ? value : value.substring(0, limit) + end;
            }
        };

        document.addEventListener('DOMContentLoaded', function () {
            const mapElement = document.getElementById('reports-map');
            if (!mapElement) {
                console.warn("Elemen peta #reports-map tidak ditemukan di halaman ini.");
                return;
            }

            let defaultLat = -8.170087;
            let defaultLng = 115.091095;
            let defaultZoom = 10;

            var reportsMap;
            try {
                reportsMap = L.map('reports-map', {
                }).setView([defaultLat, defaultLng], defaultZoom);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    maxZoom: 19,
                }).addTo(reportsMap);
            } catch (e) {
                 console.error("Gagal inisialisasi peta Leaflet:", e);
                 mapElement.innerHTML = '<p class="p-4 text-red-600 dark:text-red-400 text-center">Gagal memuat peta.</p>';
                 return;
            }


            const reportMarkers = L.layerGroup().addTo(reportsMap);
            const reportsData = @json($reports->items());
            let markers = {}; 

            function removeHighlight() {
                document.querySelectorAll('.report-card-item').forEach(function(el) {
                    el.classList.remove('report-card-highlight'); 
                });
            }

            function highlightCard(reportId) {
                removeHighlight(); 
                const card = document.getElementById('report-card-' + reportId);
                if (card) {
                    card.classList.add('report-card-highlight'); 
                }
            }

            reportsData.forEach(function(report) {
                if (report.latitude && report.longitude) {
                    const lat = parseFloat(report.latitude);
                    const lng = parseFloat(report.longitude);

                    if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                        const popupContent = `<b>${StrHelper.limit(report.title || 'Laporan Kerusakan', 35)}</b><br><a href="/laporan/${report.id}" class="text-primary hover:underline font-semibold">Lihat Detail</a>`;

                        const marker = L.marker([lat, lng], { reportId: report.id })
                            .bindPopup(popupContent, { minWidth: 150 }); 

                        markers[report.id] = marker; 

                        marker.on('click', function(e) {
                            reportsMap.flyTo(e.target.getLatLng(), 16); 
                            highlightCard(report.id);
                        });

                        marker.on('popupopen', function(e) {
                            highlightCard(report.id);
                        });

                        marker.on('popupclose', function(e) {
                            removeHighlight();
                        });

                        reportMarkers.addLayer(marker); 
                    } else {
                         console.warn(`Koordinat tidak valid untuk laporan ID ${report.id}: Lat ${report.latitude}, Lng ${report.longitude}`);
                    }
                } else {
                     console.warn(`Koordinat tidak ditemukan untuk laporan ID ${report.id}`);
                }
            });

            if (reportMarkers.getLayers().length > 0) {
                try {
                    reportsMap.fitBounds(reportMarkers.getBounds().pad(0.2)); 
                } catch(e) {
                    console.error("Error saat fitBounds:", e);
                    reportsMap.setView([defaultLat, defaultLng], defaultZoom);
                }
            } else {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        reportsMap.setView([position.coords.latitude, position.coords.longitude], 13);
                    }, function() { 
                        reportsMap.setView([defaultLat, defaultLng], defaultZoom);
                    });
                } else {
                    reportsMap.setView([defaultLat, defaultLng], defaultZoom);
                }
            }

            document.querySelectorAll('.report-card-item').forEach(function(cardElement) {
                cardElement.addEventListener('click', function(e) {
                    if (e.target.closest('a')) return;

                    const reportId = this.id.split('-').pop(); 
                    highlightCard(reportId); 

                    const targetMarker = markers[reportId];
                    if (targetMarker) {
                        reportsMap.flyTo(targetMarker.getLatLng(), 16);
                        targetMarker.openPopup();
                    } else {
                        const lat = parseFloat(this.dataset.latitude);
                        const lng = parseFloat(this.dataset.longitude);
                         if (!isNaN(lat) && !isNaN(lng)) {
                            reportsMap.flyTo([lat, lng], 16);
                        }
                    }
                });
            });

            setTimeout(() => {
                if(reportsMap) {
                     try { reportsMap.invalidateSize(); } catch(e){ console.error("Error invalidateSize:",e); }
                }
            }, 300);

            const resizeObserver = new ResizeObserver(() => {
                 if(reportsMap) {
                     try { reportsMap.invalidateSize(); } catch(e){ console.error("Error invalidateSize on resize:",e); }
                 }
            });
            if(mapElement) { resizeObserver.observe(mapElement); }

        });
    </script>
    @endpush

    @guest
        @include('auth.partials.login-modal')
        @include('auth.partials.register-modal')
    @endguest

</x-app-layout>
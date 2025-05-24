<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Dashboard Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold">Selamat Datang Kembali, {{ $user->name }}!</h3>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">Berikut adalah ringkasan aktivitas laporan Anda.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-lg text-center">
                    <p class="text-3xl font-bold text-primary dark:text-primary-light">{{ $totalUserReports }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Total Laporan Anda</p>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-lg text-center">
                    <p class="text-3xl font-bold text-yellow-500 dark:text-yellow-400">{{ $dilaporkanCount }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Masih Dilaporkan</p>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-lg text-center">
                    <p class="text-3xl font-bold text-blue-500 dark:text-blue-400">{{ $diprosesCount }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Sedang Diproses</p>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-lg text-center">
                    <p class="text-3xl font-bold text-green-500 dark:text-green-400">{{ $selesaiCount }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Sudah Selesai</p>
                </div>
            </div>

            <div class="mb-8 text-center sm:text-left">
                <a href="{{ route('laporan.bikinlapor') }}" class="inline-flex items-center justify-center px-8 py-3 bg-primary border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-primary-dark active:bg-primary-dark focus:outline-none focus:border-primary-dark focus:ring ring-primary-light disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg mb-3 sm:mb-0 sm:mr-4">
                    Buat Laporan Baru
                </a>
                <a href="{{ route('laporan.index') }}" class="inline-flex items-center justify-center px-8 py-3 bg-gray-600 dark:bg-gray-700 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                    Lihat Semua Laporan Saya
                </a>
            </div>

            @if($latestUserReports->count() > 0)
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Laporan Terbaru Anda:</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($latestUserReports as $report)
                            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg overflow-hidden flex flex-col group">
                                <a href="{{ route('laporan.show', $report->id) }}" class="block">
                                    @if($report->image_path)
                                        <div class="aspect-w-16 aspect-h-9 bg-gray-200 dark:bg-slate-700">
                                            <img src="{{ asset('storage/' . $report->image_path) }}" alt="{{ $report->title ?? 'Gambar Laporan' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                    @else
                                        <div class="aspect-w-16 aspect-h-9 w-full bg-gray-200 dark:bg-slate-700 flex items-center justify-center text-gray-400 dark:text-slate-500">
                                        </div>
                                    @endif
                                </a>
                                <div class="p-4 flex flex-col flex-grow">
                                    <h4 class="text-md font-semibold text-gray-800 dark:text-gray-100 mb-1">
                                        <a href="{{ route('laporan.show', $report->id) }}" class="hover:text-primary dark:hover:text-primary-light line-clamp-2">
                                            {{ $report->title ?? 'Laporan Kerusakan' }}
                                        </a>
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                        {{ $report->created_at->format('d M Y') }}
                                        <span class="font-semibold px-2 py-0.5 rounded-full text-xs ml-2
                                            @if($report->status == 'dilaporkan') bg-yellow-100 text-yellow-800 dark:bg-yellow-700/50 dark:text-yellow-300 @endif
                                            @if($report->status == 'diproses') bg-blue-100 text-blue-800 dark:bg-blue-700/50 dark:text-blue-300 @endif
                                            @if($report->status == 'selesai') bg-green-100 text-green-800 dark:bg-green-700/50 dark:text-green-300 @endif
                                        ">{{ Str::ucfirst($report->status) }}</span>
                                    </p>
                                    <div class="mt-auto pt-2">
                                        <a href="{{ route('laporan.show', $report->id) }}" class="text-xs font-semibold text-primary dark:text-primary-light hover:underline">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-900 dark:text-gray-100">
                        <p>Anda belum membuat laporan apapun.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
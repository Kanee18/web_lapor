<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold">Selamat Datang, Admin {{ Auth::user()->name }}!</h3>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">Ringkasan status aplikasi saat ini.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalUsers }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Laporan Masuk</p>
                    <p class="text-3xl font-bold text-primary dark:text-primary-light mt-1">{{ $totalReports }}</p>
                </div>
                <div></div> {{-- Spacer --}}
                <div class="bg-yellow-50 dark:bg-yellow-700/30 p-6 rounded-xl shadow-lg">
                    <p class="text-sm text-yellow-700 dark:text-yellow-300">Laporan "Dilaporkan"</p>
                    <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">{{ $dilaporkanCount }}</p>
                </div>
                <div class="bg-blue-50 dark:bg-blue-700/30 p-6 rounded-xl shadow-lg">
                    <p class="text-sm text-blue-700 dark:text-blue-300">Laporan "Diproses"</p>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $diprosesCount }}</p>
                </div>
                <div class="bg-green-50 dark:bg-green-700/30 p-6 rounded-xl shadow-lg">
                    <p class="text-sm text-green-700 dark:text-green-300">Laporan "Selesai"</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $selesaiCount }}</p>
                </div>
            </div>

            <div class="mb-8">
                <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-primary-dark active:bg-primary-dark focus:outline-none focus:border-primary-dark focus:ring ring-primary-light disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                    Kelola Semua Laporan
                </a>
                {{-- Tambahkan link manajemen pengguna dll jika ada --}}
            </div>


            @if($recentPendingReports->count() > 0)
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Laporan Baru (<span class="text-red-500">Dilaporkan</span>):</h3>
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pelapor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recentPendingReports as $report)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ Str::limit($report->title ?? $report->description, 40) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $report->user->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $report->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.reports.index', ['highlight_report' => $report->id]) }}" class="text-primary hover:text-primary-dark dark:text-primary-light dark:hover:text-primary">
                                                Lihat & Proses
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                 <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg text-center">
                    <p class="text-gray-600 dark:text-gray-400">Tidak ada laporan baru yang menunggu untuk diproses saat ini.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
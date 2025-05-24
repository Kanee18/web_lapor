<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Laporan Kerusakan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8"> 

            @if (session('success_status_update'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-green-700 dark:border-green-600 dark:text-green-100" role="alert">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success_status_update') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Daftar Semua Laporan</h3>

                    @if($reports->count())
                        <div class="overflow-x-auto"> 
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Judul</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pelapor</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lokasi</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tgl Dilaporkan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($reports as $report)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                <a href="{{ route('laporan.show', $report->id) }}" class="hover:underline" target="_blank">
                                                    {{ $report->title ?? Str::limit($report->description, 30) }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $report->user->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($report->location_text, 35) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $report->created_at->format('d M Y, H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($report->status == 'dilaporkan') bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100 @endif
                                                    @if($report->status == 'diproses') bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100 @endif
                                                    @if($report->status == 'selesai') bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100 @endif
                                                ">
                                                    {{ Str::ucfirst($report->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                {{-- Form untuk Ubah Status --}}
                                                <form method="POST" action="{{ route('admin.reports.updateStatus', $report->id) }}" class="inline-flex items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" class="text-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 mr-2">
                                                        <option value="dilaporkan" @if($report->status == 'dilaporkan') selected @endif>Dilaporkan</option>
                                                        <option value="diproses" @if($report->status == 'diproses') selected @endif>Diproses</option>
                                                        <option value="selesai" @if($report->status == 'selesai') selected @endif>Selesai</option>
                                                    </select>
                                                    <button type="submit" class="text-xs text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 px-2 py-1 bg-indigo-100 dark:bg-indigo-700/50 rounded-md">Update</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                         {{-- Link Paginasi --}}
                        <div class="mt-6">
                            {{ $reports->links() }}
                        </div>
                    @else
                        <p>Belum ada laporan kerusakan yang masuk.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
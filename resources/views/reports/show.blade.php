<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ ('Detail Laporan Kerusakan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('laporan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    &larr; Kembali ke Daftar Laporan
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden mb-8">
                @if($report->image_path)
                    <img src="{{ asset('storage/' . $report->image_path) }}" alt="{{ $report->title ?? 'Gambar Laporan' }}" class="w-full h-auto max-h-[500px] object-contain bg-gray-100 dark:bg-gray-700">
                @endif
                <div class="p-6 md:p-8">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3">
                        {{ $report->title ?? 'Laporan Kerusakan' }}
                    </h3>
                    <div class="mb-6 space-y-2 text-sm text-gray-600 dark:text-gray-400">
                         <p><strong class="font-semibold text-gray-700 dark:text-gray-300">Lokasi:</strong> {{ $report->location_text }}</p>
                         <p><strong class="font-semibold text-gray-700 dark:text-gray-300">Status:</strong>
                             <span class="font-semibold px-2 py-0.5 rounded-full text-xs
                             ">
                                 {{ Str::ucfirst($report->status) }}
                             </span>
                         </p>
                         <p><strong class="font-semibold text-gray-700 dark:text-gray-300">Dilaporkan oleh:</strong> {{ $report->user->name ?? 'Anonim' }}</p>
                         <p><strong class="font-semibold text-gray-700 dark:text-gray-300">Dilaporkan pada:</strong> {{ $report->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Deskripsi Lengkap:</p>
                        {!! nl2br(e($report->description)) !!}
                    </div>
                </div>
            </div>

            @if (session('success_comment'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-green-700 dark:border-green-600 dark:text-green-100" role="alert">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success_comment') }}</span>
                </div>
            @endif

            {{-- Bagian Komentar --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 md:p-8">
                <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Komentar ({{ $report->comments->count() }})</h4>

                @auth
                    <div class="mb-8">
                        <form method="POST" action="{{ route('comments.store', $report->id) }}">
                            @csrf
                            <div class="mb-4">
                                <label for="comment_body" class="sr-only">Tambahkan komentar</label>
                                <textarea name="body" id="comment_body" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                    placeholder="Tulis komentar Anda di sini..." required>{{ old('body') }}</textarea>
                                @error('body')
                                    <p class="text-sm text-red-600 dark:text-red-400 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Kirim Komentar
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="mb-8 border border-blue-200 dark:border-gray-700 bg-blue-50 dark:bg-gray-700/50 p-4 rounded-md text-center" x-data> 
                        <p class="text-sm text-blue-700 dark:text-gray-300">
                            Silakan
                            <button @click.prevent="$dispatch('open-login-modal')" class="font-semibold underline hover:text-blue-900 dark:hover:text-white focus:outline-none">Login</button>
                            atau
                            <button @click.prevent="$dispatch('open-register-modal')" class="font-semibold underline hover:text-blue-900 dark:hover:text-white focus:outline-none">Register</button>
                            untuk menambahkan komentar.
                        </p>
                    </div>
                @endguest

                @if($report->comments->count() > 0)
                    <div class="space-y-6">
                        @foreach($report->comments->sortByDesc('created_at') as $comment)
                            <div class="flex space-x-3">
                                {{-- Avatar Placeholder --}}
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $comment->user->name }}">
                                </div>
                                <div class="flex-1 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $comment->user->name ?? 'Anonim' }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400" title="{{ $comment->created_at->toDateTimeString() }}">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="text-sm text-gray-700 dark:text-gray-300 prose prose-sm dark:prose-invert max-w-none">
                                        {!! nl2br(e($comment->body)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada komentar untuk laporan ini.</p>
                @endif
            </div> 

        </div>
    </div>
</x-app-layout>
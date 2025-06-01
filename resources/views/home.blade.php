<x-app-layout> 
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ ('Selamat Datang Di LaporIn Bali') }}
        </h2>
    </x-slot>

    <div class="bg-gray-50 dark:bg-gray-800/50">
        <div class="relative isolate overflow-hidden">
            
            <div class="absolute inset-0 -z-10 bg-gradient-to-br from-primary/30 via-transparent to-secondary/30 dark:from-primary/50 dark:via-gray-900 dark:to-secondary/50 opacity-50"></div>
            
            <div class="mx-auto max-w-5xl px-6 pb-24 pt-10 sm:pb-32 lg:flex lg:px-8 lg:py-24">
                <div class="mx-auto max-w-2xl flex-shrink-0 lg:mx-0 lg:max-w-xl lg:pt-8 text-center lg:text-left">
                    <h1 class="mt-6 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl animate-fadeInUp">
                        Laporkan Kerusakan <span class="text-primary">Infrastruktur</span> dengan Mudah
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300 animate-fadeInUp" style="animation-delay: 0.2s;">
                        Bersama kita wujudkan Bali yang lebih baik. Sampaikan laporan Anda mengenai jalan rusak, lampu penerangan, saluran air, dan fasilitas umum lainnya.
                    </p>

                    <div class="mt-10 flex items-center justify-center lg:justify-start gap-x-6" x-data> 
                        @auth
                            <a href="{{ route('laporan.bikinlapor') }}"
                                class="rounded-md bg-primary px-7 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary
                                    transition-colors duration-300 ease-in-out"> 
                                Buat Laporan Sekarang
                            </a>
                        @else
                            <button @click.prevent="$dispatch('open-login-modal')" 
                                class="rounded-md bg-primary px-7 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                                Buat Laporan Sekarang
                            </button>
                        @endguest

                        <a href="{{ route('laporan.index') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-200 hover:text-primary dark:hover:text-primary-light use-page-transition">
                            Lihat Daftar Laporan <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-16 sm:py-24 bg-white dark:bg-slate-800">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-primary">LaporIn Bali</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    Mengapa Melapor Melalui Kami?
                </p>
                <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">
                    Platform ini dirancang untuk memudahkan Anda berpartisipasi dalam perbaikan fasilitas publik.
                </p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900 dark:text-white">
                            <svg class="h-5 w-5 flex-none text-primary" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.5 17a4.5 4.5 0 01-1.44-8.765 4.5 4.5 0 018.302-3.046 3.5 3.5 0 014.504 4.272A4 4 0 0115 17H5.5zm3.75-2.75a.75.75 0 001.5 0V9.66l1.95 2.1a.75.75 0 101.1-1.02l-3.25-3.5a.75.75 0 00-1.1 0l-3.25 3.5a.75.75 0 101.1 1.02l1.95-2.1v4.59z" clip-rule="evenodd" /></svg>
                            Mudah & Cepat
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600 dark:text-gray-300">
                            <p class="flex-auto">Proses pelaporan yang sederhana, bisa dilakukan kapan saja dan di mana saja melalui website.</p>
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900 dark:text-white">
                            <svg class="h-5 w-5 flex-none text-primary" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" /></svg>
                            Terpantau & Transparan
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600 dark:text-gray-300">
                            <p class="flex-auto">Anda dapat melihat status tindak lanjut dari laporan yang Anda atau pengguna lain kirimkan.</p>
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900 dark:text-white">
                            <svg class="h-5 w-5 flex-none text-primary" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M4.632 3.533A2 2 0 016.577 2h6.846a2 2 0 011.945 1.533l1.976 8.234A3.489 3.489 0 0016 11.5H4c-.476 0-.93.095-1.344.267l1.976-8.234z" /><path fill-rule="evenodd" d="M4 13a2 2 0 100 4h12a2 2 0 100-4H4zm11.24 2a.75.75 0 01.75-.75H16a.75.75 0 010 1.5h-.01a.75.75 0 01-.75-.75z" clip-rule="evenodd" /></svg>
                            Berbasis Komunitas
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600 dark:text-gray-300">
                            <p class="flex-auto">Setiap laporan adalah kontribusi nyata untuk perbaikan fasilitas publik di Bali.</p>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <footer class="bg-gray-800 dark:bg-gray-900 text-gray-300 dark:text-gray-400">
        <div class="bg-primary text-white py-4 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                <div class="text-xl font-bold">
                    LaporIn Bali
                </div>

                <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-6">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        <span>(0361) XXX XXX</span> 
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        <span>info@laporinbali.go.id</span> 
                    </div>
                </div>

                <div class="flex space-x-4">
                    <a href="#" class="hover:text-gray-200" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                        </svg>
                    </a>
                    <a href="#" class="hover:text-gray-200" aria-label="Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-.422.724-.665 1.56-.665 2.452 0 1.735.883 3.267 2.215 4.175-.815-.026-1.587-.25-2.265-.64-.001.021-.001.042-.001.064 0 2.417 1.718 4.433 3.993 4.892-.419.114-.864.174-1.325.174-.32 0-.631-.03-.933-.086.635 1.975 2.477 3.421 4.657 3.461-1.705 1.339-3.851 2.135-6.191 2.135-.402 0-.799-.024-1.188-.07C2.362 21.001 4.283 21.883 6.387 21.883c7.602 0 11.963-6.501 11.68-12.289.81-.585 1.512-1.319 2.068-2.135z"/>
                        </svg>
                    </a>
                    <a href="#" class="hover:text-gray-200" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                           <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.85s-.012 3.584-.07 4.85c-.148 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.069-4.85.069s-3.584-.012-4.85-.07c-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.85s.012-3.584.07-4.85c.149-3.225 1.664-4.771 4.919-4.919C8.416 2.175 8.796 2.163 12 2.163m0-1.001C8.729 1.162 8.312 1.173 7.049 1.232c-3.602.166-5.803 2.363-5.969 5.969C1.023 8.312 1.012 8.729 1.012 12s.012 3.688.07 4.951c.166 3.601 2.362 5.803 5.969 5.969 1.262.059 1.679.07 4.951.07s3.688-.012 4.951-.07c3.601-.165 5.803-2.362 5.969-5.969.059-1.262.07-1.679.07-4.951s-.012-3.688-.07-4.951c-.165-3.601-2.362-5.803-5.969-5.969C15.688 1.173 15.271 1.162 12 1.162zM12 7.162a4.838 4.838 0 100 9.676 4.838 4.838 0 000-9.676zm0 8.001a3.162 3.162 0 110-6.324 3.162 3.162 0 010 6.324zM16.636 6.864a1.184 1.184 0 100-2.368 1.184 1.184 0 000 2.368z"/>
                        </svg>
                    </a>
                     <a href="#" class="hover:text-gray-200" aria-label="Youtube">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                           <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.737v-7.074l6.001 3.536-6.001 3.538z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 dark:bg-slate-900 py-8 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-sm font-semibold text-gray-200 dark:text-gray-300 tracking-wider uppercase">Tentang Kami</h3>
                    <ul role="list" class="mt-4 space-y-2">
                        <li><a href="#" class="text-base text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary-light">Hubungi Kami</a></li>
                        <li><a href="#" class="text-base text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary-light">Legal</a></li>
                        <li><a href="#" class="text-base text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary-light">Privasi</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-200 dark:text-gray-300 tracking-wider uppercase">Peta Situs</h3>
                    <ul role="list" class="mt-4 space-y-2">
                        <li><a href="{{ route('home') }}" class="text-base text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary-light">Home</a></li>
                        <li><a href="{{ route('laporan.index') }}" class="text-base text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary-light">Lihat Laporan</a></li>
                        @auth
                        <li><a href="{{ route('laporan.bikinlapor') }}" class="text-base text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary-light">Buat Laporan</a></li>
                        <li><a href="{{ route('dashboard') }}" class="text-base text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary-light">Dashboard</a></li>
                        @endauth
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-200 dark:text-gray-300 tracking-wider uppercase">Informasi</h3>
                    <ul role="list" class="mt-4 space-y-2">
                        <li><a href="#" class="text-base text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary-light">Panduan Pengguna</a></li>
                        <li><a href="#" class="text-base text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary-light">FAQ</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 border-t border-gray-700 dark:border-gray-600 pt-8 text-center">
                <p class="text-base text-gray-500 dark:text-gray-600">&copy; {{ date('Y') }} LaporIn Bali. All rights reserved.</p>
            </div>
        </div>
    </footer>
    {{-- AKHIR FOOTER --}}

    @guest
        @include('auth.partials.login-modal')
        @include('auth.partials.register-modal')
    @endguest

</x-app-layout>
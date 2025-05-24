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
                    <h1 class="mt-6 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">
                        Laporkan Kerusakan <span class="text-primary">Infrastruktur</span> dengan Mudah
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                        Bersama kita wujudkan Bali yang lebih baik. Sampaikan laporan Anda mengenai jalan rusak, lampu penerangan, saluran air, dan fasilitas umum lainnya.
                    </p>

                    <div class="mt-10 flex items-center justify-center lg:justify-start gap-x-6" x-data> 
                        @auth
                            <a href="{{ route('laporan.bikinlapor') }}"
                            class="rounded-md bg-primary px-7 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                                Buat Laporan Sekarang
                            </a>
                        @else
                            <button @click.prevent="$dispatch('open-login-modal')" 
                                class="rounded-md bg-primary px-7 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                                Buat Laporan Sekarang
                            </button>
                        @endguest

                        <a href="{{ route('laporan.index') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-200 hover:text-primary dark:hover:text-primary-light">
                            Lihat Daftar Laporan <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
                <div class="mx-auto mt-16 flex max-w-2xl sm:mt-24 lg:ml-10 lg:mr-0 lg:mt-0 lg:max-w-none lg:flex-none xl:ml-32">
                    <div class="max-w-3xl flex-none sm:max-w-5xl lg:max-w-none">
                        <img src="https://images.unsplash.com/photo-1525921429624-479b6a26d84d?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                             alt="Ilustrasi Pelaporan" width="2432" height="1442"
                             class="w-[76rem] rounded-md bg-white/5 shadow-2xl ring-1 ring-gray-900/10 dark:ring-white/10">
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

    @guest
        @include('auth.partials.login-modal')
        @include('auth.partials.register-modal')
    @endguest

</x-app-layout>
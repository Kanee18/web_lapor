<div
    x-data="{
        show: false,
        init() {
            @if($errors->hasBag('register'))
                this.show = true;
                console.log('Register errors detected, opening register modal.'); 
            @endif
            
            window.addEventListener('open-register-modal', () => { this.show = true });
        }
    }"
    x-show="show"
    x-on:keydown.escape.window="show = false"
    style="display: none;"
    class="fixed inset-0 z-[100] overflow-y-auto"
    aria-labelledby="modal-title-register"
    role="dialog"
    aria-modal="true"
>
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="show"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"
             @click="show = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="show"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-xl rounded-lg"
        >
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100" id="modal-title-register">
                    Buat Akun Baru
                </h3>
                 <button @click="show = false" class="text-gray-400 hover:text-gray-500">
                     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="mt-2">
                @if ($errors->hasBag('register'))
                    <div class="mb-4 p-4 bg-red-100 dark:bg-red-900/50 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 rounded">
                       Registrasi Gagal:
                       <ul class="mt-1 list-disc list-inside text-sm">
                            @foreach ($errors->register->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <label for="modal_register_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                        <input id="modal_register_name" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-700 dark:text-gray-200 @error('name', 'register') border-red-500 @enderror" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>

                    <div class="mt-4">
                        <label for="modal_register_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input id="modal_register_email" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-700 dark:text-gray-200 @error('email', 'register') border-red-500 @enderror" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    </div>

                    <div class="mt-4">
                         <label for="modal_register_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <input id="modal_register_password" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-700 dark:text-gray-200 @error('password', 'register') border-red-500 @enderror" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <label for="modal_register_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password</label>
                        <input id="modal_register_password_confirmation" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-700 dark:text-gray-200" type="password" name="password_confirmation" required autocomplete="new-password" />
                     </div>

                    <div class="flex items-center justify-between mt-6">
                         <a href="#" @click.prevent="show = false; $dispatch('open-login-modal')" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            Sudah punya akun? Login
                        </a>

                        <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-dark focus:bg-primary-dark active:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
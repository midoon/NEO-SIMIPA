<div class="bg-gradient-to-r from-simipa-3  to-simipa-4 w-full">

    {{-- notifikasi --}}
    @if (session()->has('success'))
        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 500);
        setTimeout(() => show = false, 10500)" x-show="show"
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
            class="fixed top-4 right-4 z-50 bg-green-500 text-white ml-4 px-4 py-2 rounded shadow flex items-center justify-between space-x-4">
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="text-white hover:text-gray-200 font-bold">
                &times;
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 500);
        setTimeout(() => show = false, 10500)" x-show="show"
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
            class="fixed top-4 right-4 z-50 bg-red-500 text-white ml-4 px-4 py-2 rounded shadow flex items-center justify-between space-x-4">
            <span>{{ session('error') }}</span>
            <button @click="show = false" class="text-white hover:text-gray-200 font-bold">
                &times;
            </button>
        </div>
    @endif

    <div class="w-full flex justify-center items-center min-h-screen px-8">
        <div class="w-full md:max-w-sm rounded-xl bg-simipa-5 p-10 ">
            {{-- @if (session('error'))
                <div id="error-login" class=" text-red-700 bg-red-200 p-4 rounded mb-4 flex justify-between items-center">
                    {{ session('error') }}
                    <button class="btn-error-any p-3" onclick="closeErrorBtn('error-login')">&#10006</button>
                </div>
            @endif --}}
            <h1 class="text-center text-3xl font-bold text-simipa-3">Registrasi Guru</h1>
            <form wire:submit.prevent="register" class="mt-10">

                <div class="mb-2">
                    <label for="nik" class="font-bold text-simipa-3">nik</label>
                    <input type="nik" name="nik" id="nik" placeholder="nik"
                        class=" border-1 rounded-md px-2 w-full focus:outline-none py-1.5  mt-2 focus:border-simipa-1  focus:ring-simipa-1 focus:ring-2"
                        required wire:model="nik">
                    @error('nik')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="password" class="font-bold text-simipa-3">Password</label>
                    <input type="password" name="password" id="password" placeholder="password"
                        class=" border-1 rounded-md px-2 w-full focus:outline-none py-1.5  mt-2 focus:border-simipa-1  focus:ring-simipa-1 focus:ring-2"
                        required wire:model="password">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-10">
                    <label for="confirm_password" class="font-bold text-simipa-3">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" id="confirm_password"
                        placeholder="konfirmasi password"
                        class=" border-1 rounded-md px-2 w-full focus:outline-none py-1.5  mt-2 focus:border-simipa-1  focus:ring-simipa-1 focus:ring-2"
                        required wire:model="confirm_password">
                    @error('confirm_password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-full text-center">
                    <button type="submit"
                        class="font-bold px-16 py-2 bg-simipa-1 text-white rounded-full lg:px-10 hover:cursor-pointer hover:bg-simipa-3">Register
                    </button>
                </div>
            </form>
            <div class="mt-10">
                <h3 class="text-simipa-3 font-medium text-center text-sm mb-2">Sudah mempunyai akun? login <a
                        href="/teacher/login" class="hover:underline text-simipa-1 font-bold" wire:navigate>disini</a>
                </h3>

                <h3
                    class=" text-simipa-2 text-center text-sm hover:underline hover:text-simipa-1 hover:text-shadow-simipa-1">
                    <a href="/admin/login" wire:navigate>Login
                        sebagai
                        Admin</a>
                </h3>

            </div>
        </div>
    </div>

</div>

<div>
    <h1 class="font-bold text-simipa-3 text-2xl mb-5">Pengaturan Admin</h1>

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


    <div class="border border-simipa-4 p-4  ">
        <form action="" class="">
            <div class="mb-4">
                <label for="username" class="block mb-2 font-medium text-simipa-3">Username</label>
                <input type="text" id="username" name="username"
                    class="p-2.5 text-sm text-simipa-2 bg-slate-100 rounded-sm border border-simipa-4 focus:ring-simipa-1 focus:border-simipa-1 w-full">
            </div>
            <div class="mb-4">
                <label for="password_old" class="block mb-2 font-medium text-simipa-3">Password Lama</label>
                <input type="password" id="password_old" name="password_old"
                    class="p-2.5 text-sm text-simipa-2 bg-slate-100 rounded-sm border border-simipa-4 focus:ring-simipa-1 focus:border-simipa-1 w-full">
            </div>
            <div class="mb-4">
                <label for="password" class="block mb-2 font-medium text-simipa-3">Password Baru</label>
                <input type="password" id="password" name="password"
                    class="p-2.5 text-sm text-simipa-2 bg-slate-100 rounded-sm border border-simipa-4 focus:ring-simipa-1 focus:border-simipa-1 w-full">
            </div>

            <div class="mb-8">
                <label for="password" class="block mb-2 font-medium text-simipa-3">Konfirmasi Password Baru</label>
                <input type="password" id="password" name="password"
                    class="p-2.5 text-sm text-simipa-2 bg-slate-100 rounded-sm border border-simipa-4 focus:ring-simipa-1 focus:border-simipa-1 w-full">
            </div>

            <div>
                <button class="py-2 px-4 rounded bg-simipa-3 text-simipa-5">Update Credential</button>
            </div>
        </form>
    </div>


</div>

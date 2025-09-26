<div class="mx-4">
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

    <div class="sm:max-w-[80vw]  min-h-[80vh] sm:mx-auto sm:flex sm:justify-center sm:items-center ">

        {{-- banner --}}
        <div
            class="flex  justify-center items-center mb-4 bg-simipa-2 p-4 min-h-[25vh] rounded-md sm:w-[30vw] sm:h-[60vh] sm:p-8 sm:mb-0">
            <img src="{{ asset($gender === 'perempuan' ? 'img/pr-icon.png' : 'img/lk-icon.png') }}" alt="Profile photo"
                class="w-32 h-32 rounded-full ring-4 ring-white object-cover" />



        </div>

        <form
            class="bg-white shadow-2xl rounded-lg w-full p-6 border border-slate-200
         sm:shadow-none sm:h-[60vh] sm:max-w-[30vw] sm:flex sm:flex-col">
            <div class="mb-4 border-b border-gray-200 pb-2">
                <label class="text-gray-500 text-sm block">Nama</label>
                <input wire:model="name" type="text" name="name"
                    class="w-full text-gray-800 text-base focus:outline-none">
            </div>
            <div class="mb-4 border-b border-gray-200 pb-2">
                <label class="text-gray-500 text-sm block">NIK</label>
                <input wire:model="nik" type="text" name="nik"
                    class="w-full text-gray-800 text-base focus:outline-none">
            </div>
            <div class="mb-4 border-b border-gray-200 pb-2">
                <label class="text-gray-500 text-sm block">Jenis Kelamin</label>
                <select wire:model="gender" id="gender" name="gender" class="w-full">
                    <option value="laki-laki">Laki-laki</option>
                    <option value="perempuan">Perempuan</option>
                </select>
            </div>

            <button wire:click.prevent="updateProfile"
                class="bg-simipa-3 text-white px-4 py-2 rounded hover:bg-simipa-1 hover:cursor-pointer sm:w-fit">
                Simpan Perubahan
            </button>

            <!-- tombol logout di bawah -->
            <div class="mt-10 border-gray-200 group w-fit py-1 hover:cursor-pointer sm:mt-auto">
                <button class="flex">
                    <svg class="w-6 h-6 text-red-300 transition-colors group-hover:text-simipa-3 group-hover:cursor-pointer"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 18V6h-5v12h5Zm0 0h2M4 18h2.5m3.5-5.5V12M6 6l7-2v16l-7-2V6Z" />
                    </svg>
                    <span class="text-red-400 transition-colors group-hover:text-simipa-3 group-hover:cursor-pointer">
                        Logout
                    </span>
                </button>
            </div>
        </form>





    </div>
</div>

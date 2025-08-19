<div class="mx-4">

    <div class="sm:max-w-[1200px] sm:mx-auto">
        <div class="mb-4 gird grid-cols-2 bg-simipa-2 p-4 h-[20vh] rounded-md sm:h-[30vh] sm:p-8">
            <div class="h-full flex flex-col justify-end gap-2">
                <p class="text-4xl font-sans text-simipa-5 mb-2 sm:text-6xl">{{ $todayDay }}</p>
                <p class="font-mono text-simipa-5 sm:text-2xl ">{{ $todayDate }}</p>
            </div>

            <div>
                {{-- isi apapun nanti --}}
            </div>

        </div>
        <p class="mb-2 font-medium text-simipa-3 sm:text-2xl">Daftar menu kehadiran siswa</p>
        <div class="grid grid-cols-2 gap-2 items-stretch sm:grid-cols-3 sm:gap-4">
            <div
                class="border-1 border-slate-200 flex flex-col justify-center items-center p-4 rounded-md gap-2 hover:cursor-pointer hover:bg-simipa-3 sm:py-10 sm:border-slate-300 group">
                <svg class="w-8 h-8 text-simipa-2 group-hover:text-simipa-5" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-3 5h3m-6 0h.01M12 16h3m-6 0h.01M10 3v4h4V3h-4Z" />
                </svg>
                <p class="font-medium text-simipa-2 text-center group-hover:text-simipa-5">Lihat Kehadiran</p>

            </div>

            <div wire:click="triggerFilterCreate"
                class="border-1 border-slate-200 flex flex-col justify-center items-center p-4 rounded-md gap-2 hover:cursor-pointer hover:bg-simipa-3 sm:py-10 sm:border-slate-300 group">
                <svg class="w-8 h-8 text-simipa-2 group-hover:text-simipa-5" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 5V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5M9 3v4a1 1 0 0 1-1 1H4m11.383.772 2.745 2.746m1.215-3.906a2.089 2.089 0 0 1 0 2.953l-6.65 6.646L9 17.95l.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z" />
                </svg>

                <p class="font-medium text-simipa-2 text-center group-hover:text-simipa-5">Catat Kehadiran</p>

            </div>

            <div
                class="border-1 border-slate-200 flex flex-col justify-center items-center p-4 rounded-md gap-2 hover:cursor-pointer hover:bg-simipa-3 sm:py-10 sm:border-slate-300 group">
                <svg class="w-8 h-8 text-simipa-2 group-hover:text-simipa-5" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                        d="M10 12v1h4v-1m4 7H6a1 1 0 0 1-1-1V9h14v9a1 1 0 0 1-1 1ZM4 5h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                </svg>


                <p class="font-medium text-simipa-2 text-center group-hover:text-simipa-5">Rekapitulasi Kehadiran</p>

            </div>

        </div>
    </div>

    <livewire:teacher.attendance.create-form-filter />
</div>

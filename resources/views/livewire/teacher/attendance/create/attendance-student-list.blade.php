<div class="mx-4">
    <div class="sm:max-w-[1200px] sm:mx-auto">
        <div class="mb-4  bg-simipa-2 p-4 min-h-[20vh] rounded-md sm:min-h-[30vh] sm:p-8">
            <div class="flex  justify-between items-center gap-2 mb-5 sm:items-start">
                <div>
                    <p class="text-lg font-sans text-simipa-5  sm:text-4xl">{{ $group }}</p>
                    <p class="font-mono text-simipa-5 text-sm sm:text-lg">
                        {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</p>
                </div>
                <div class="">
                    <button wire:click="save"
                        class="bg-simipa-1 text-white px-4 py-2 rounded-md sm:px-8  hover:bg-simipa-3">
                        Simpan
                    </button>
                </div>
            </div>

            {{-- progress presensi --}}
            <div class="flex
                    justify-around mb-5 sm:justify-center sm:gap-20">
                <div>
                    <p class="text-white text-xs font-extralight sm:font-medium sm:text-lg">Total</p>
                    <p class="text-white text-2xl sm:font-bold sm:text-4xl">{{ $cStudent }}</p>
                </div>

                <div>
                    <p class="text-white text-xs font-extralight sm:font-medium sm:text-lg">Hadir</p>
                    <p class="text-white text-2xl sm:font-bold sm:text-4xl">{{ $cHadir }}</p>
                </div>

                <div>
                    <p class="text-white text-xs font-extralight sm:font-medium sm:text-lg">Sakit</p>
                    <p class="text-white text-2xl sm:font-bold sm:text-4xl">{{ $cSakit }}</p>
                </div>

                <div>
                    <p class="text-white text-xs font-extralight sm:font-medium sm:text-lg">Izin</p>
                    <p class="text-white text-2xl sm:font-bold sm:text-4xl">{{ $cIzin }}</p>
                </div>

                <div>
                    <p class="text-white text-xs font-extralight sm:font-medium sm:text-lg">Alpha</p>
                    <p class="text-white text-2xl sm:font-bold sm:text-4xl">{{ $cAlpha }}</p>
                </div>

            </div>

            <div class="flex justify-between items-center">
                <p class="text-simipa-5 sm:font-medium sm:text-xl">Kehadiran:</p>
                <p class="text-simipa-5 sm:font-medium sm:text-xl">{{ $activity }}</p>
            </div>

        </div>
        <div class="mb-[15vh] ">
            @foreach ($students as $s)
                <div class="flex justify-between items-center mb-3 border-2 border-slate-400 p-2 rounded-md">
                    <div>
                        <p class="font-medium text-simipa-2">{{ $s->name }}</p>
                        <p class="text-xs font-light">NISN: {{ $s->nisn }}</p>
                    </div>

                    <div>
                        <select wire:model.live="statuses.{{ $s->id }}"
                            class="form-control status p-2 rounded-lg border border-simipa-1 text-simipa-1">
                            <option value="hadir">Hadir</option>
                            <option value="alpha">Alpha</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                        </select>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


</div>

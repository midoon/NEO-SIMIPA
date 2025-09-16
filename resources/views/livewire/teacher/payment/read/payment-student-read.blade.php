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

    <div class="sm:max-w-[1200px] sm:mx-auto">

        {{-- banner --}}
        <div class="flex flex-col justify-between mb-4 bg-simipa-2 p-4 min-h-[20vh] rounded-md sm:min-h-[30vh] sm:p-8">
            <div class="flex  justify-between items-center gap-2 mb-5 sm:items-start">
                <div>
                    <p class="text-2xl font-sans text-simipa-5  sm:text-4xl">{{ $group->name }}</p>
                    <p class="text-sm font-sans text-simipa-5  sm:text-4xl">Lihat {{ $paymentType->name }}</p>

                </div>
                <div class="">


                </div>
            </div>



            <div class="flex gap-2 items-center justify-between">
                <p class="text-simipa-5 sm:font-medium sm:text-xl">
                    Nominal Pembayaran: </p>
                <p class="text-simipa-5 sm:font-medium sm:text-xl">Rp
                    {{ number_format($gradeFee->amount, 0, ',', '.') }}
                </p>

            </div>

        </div>


        <div class="mb-[15vh] ">
            @foreach ($students as $s)
                <div class="flex justify-between items-center mb-3 border-2 border-slate-400 p-2 rounded-md">
                    <div>
                        <p class="font-medium text-sm text-simipa-2 sm:text-md">{{ $s->name }}</p>
                        <p class="text-xs font-light">NISN: {{ $s->nisn }}</p>
                    </div>

                    <div>
                        <button wire:click="detailPayment({{ $s->id }})"
                            class="px-3 py-1 rounded-lg bg-simipa-1 text-simipa-5 hover:bg-simipa-2 sm:px-6 sm:py-2">Lihat</button>
                    </div>
                </div>
            @endforeach
        </div>


    </div>



</div>

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
                    <p class="text-lg font-sans text-simipa-5  sm:text-4xl">{{ $student->name }}</p>
                    <p class="text-sm font-sans text-simipa-5  sm:text-2xl">Tipe Pembayaran: {{ $paymentType->name }}
                    </p>

                </div>
                <div class="">


                </div>
            </div>



            <div class="flex gap-2 items-center justify-between">
                <p class="text-simipa-5 sm:font-medium sm:text-xl">
                    Tagihan: Rp. {{ number_format($fee->amount - $fee->paid_amount, 0, ',', '.') }}</p>
                @if ($isPaidFull)
                    @if ($isBendahara)
                        <div wire:click="downloadReceipt"
                            class="text-simipa-4 bg-simipa-1 px-4 py-2 rounded-lg hover:cursor-pointer hover:bg-slate-500">
                            <span class="hidden md:inline">Download </span>Kuwitansi
                        </div>
                    @endif

                @endif

            </div>

        </div>


        <div class="mb-[15vh] ">
            @foreach ($payments as $p)
                <div class="flex justify-between items-center mb-3 border-2 border-slate-400 px-4 py-3 rounded-md">
                    <div class="max-w-[80%]">
                        <p class="font-bold text-xl text-simipa-2 sm:text-md">
                            Rp. {{ number_format($p->amount, 0, ',', '.') }}</p>
                        <p class="text-xs font-light ">
                            {{ $p->description }} pada tanggal
                            <span class="">
                                {{ \Carbon\Carbon::parse($p->payment_date)->format('d-m-Y') }}
                            </span>
                        </p>
                    </div>




                    @if ($isBendahara)
                        <div class="border p-2 rounded hover:border-red-400 group"
                            wire:click="deleteConnfirmation({{ $p->id }})">
                            <button class="group-hover:cursor-pointer">
                                <svg class="w-6 h-6 text-simipa-3 group-hover:text-red-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>


    </div>



    <livewire:teacher.payment.delete.delete-confirmation-form />
</div>

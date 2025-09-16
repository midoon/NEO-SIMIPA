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
                    <p class="text-sm font-sans text-simipa-5  sm:text-4xl">Tipe Pembayaran: {{ $paymentType->name }}
                    </p>

                </div>
                <div class="">


                </div>
            </div>



            <div class="flex gap-2 items-center justify-between">
                <p class="text-simipa-5 sm:font-medium sm:text-xl">
                    Tagihan: Rp. {{ number_format($fee->amount - $fee->paid_amount, 0, ',', '.') }}</p>
                <div class="text-simipa-4 bg-simipa-1 px-4 py-2 rounded-lg">
                    Kuwitansi
                </div>

            </div>

        </div>


        <div class="mb-[15vh] ">
            @foreach ($payments as $p)
                <div class="flex justify-between items-center mb-3 border-2 border-slate-400 px-4 py-3 rounded-md">
                    <div class="max-w-[50%]">
                        <p class="font-medium text-xl text-simipa-2 sm:text-md">
                            Rp. {{ number_format($p->amount, 0, ',', '.') }}</p>
                        <p class="text-xs font-light"> {{ $p->description }} pada tanggal {{ $p->payment_date }}</p>
                    </div>




                    <div x-data="{ open: false }" class="relative inline-block text-left">
                        <button @click="open = !open"
                            class="px-4 py-2 rounded-md bg-simipa-1 text-simipa-5 hover:bg-simipa-2 sm:px-6 sm:py-2">
                            Opsi
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-10">
                            <ul class="py-1">
                                <li>
                                    <button wire:click="detailPayment({{ $p->id }})"
                                        class="block px-4 py-4 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                                        Hapus
                                    </button>
                                </li>
                                <li>
                                    <button wire:click="editPayment({{ $p->id }})"
                                        class="block px-4 py-4 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                                        Edit
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>




</div>

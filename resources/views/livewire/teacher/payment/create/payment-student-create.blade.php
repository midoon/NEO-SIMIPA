<div class="mx-4">
    <div>

        {{-- banner --}}
        <div class="flex flex-col justify-between mb-4 bg-simipa-2 p-4 min-h-[20vh] rounded-md sm:min-h-[30vh] sm:p-8">
            <div class="flex  justify-between items-center gap-2 mb-5 sm:items-start">
                <div>
                    <p class="text-2xl font-sans text-simipa-5  sm:text-4xl">{{ $group->name }}</p>
                    <p class="text-sm font-sans text-simipa-5  sm:text-4xl">{{ $paymentType->name }}</p>

                </div>
                <div class="">


                </div>
            </div>



            <div class="flex gap-2 items-center justify-between">
                <p class="text-simipa-5 sm:font-medium sm:text-xl">
                    Nominal Pembayaran: </p>
                <p class="text-simipa-5 sm:font-medium sm:text-xl">Rp {{ number_format($gradeFee->amount, 0, ',', '.') }}
                </p>

            </div>

        </div>


        <div class="mb-[15vh] ">
            @foreach ($students as $s)
                <div class="flex justify-between items-center mb-3 border-2 border-slate-400 p-2 rounded-md">
                    <div>
                        <p class="font-medium text-sm text-simipa-2">{{ $s->name }}</p>
                        <p class="text-xs font-light">NISN: {{ $s->nisn }}</p>
                    </div>

                    <div>
                        <button wire:click="showModalPayment({{ $s->id }})"
                            class="px-3 py-1 rounded-lg bg-simipa-1 text-simipa-5 hover:bg-simipa-2 ">Bayar</button>
                    </div>
                </div>
            @endforeach
        </div>


    </div>
</div>

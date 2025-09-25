<div class="mx-4">
    <div class="sm:max-w-[1200px] sm:mx-auto">
        {{-- banner --}}
        <div class="flex flex-col justify-between mb-4 bg-simipa-2 p-4 min-h-[20vh] rounded-md sm:min-h-[30vh] sm:p-8">
            <div class="flex  justify-between items-center gap-2 mb-5 sm:items-start">
                <div>
                    <p class="text-2xl font-sans text-simipa-5  sm:text-4xl">{{ $group->name }}</p>
                    <p class="text-md font-sans text-simipa-5  sm:text-4xl">{{ $paymentType->name }}</p>

                </div>
                <div class="">

                    <button wire:click="reportDownload"
                        class="bg-simipa-1 text-white px-4 py-2 rounded-md sm:px-8  hover:bg-simipa-3">
                        Download
                    </button>
                </div>
            </div>



            <div class="flex flex-col gap-1 items-start justify-between ">
                <p class="text-simipa-5 sm:font-medium sm:text-xl">
                    Total Tagihan: {{ $totalAmount }}</p>
                <p class="text-simipa-5 sm:font-medium sm:text-xl">
                    Total Terbayar: {{ $totalPaid }}</p>
            </div>

        </div>


        {{-- list --}}
        <div class="relative overflow-x-auto rounded-md mb-[15vh]">
            <table class="w-full text-sm text-left rtl:text-right">
                <thead class="">
                    <tr class="text-white bg-simipa-2 border">

                        <th class="border p-2">Nisn</th>
                        <th class="border p-2">Nama</th>
                        <th class="border p-2">Tagihan</th>
                        <th class="border p-2">Terbayar</th>
                        <th class="border p-2">Status</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($studentFees as $sf)
                        <tr class="bg-simipa-6 border">

                            <td class="px-2 py-1 border">{{ $sf->student_nisn }}</td>
                            <td class="px-2 py-1 border">{{ $sf->student_name }}</td>
                            <td class="px-2 py-1 border">{{ $sf->amount }}</td>
                            <td class="px-2 py-1 border">{{ $sf->paid_amount }}</td>
                            <td class="px-2 py-1 border">{{ $sf->status }}</td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

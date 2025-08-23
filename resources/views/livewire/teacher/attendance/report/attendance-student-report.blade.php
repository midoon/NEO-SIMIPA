<div class="mx-4">
    <div class="sm:max-w-[1200px] sm:mx-auto">
        {{-- banner --}}
        <div class="flex flex-col justify-between mb-4 bg-simipa-2 p-4 min-h-[20vh] rounded-md sm:min-h-[30vh] sm:p-8">
            <div class="flex  justify-between items-center gap-2 mb-5 sm:items-start">
                <div>
                    <p class="text-2xl font-sans text-simipa-5  sm:text-4xl">{{ $group }}</p>
                    <p class="text-md font-sans text-simipa-5  sm:text-4xl">{{ $activity }}</p>

                </div>
                <div class="">

                    <button wire:click="reportDownload"
                        class="bg-simipa-1 text-white px-4 py-2 rounded-md sm:px-8  hover:bg-simipa-3">
                        Download
                    </button>
                </div>
            </div>



            <div class="flex gap-2 items-center justify-between">
                <p class="text-simipa-5 sm:font-medium sm:text-xl">
                    {{ \Carbon\Carbon::parse($dateStart)->format('d-m-Y') }}</p>
                <p class="text-simipa-5 sm:font-medium sm:text-xl">
                    {{ \Carbon\Carbon::parse($dateEnd)->format('d-m-Y') }}</p>
            </div>

        </div>


        {{-- list --}}
        <div class="relative overflow-x-auto rounded-md mb-[15vh]">
            <table class="w-full text-sm text-left rtl:text-right">
                <thead class="">
                    <tr class="text-white bg-simipa-2 border">

                        <th class="border p-2">Nama</th>
                        <th class="border p-2">Hadir</th>
                        <th class="border p-2">Alpha</th>
                        <th class="border p-2">Izin</th>
                        <th class="border p-2">Sakit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $student_id => $data)
                        <tr class="bg-simipa-6 border">

                            <td class="px-2 py-1 border">{{ $data['name'] }}</td>
                            <td class="px-2 py-1 border">{{ $data['hadir'] }}</td>
                            <td class="px-2 py-1 border">{{ $data['sakit'] }}</td>
                            <td class="px-2 py-1 border">{{ $data['izin'] }}</td>
                            <td class="px-2 py-1 border">{{ $data['alpha'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

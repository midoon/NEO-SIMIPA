<div class="mx-4">


    <div class="sm:max-w-[1200px] sm:mx-auto">
        <div class="flex justify-between items-center px-4 border-2 rounded-2xl border-simipa-2 mb-5 sm:px-16 sm:py8">
            <div class="">
                <h1 class="font-bold text-2xl text-simipa-1 sm:text-4xl">Selamat Datang!</h1>
                <p class="font-medium sm:text-2xl">{{ session('teacher')['name'] }}</p>
            </div>

            <img src="{{ asset('img/book-asset.PNG') }}" alt="logo.png" class="w-40 sm:w-60">
        </div>

        <h1 class="font-bold text-simipa-3 mb-5 sm:text-2xl">Jadwal Hari {{ \Carbon\Carbon::now()->isoFormat('dddd') }}
        </h1>

        <div class="mb-24">
            @if ($schedules->isEmpty())
                <p class="text-simipa-2">Tidak ada jadwal untuk hari ini.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($schedules as $schedule)
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center gap-2">
                                <p class="font-medium text-simipa-2">{{ $schedule->start_time }}</p>
                                <div class="w-[2px] h-full bg-simipa-2"></div>
                                <p class="font-medium text-simipa-2">{{ $schedule->end_time }}</p>
                            </div>
                            <div
                                class="bg-simipa-2 p-4 rounded-lg shadow-md w-full flex flex-col justify-between gap-4">
                                <h2 class="font-bold text-lg text-simipa-4 ">{{ $schedule->subject->name }}</h2>

                                <p class="text-simipa-4">Ruang: {{ $schedule->group->name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>


</div>

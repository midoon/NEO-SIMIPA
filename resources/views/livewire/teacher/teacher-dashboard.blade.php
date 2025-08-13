<div class="mx-4">
    <div class="flex justify-between items-center py-4 ">
        <a href="#">
            <img src="{{ asset('img/logo-1.PNG') }}" alt="logo.png" class="w-24">
        </a>

        <a href="#" class=" p-1 ">
            <svg class="w-10 h-10 text-simipa-2 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>

        </a>
    </div>

    <div class="flex justify-between items-center px-4 border-2 rounded-2xl border-simipa-2 mb-5">
        <div class="">
            <h1 class="font-bold text-2xl text-simipa-1">Selamat Datang!</h1>
            <p class="font-medium">{{ session('teacher')['name'] }}</p>
        </div>

        <img src="{{ asset('img/book-asset.PNG') }}" alt="logo.png" class="w-40">
    </div>

    <h1 class="font-bold text-simipa-3 mb-5">Jadwal Hari {{ \Carbon\Carbon::now()->isoFormat('dddd') }}</h1>

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
                        <div class="bg-simipa-2 p-4 rounded-lg shadow-md w-full">
                            <h2 class="font-bold text-lg text-simipa-4 mb-4">{{ $schedule->subject->name }}</h2>

                            <p class="text-simipa-4">Ruang: {{ $schedule->group->name }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

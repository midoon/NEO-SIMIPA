<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <title>{{ $title ?? 'SIMIPA' }}</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="mx-4">
        <div class="flex justify-between items-center py-4 sm:max-w-[1200px] sm:mx-auto">
            <a href="#">
                <img src="{{ asset('img/logo-1.PNG') }}" alt="logo.png" class="w-24 sm:w-36">
            </a>

            <nav
                class="hidden  sm:flex justify-around items-center w-full max-w-[600px] h-16 bg-white rounded-2xl  border border-gray-200">

                <a wire:navigate href="/teacher/dashboard"
                    class="flex-1 flex flex-col items-center justify-center p-2 hover:bg-simipa-4"><svg
                        class="w-6 h-6 text-simipa-2 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
                    </svg>

                    <p class="text-simipa-2 font-bold">
                        Beranda
                    </p>
                </a>
                <a wire:navigate href="/teacher/schedule"
                    class="flex-1 flex flex-col items-center justify-center h-full  p-2 hover:bg-simipa-4"><svg
                        class="w-6 h-6 text-simipa-2 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                    </svg>

                    <p class="text-simipa-2 font-bold">
                        Jadwal
                    </p>

                </a>
                <a wire:navigate href="#"
                    class="flex-1 flex flex-col items-center justify-center h-full  p-2 hover:bg-simipa-4"><svg
                        class="w-6 h-6 text-simipa-2 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M7 2a2 2 0 0 0-2 2v1a1 1 0 0 0 0 2v1a1 1 0 0 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H7Zm3 8a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm-1 7a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3 1 1 0 0 1-1 1h-6a1 1 0 0 1-1-1Z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-simipa-2 font-bold">
                        Kehadiran
                    </p>

                </a>
                <a wire:navigate href="#"
                    class="flex-1 flex flex-col items-center justify-center p-2 hover:bg-simipa-4"><svg
                        class="w-6 h-6 text-simipa-2 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>

                    <p class="text-simipa-2 font-bold">
                        Pembayaran
                    </p>
                </a>

            </nav>

            <a href="#" class=" p-1 hover:bg-simipa-4 rounded-full">
                <svg class="w-10 h-10 sm:w-14 sm:h-14 text-simipa-2 " aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>

            </a>
        </div>
    </div>

    {{ $slot }}

    {{-- navbar --}}
    <div class="sm:hidden">
        <nav
            class="fixed bottom-4 left-1/2 -translate-x-1/2 w-[90%] max-w-md h-16 bg-white rounded-2xl shadow-lg border border-gray-200 flex justify-around items-center">

            <a wire:navigate href="/teacher/dashboard"
                class="flex-1 flex flex-col items-center justify-center p-2 hover:bg-simipa-4"><svg
                    class="w-6 h-6 text-simipa-2 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
                </svg>

                <p class="text-simipa-2 font-bold">
                    Beranda
                </p>
            </a>
            <a wire:navigate href="/teacher/schedule"
                class="flex-1 flex flex-col items-center justify-center h-full  p-2 hover:bg-simipa-4"><svg
                    class="w-6 h-6 text-simipa-2 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                </svg>

                <p class="text-simipa-2 font-bold">
                    Jadwal
                </p>

            </a>
            <a wire:navigate href="#"
                class="flex-1 flex flex-col items-center justify-center h-full  p-2 hover:bg-simipa-4"><svg
                    class="w-6 h-6 text-simipa-2 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M7 2a2 2 0 0 0-2 2v1a1 1 0 0 0 0 2v1a1 1 0 0 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H7Zm3 8a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm-1 7a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3 1 1 0 0 1-1 1h-6a1 1 0 0 1-1-1Z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-simipa-2 font-bold">
                    Kehadiran
                </p>

            </a>
            <a wire:navigate href="#"
                class="flex-1 flex flex-col items-center justify-center p-2 hover:bg-simipa-4"><svg
                    class="w-6 h-6 text-simipa-2 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                </svg>

                <p class="text-simipa-2 font-bold">
                    Pembayaran
                </p>
            </a>

        </nav>
    </div>
</body>

</html>

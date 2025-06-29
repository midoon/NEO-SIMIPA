<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <title>{{ $title ?? 'SIMIPA || Admin' }}</title>
</head>

<body>
    <div class=" flex min-h-screen">
        <aside class="bg-simipa-6 w-64 text-gray-100 flex-shrink-0 fixed inset-y-0 overflow-y-auto bg-simipa-5">


            <nav class=" flex flex-col justify-between h-dvh">

                <div>
                    <a wire:navigate href="/admin/dashboard"
                        class="py-3 mb-10 flex gap-2 justify-start px-5 items-cente hover:cursor-pointer">
                        <img src="{{ asset('img/logo-1.PNG') }}" alt="logo.png" width="130">

                    </a>
                    <a wire:navigate href="/admin/teacher"
                        class="text-simipa-3 font-semibold transition-colors hover:text-simipa-5 block py-3 px-4 rounded-lg hover:bg-simipa-2 group">
                        <div class="flex ml-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 text-simipa-3 transition-colors group-hover:text-simipa-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>

                            <p class="ml-2">Guru</p>
                        </div>
                    </a>


                    {{-- StudentShip --}}
                    <div x-data="{ studentShip: false }">
                        <button @click="studentShip = !studentShip"
                            class="w-full text-left text-simipa-3 font-semibold transition-colors hover:cursor-pointer hover:text-simipa-5 py-3 px-4 rounded-lg hover:bg-simipa-2 flex items-center justify-between group">
                            <div class="flex ml-1 items-center">
                                <svg class="w-6 h-6 text-simipa-3 transition-colors group-hover:text-simipa-1"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                        d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                                </svg>
                                <span class="ml-2">Kesiswaan</span>
                            </div>
                            <svg :class="{ 'rotate-90': studentShip }" class="w-4 h-4 transform transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div x-show="studentShip" x-transition class="ml-10 mt-1 space-y-1">
                            <a wire:navigate href="/admin/grade"
                                class="block py-2 px-4 text-sm text-simipa-3 hover:bg-simipa-2 hover:text-white rounded">Kelas</a>
                            <a wire:navigate href="/admin/group"
                                class="block py-2 px-4 text-sm text-simipa-3 hover:bg-simipa-2 hover:text-white rounded">Rombongan
                                Belajar</a>
                            <a wire:navigate href="/admin/student"
                                class="block py-2 px-4 text-sm text-simipa-3 hover:bg-simipa-2 hover:text-white rounded">Siswa</a>
                        </div>
                    </div>


                    {{-- academyc --}}
                    <div x-data="{ openAcademyc: false }">
                        <button @click="openAcademyc = !openAcademyc"
                            class="w-full text-left text-simipa-3 font-semibold transition-colors hover:cursor-pointer hover:text-simipa-5 py-3 px-4 rounded-lg hover:bg-simipa-2 flex items-center justify-between group">
                            <div class="flex ml-1 items-center">
                                <svg class="w-6 h-6 text-simipa-3 transition-colors group-hover:text-simipa-1"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 19V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v13H7a2 2 0 0 0-2 2Zm0 0a2 2 0 0 0 2 2h12M9 3v14m7 0v4" />
                                </svg>
                                <span class="ml-2">Akademik</span>
                            </div>
                            <svg :class="{ 'rotate-90': openAcademyc }" class="w-4 h-4 transform transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div x-show="openAcademyc" x-transition class="ml-10 mt-1 space-y-1">
                            <a wire:navigate href="/admin/subject"
                                class="block py-2 px-4 text-sm text-simipa-3 hover:bg-simipa-2 hover:text-white rounded">Mata
                                Pelajaran</a>
                            <a wire:navigate href="/admin/schedule"
                                class="block py-2 px-4 text-sm text-simipa-3 hover:bg-simipa-2 hover:text-white rounded">Jadwal
                                Pelajaran</a>
                            <a wire:navigate href="/admin/activity"
                                class="block py-2 px-4 text-sm text-simipa-3 hover:bg-simipa-2 hover:text-white rounded">Kegiatan</a>
                        </div>
                    </div>

                    {{-- payment --}}
                    <div x-data="{ openPayment: false }">
                        <button @click="openPayment = !openPayment"
                            class="w-full text-left text-simipa-3 font-semibold transition-colors hover:cursor-pointer hover:text-simipa-5 py-3 px-4 rounded-lg hover:bg-simipa-2 flex items-center justify-between group">
                            <div class="flex ml-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6 text-simipa-3 transition-colors group-hover:text-simipa-1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                </svg>
                                <span class="ml-2">Payment</span>
                            </div>
                            <svg :class="{ 'rotate-90': openPayment }" class="w-4 h-4 transform transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div x-show="openPayment" x-transition class="ml-10 mt-1 space-y-1">
                            <a wire:navigate href="/admin/payment/type"
                                class="block py-2 px-4 text-sm text-simipa-3 hover:bg-simipa-2 hover:text-white rounded">Tipe
                                Pembayaran</a>
                            <a wire:navigate href="/admin/payment/fee"
                                class="block py-2 px-4 text-sm text-simipa-3 hover:bg-simipa-2 hover:text-white rounded">Tagihan
                                Kelas</a>
                        </div>
                    </div>
                </div>



                {{-- nav bawah --}}
                <div>
                    <a href="/admin/teacher"
                        class="text-simipa-3 font-semibold transition-colors hover:text-simipa-5 block py-3 px-4 rounded-lg hover:bg-simipa-2 group">
                        <div class="flex ml-1">

                            <svg class="w-6 h-6 text-simipa-3 transition-colors group-hover:text-simipa-1"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z" />
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>


                            <p class="ml-2">Setting</p>
                        </div>
                    </a>

                    <form action="/admin/logout" method="POST" class="mb-5">
                        @csrf
                        <button type="submit"
                            class="w-full text-left text-simipa-3 font-semibold transition-colors hover:text-simipa-5 py-3 px-4 rounded-lg hover:bg-simipa-2 hover:cursor-pointer group">
                            <div class="flex ml-1 items-center">
                                <svg class="w-6 h-6 text-simipa-3 transition-colors group-hover:text-simipa-1"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M18 18V6h-5v12h5Zm0 0h2M4 18h2.5m3.5-5.5V12M6 6l7-2v16l-7-2V6Z" />
                                </svg>
                                <span class="ml-2">Logout</span>
                            </div>
                        </button>
                    </form>
                </div>



            </nav>


        </aside>

        {{-- main --}}
        <div class="flex-1 ml-64">
            <main class="p-8  min-h-screen">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>

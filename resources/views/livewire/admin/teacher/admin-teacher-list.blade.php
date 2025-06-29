<div>
    <h1 class="font-bold text-simipa-3 text-2xl mb-5">Daftar Guru</h1>




    <div class="relative overflow-x-auto border border-simipa-4">

        <div class="p-4 flex items-center justify-between gap-4">
            <input type="text"
                class="block w-1/3 p-2.5 text-sm text-simipa-2 bg-simipa-5 rounded-sm border border-simipa-4 focus:ring-simipa-1 focus:border-simipa-1"
                placeholder="Cari berdasarkan nama atau NIK" wire:model.live.debounce.300ms="search">

            <div class="flex items-center gap-4">
                <button
                    class="px-4 py-2 border border-simipa-2 rounded-sm hover:cursor-pointer hover:border-simipa-1 hover:text-simipa-1">Upload</button>
                <button
                    class="px-4 py-2 border border-simipa-2 rounded-sm hover:cursor-pointer hover:border-simipa-1 hover:text-simipa-1">Create</button>
            </div>
        </div>

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 border ">
            <thead class="text-xs text-simipa-2 uppercase bg-gray-50 ">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nik
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jenis Kelamin
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Peran
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status Akun
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teachers as $teacher)
                    <tr class="bg-white ">
                        <td class="px-6 py-4 text-simipa-2">
                            {{ $teacher->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $teacher->nik }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $teacher->gender }}
                        </td>
                        <td class="px-6 py-4">
                            {{ implode(', ', $teacher->role) }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($teacher->account == 1)
                                <span class="px-2 py-1 text-xs text-simipa-1 bg-green-200 rounded-full">
                                    Terdaftar
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs text-red-600 bg-red-200 rounded-md">
                                    Tidak Terdaftar
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 flex items-center gap-1">
                            <a href="/a" class="hover:cursor-pointer">
                                <svg class="w-6 h-6 text-simipa-3 hover:text-amber-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </a>
                            <a href="/b" class="hover:cursor-pointer">
                                <svg class="w-6 h-6 text-simipa-3 hover:text-red-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                </svg>
                            </a>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
    <div class="mt-4">
        {{ $teachers->links() }}
    </div>


</div>

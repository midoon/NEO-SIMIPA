<div>
    <h1 class="font-bold text-simipa-3 text-2xl mb-5">Daftar Tipe Pembayaran</h1>

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


    {{-- tabel --}}
    <div class="relative overflow-x-auto border border-simipa-4">

        <div class="p-4 flex items-center justify-between gap-4">
            <input type="text"
                class="block w-1/3 p-2.5 text-sm text-simipa-2 bg-simipa-5 rounded-sm border border-simipa-4 focus:ring-simipa-1 focus:border-simipa-1"
                placeholder="Cari berdasarkan nama " wire:model.live.debounce.300ms="search">

            <div class="flex items-center gap-4">
                <button wire:click="triggerModalUpload"
                    class="px-4 py-2 border border-simipa-2 rounded-sm hover:cursor-pointer hover:border-simipa-1 hover:text-simipa-1">Upload</button>
                <button wire:click="triggerModalCreate"
                    class="px-4 py-2 border border-simipa-2 rounded-sm hover:border-simipa-1 hover:text-simipa-1 hover:cursor-pointer">
                    Create
                </button>
                <button wire:click="triggerModalDeleteMultiple"
                    class="px-4 py-2 border border-simipa-2 rounded-sm hover:border-red-500 hover:text-red-500 hover:cursor-pointer">Delete
                    Selected</button>
            </div>
        </div>

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 border ">
            <thead class="text-xs text-simipa-2 uppercase bg-gray-50 ">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <input type="checkbox" wire:model.live="selectAll">
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tipe Pembayaran
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Deskripsi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paymentTypes as $pt)
                    <tr class="bg-white ">
                        <td class="px-6 py-4">
                            <input type="checkbox" wire:key="{{ $pt->id }}" wire:model.live="selected"
                                value="{{ $pt->id }}">
                        </td>
                        <td class="px-6 py-4 text-simipa-2">
                            {{ $pt->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $pt->description }}
                        </td>
                        <td class="px-6 py-4 flex items-center gap-1">
                            <button wire:click="triggerModalEdit({{ $pt->id }})" class="hover:cursor-pointer">
                                <svg class="w-6 h-6 text-simipa-3 hover:text-amber-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </button>
                            <button wire:click="triggerModalDelete({{ $pt->id }})" class="hover:cursor-pointer">
                                <svg class="w-6 h-6 text-simipa-3 hover:text-red-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                </svg>
                            </button>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
    <div class="mt-4">
        {{ $paymentTypes->links() }}
    </div>

    <livewire:admin.payment-type.admin-payment-type-create />
    <livewire:admin.payment-type.admin-payment-type-delete />
    <livewire:admin.payment-type.admin-payment-type-edit />

    {{--


    <livewire:admin.activity.admin-activity-delete-multiple />
    <livewire:admin.activity.admin-activity-upload /> --}}








</div>

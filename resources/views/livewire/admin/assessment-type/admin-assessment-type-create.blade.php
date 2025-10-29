<div>
    @if ($showModal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center">
            <div class="bg-white rounded-md w-1/3 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Tambah Data Tipe Penilaian</h2>

                <form wire:submit.prevent="store">
                    <div class="mb-3">
                        <div class="w-full ">
                            <label for="name" class="block font-semibold mb-1">Nama penilaian</label>
                            <input type="text" wire:model="name" id="name" placeholder="UTS" required
                                class="w-full border py-1.5 px-3 rounded-sm focus:border-simipa-1 focus:ring-1 focus:ring-simipa-1 focus:outline-none">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-5">
                        <div class="w-full ">
                            <label for="code" class="block font-semibold mb-1">Kode penilaian</label>
                            <input type="text" wire:model="code" id="code" placeholder="UTS-2025" required
                                class="w-full border py-1.5 px-3 rounded-sm focus:border-simipa-1 focus:ring-1 focus:ring-simipa-1 focus:outline-none"></input>
                            @error('code')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>



                    <!-- Tombol Aksi -->
                    <div class="flex justify-end">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 mr-2 hover:cursor-pointer">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-simipa-1 text-white rounded hover:bg-simipa-2 hover:cursor-pointer">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

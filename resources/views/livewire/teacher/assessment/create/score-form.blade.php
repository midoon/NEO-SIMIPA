<div class="">
    @if ($showModal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center px-4 z-50">
            <div class="bg-white rounded-md w-full p-6 sm:w-1/3">

                <form wire:submit.prevent="create">
                    <div class="mb-3">
                        <label for="score" class="block font-semibold mb-1">Nilai Siswa</label>
                        <input type="text" id="score" wire:model="score"
                            class="border w-full rounded-sm px-2 py-1.5" placeholder="Masukkan nilai siswa" required>
                        @error('score')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 mr-2 hover:cursor-pointer">Batal</button>
                        <button type="button" wire:click="save"
                            class="px-4 py-2 bg-simipa-1 text-white rounded hover:bg-simipa-2 hover:cursor-pointer">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

<div>
    @if ($showModal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center">
            <div class="bg-white rounded-md mx-4 sm:w-1/3 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Konfirmasi update data diri</h2>
                <p>Apakah Anda yakin ingin memperbarui data diri anda?</p>

                <div class="flex justify-end mt-4">
                    <button wire:click="closeModal"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 mr-2 hover:cursor-pointer">Batal</button>
                    <button wire:click="updateProfile"
                        class="px-4 py-2 bg-simipa-1 text-white rounded hover:bg-simipa-3 hover:cursor-pointer">Update</button>
                </div>
            </div>
        </div>
    @endif
</div>

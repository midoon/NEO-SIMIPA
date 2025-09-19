<div>
    @if ($showModal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-99">
            <div class="bg-white rounded-md  p-6 md:w-1/3">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Hapus Data Pembayaran</h2>
                <p>Apakah Anda yakin ingin menghapus data pembayaran tersebut?</p>

                <div class="flex justify-end mt-4">
                    <button wire:click="cancel"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 mr-2 hover:cursor-pointer">Batal</button>
                    <button wire:click="delete"
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 hover:cursor-pointer">Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>

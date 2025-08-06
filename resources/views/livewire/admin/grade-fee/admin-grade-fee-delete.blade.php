<div>
    @if ($showModal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center">
            <div class="bg-white rounded-md w-1/3 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Hapus Data Tagihan Pembayaran</h2>
                <p>Apakah Anda yakin ingin menghapus data tagihan ini?</p>

                <div class="flex justify-end mt-4">
                    <button wire:click="$set('showModal', false)"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 mr-2 hover:cursor-pointer">Batal</button>
                    <button wire:click="delete"
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 hover:cursor-pointer">Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>

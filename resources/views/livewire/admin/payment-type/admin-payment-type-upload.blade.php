<div>

    @if ($showModal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center">
            <div class="bg-white rounded-md w-1/3 p-6">
                <h2 class="text-xl font-semibold text-simipa-2 mb-4">Upload Data Tipe Pembayaran</h2>

                <form action="/admin/payment/type/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="mb-5 ">
                        <label for="file" class="block text-simipa-3 font-medium mb-2">Pilih file CSV</label>
                        <input type="file" wire:model="file" name="file" id="file" required
                            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-simipa-1 mb-5">
                        <div wire:click="downloadTemplate" class="text-simipa-1 hover:cursor-pointer hover:underline">
                            Download Template</div>
                    </div>



                    <!-- Tombol Aksi -->
                    <div class="flex justify-end">
                        <button type="button" wire:click="batalUpload"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 hover:cursor-pointer mr-2">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-simipa-1 text-white rounded hover:bg-simipa-2 hover:cursor-pointer">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

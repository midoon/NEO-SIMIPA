<div>
    @if ($showModal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center">
            <div class="bg-white rounded-md w-1/3 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Tagihan Pembayaran</h2>

                <form wire:submit.prevent="update">

                    <div class="mb-3">
                        <label for="paymentTypeId" class="block font-semibold mb-1">Tipe Pembayaran</label>
                        <select wire:model="paymentTypeId" id="paymentTypeId" class="border w-full rounded-sm px-2 py-1.5"
                            required>
                            <option value="" selected>Pilih Tipe Pembayaran</option>
                            @foreach ($paymentTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('paymentTypeId')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="block font-semibold mb-1">Jumlah Tagihan</label>
                        <input type="number" id="amount" name="amount" class="border w-full rounded-sm px-2 py-1.5"
                            required wire:model="amount">
                        @error('amount')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-7">
                        <label for="dueDate" class="block font-semibold mb-1">Tenggat Waktu</label>
                        <input type="date" id="dueDate" name="dueDate" class="border w-full rounded-sm px-2 py-1.5"
                            required wire:model="dueDate">
                        @error('dueDate')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
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

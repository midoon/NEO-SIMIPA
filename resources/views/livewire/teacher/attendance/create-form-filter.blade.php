<div class="">
    @if ($showModal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center px-4">
            <div class="bg-white rounded-md w-full p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Tambah Daftar Kehadiran</h2>

                <form wire:submit.prevent="create">
                    <div class="mb-3">
                        <label for="groupId" class="block font-semibold mb-1">Rombongan Belajar</label>
                        <select wire:model="groupId" id="groupId" class="border w-full rounded-sm px-2 py-1.5" required>
                            <option value="" selected>Pilih Rombel</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        @error('groupId')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="activityId" class="block font-semibold mb-1">Tipe Kegiatan</label>
                        <select wire:model="activityId" id="activityId" class="border w-full rounded-sm px-2 py-1.5"
                            required>
                            <option value="" selected>Pilih Kegiatan</option>
                            @foreach ($activities as $activity)
                                <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                            @endforeach
                        </select>
                        @error('activityId')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-7">
                        <label for="date" class="block font-semibold mb-1">Tenggat Waktu</label>
                        <input type="date" id="date" name="date" class="border w-full rounded-sm px-2 py-1.5"
                            required wire:model="date">
                        @error('date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 mr-2 hover:cursor-pointer">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-simipa-1 text-white rounded hover:bg-simipa-2 hover:cursor-pointer">Buat</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

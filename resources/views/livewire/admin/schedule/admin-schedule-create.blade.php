<div>
    @if ($showModal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center">
            <div class="bg-white rounded-md w-1/3 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Tambah Jadwal Pelajaran</h2>

                <form wire:submit.prevent="store">
                    <div class="mb-3">
                        <label for="day" class="block font-semibold mb-1">Hari</label>
                        <select wire:model="day" id="day" class="border w-full rounded-sm px-2 py-1.5" required>
                            <option value="" selected>Pilih Hari</option>
                            <option value="senin">Senin</option>
                            <option value="selasa">Selasa</option>
                            <option value="rabu">Rabu</option>
                            <option value="kamis">Kamis</option>
                            <option value="jumat">Jumat</option>
                            <option value="sabtu">Sabtu</option>
                            <option value="minggu">Minggu</option>
                        </select>
                        @error('day')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="groupId" class="block font-semibold mb-1">Rombongan Belajar</label>
                        <select wire:model="groupId" id="groupId" class="border w-full rounded-sm px-2 py-1.5"
                            required>
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
                        <label for="teacherId" class="block font-semibold mb-1">Daftar Guru</label>
                        <select wire:model="teacherId" id="teacherId" class="border w-full rounded-sm px-2 py-1.5"
                            required>
                            <option value="" selected>Pilih Guru</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                        @error('teacherId')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="subjectId" class="block font-semibold mb-1">Mata Pelajaran</label>
                        <select wire:model="subjectId" id="subjectId" class="border w-full rounded-sm px-2 py-1.5"
                            required>
                            <option value="" selected>Pilih Mapel</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        @error('subjectId')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-7 ">
                        <div class="w-full flex gap-4">
                            <div class="flex-1">
                                <label for="startTime" class="block font-semibold mb-1">Waktu Mulai</label>
                                <input type="time" id="startTime" name="startTime"
                                    class="border w-full rounded-lg px-2 py-1.5" required wire:model="startTime">
                            </div>
                            <div class="flex-1">
                                <label for="endTime" class="block font-semibold mb-1">Waktu Selesai</label>
                                <input type="time" id="endTime" name="endTime"
                                    class="border w-full rounded-lg px-2 py-1.5" required wire:model="endTime">
                            </div>
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

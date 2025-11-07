<div class="">
    @if ($showModal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center px-4 z-50">
            <div class="bg-white rounded-md w-full p-6 sm:w-1/3">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Lihat Daftar Pnelinaian</h2>

                <form wire:submit.prevent="read">
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
                        <label for="assessmentTypeId" class="block font-semibold mb-1">Tipe Penilaian</label>
                        <select wire:model="assessmentTypeId" id="assessmentTypeId"
                            class="border w-full rounded-sm px-2 py-1.5" required>
                            <option value="" selected>Pilih Penilaian</option>
                            @foreach ($assessmentTypes as $assessmentType)
                                <option value="{{ $assessmentType->id }}">{{ $assessmentType->name }} :
                                    {{ $assessmentType->code }}</option>
                            @endforeach
                        </select>
                        @error('assessmentTypeId')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-7">
                        <label for="subjectId" class="block font-semibold mb-1">Mata Pelajaran</label>
                        <select wire:model="subjectId" id="subjectId" class="border w-full rounded-sm px-2 py-1.5"
                            required>
                            <option value="" selected>Pilih Penilaian</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }} :
                                    {{ $subject->code }}</option>
                            @endforeach
                        </select>
                        @error('subjectId')
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

<div>
    <!-- Button to open modal -->
    <button wire:click="createModalTeacher"
        class="px-4 py-2 border border-simipa-2 rounded-sm hover:border-simipa-1 hover:text-simipa-1 ">
        Create
    </button>

    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center">
            <div class="bg-white rounded-md w-1/3 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Tambah Data Guru</h2>

                <form wire:submit.prevent="store">
                    <div class="mb-3">
                        <div class="flex-1 space-y-2 md:flex md:items-center md:space-x-3 md:space-y-0">
                            <div class="w-full md:w-1/2">
                                <label for="name" class="block font-semibold mb-1">Nama</label>
                                <input type="text" wire:model="name" id="name" placeholder="John Doe" required
                                    class="w-full border py-1.5 px-3 rounded-sm focus:border-simipa-1 focus:ring-1 focus:ring-simipa-1 focus:outline-none">
                                @error('name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full md:w-1/2">
                                <label for="nik" class="block font-semibold mb-1">NIK</label>
                                <input type="text" wire:model="nik" id="nik" placeholder="123456**" required
                                    class="w-full border py-1.5 px-3 rounded-sm focus:border-simipa-1 focus:ring-1 focus:ring-simipa-1 focus:outline-none">
                                @error('nik')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="block font-semibold mb-1">Gender</label>
                        <select wire:model="gender" id="gender" class="border w-full rounded-sm px-2 py-1.5"
                            required>
                            <option selected disabled>Pilih Gender</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                        @error('gender')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-7">
                        <label class="block font-semibold mb-1">Role</label>
                        <div class="flex items-center space-x-5 border p-3 rounded-sm">
                            <div>
                                <label for="guru">
                                    <input type="checkbox" id="guru" value="guru" wire:model="roles"
                                        class="mr-2 capitalize">Guru
                                </label>
                            </div>
                            <div>
                                <label for="bendahara">
                                    <input type="checkbox" id="bendahara" value="bendahara" wire:model="roles"
                                        class="mr-2 capitalize">Bendahara
                                </label>
                            </div>
                        </div>
                        @error('roles')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 mr-2">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-simipa-1 text-white rounded hover:bg-simipa-2">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

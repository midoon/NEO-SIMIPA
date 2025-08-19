<div class="mx-4">

    @foreach ($students as $s)
        <div class="flex justify-between items-center mb-2">
            <div>
                <p>{{ $s->name }}</p>
                <p>{{ $s->nisn }}</p>
            </div>

            <div>
                <select wire:model.live="statuses.{{ $s->id }}" class="form-control status p-2 rounded-lg border">
                    <option value="hadir">Hadir</option>
                    <option value="alpha">Alpha</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                </select>
            </div>
        </div>
    @endforeach

    <div class="mt-4 mb-20">
        <button wire:click="save" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Simpan Presensi
        </button>
    </div>
</div>

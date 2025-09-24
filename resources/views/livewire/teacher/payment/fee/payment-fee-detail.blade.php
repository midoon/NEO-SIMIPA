<div class="mx-4">
    {{-- notifikasi --}}
    @if (session()->has('success'))
        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 500);
        setTimeout(() => show = false, 10500)" x-show="show"
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
            class="fixed top-4 right-4 z-50 bg-green-500 text-white ml-4 px-4 py-2 rounded shadow flex items-center justify-between space-x-4">
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="text-white hover:text-gray-200 font-bold">
                &times;
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 500);
        setTimeout(() => show = false, 10500)" x-show="show"
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
            class="fixed top-4 right-4 z-50 bg-red-500 text-white ml-4 px-4 py-2 rounded shadow flex items-center justify-between space-x-4">
            <span>{{ session('error') }}</span>
            <button @click="show = false" class="text-white hover:text-gray-200 font-bold">
                &times;
            </button>
        </div>
    @endif


    <div class="sm:max-w-[1200px] sm:mx-auto">

        {{-- banner --}}
        <div class="flex flex-col justify-end mb-4 bg-simipa-2 p-4 min-h-[20vh] rounded-md sm:min-h-[30vh] sm:p-8">
            <p class="text-2xl font-sans text-simipa-5  sm:text-4xl">{{ $student->name }}</p>
            <p class="text-sm font-sans text-simipa-5  sm:text-4xl">Lihat Daftar Tagihan Pembayaran</p>


        </div>


        <div class="mb-[15vh] ">
            @foreach ($fees as $f)
                <div
                    class="flex justify-between items-center mb-3 border-2 border-slate-400 p-2 rounded-md sm:px-10 sm:py-4">
                    <div>
                        <p class="font-medium text-md mb-2 text-simipa-2 sm:text-xl">{{ $f->paymentType->name }}</p>
                        <p class="text-xs font-light sm:text-md">Total Nominal: {{ $f->amount }}</p>
                        <p class="text-xs font-light sm:text-md">Sisa Tagihan: {{ $f->amount - $f->paid_amount }}</p>
                        <p class="text-xs font-light sm:text-md">Tenggat Waktu: {{ $f->due_date }}</p>
                    </div>

                    <div
                        class="px-4 py-4 rounded-lg sm:px-6 sm:py-4 border
    {{ $f->status === 'paid' ? 'border-green-500 text-green-500' : '' }}
    {{ $f->status === 'partial' ? 'border-yellow-500 text-yellow-500' : '' }}
    {{ $f->status === 'unpaid' ? 'border-red-500 text-red-500' : '' }}">
                        {{ ucfirst($f->status) }}
                    </div>
                </div>
            @endforeach
        </div>


    </div>
</div>

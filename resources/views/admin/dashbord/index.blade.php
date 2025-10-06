<x-layout_admin>
    <x-slot:judul>{{ $judul }}</x-slot:judul>
    <div class="bg-white rounded-xl shadow-md p-6 text-gray-800 space-y-3 mb-5">
        <h4 class="text-2xl font-semibold">Halo, {{ auth('admin')->user()->name }} 👋</h4>

        <p>
            Selamat datang di <span class="font-semibold text-blue-600">Aplikasi Sistem Crisis Center</span>.
            Aplikasi ini dirancang untuk memudahkan masyarakat dalam menyampaikan laporan atau pengaduan terkait situasi
            krisis secara cepat dan terkoordinasi.
        </p>
        <p>
            Hak akses Anda: <span class="font-semibold text-green-500">{{ auth('admin')->user()->role }}</span>
        </p>
        <hr class="my-2 border-gray-300">

        <p class="italic text-sm text-gray-600">
            Setiap laporan berarti <span class="font-bold text-red-600">nyawa dan keselamatan.</span> Crisis Center hadir
            untuk Anda.
        </p>


    </div>

    @livewire('control-panel')
    
    <x-sweet-alert />

</x-layout_admin>

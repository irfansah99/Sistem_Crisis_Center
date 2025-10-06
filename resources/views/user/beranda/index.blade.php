<x-layout>
    <x-slot:judul>{{ $judul }}</x-slot:judul>

    <div class="bg-white rounded-xl shadow-md p-6 text-gray-800 space-y-3 mb-5">
        <h4 class="text-2xl font-semibold">Halo, {{ auth()->user()->name }} 👋</h4>

        <p>
            Selamat datang di <span class="font-semibold text-blue-600">Aplikasi Sistem Crisis Center</span>. 
            Aplikasi ini dirancang untuk memudahkan masyarakat dalam menyampaikan laporan atau pengaduan terkait situasi krisis secara cepat dan terkoordinasi.
        </p>
        
        <hr class="my-2 border-gray-300">

        <p class="italic text-sm text-gray-600">
            Setiap laporan berarti <span class="font-bold text-red-600">nyawa dan keselamatan.</span> Crisis Center hadir untuk Anda.
        </p>
        
        
    </div>
    <div class="flex justify-end mb-4">
        <a href="{{ route('beranda.create') }}">
            <button type="button"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md shadow">
                Kirim Laporan
            </button>
        </a>
    </div>
   
    @livewire('reportlist-user')
    <x-sweet-alert />
</x-layout>

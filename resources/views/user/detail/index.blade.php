<x-layout>
    <x-slot:judul>{{ $judul }}</x-slot:judul>

    <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6 space-y-2">
        <ul class="divide-y divide-gray-200">
            <li class="py-2">Judul: {{ $index->judul }}</li>
            <li class="py-2">Deskripsi: {{ $index->deskripsi }}</li>
            <li class="py-2">Kategori: {{ $index->kategori }}</li>
            <li class="py-2 ">Level Krisis: 
                @if ($index->level_krisis === "rendah")
                <span class="bg-blue-600 text-slate-800 rounded  px-1">{{ $index->level_krisis }}</span>
                @elseif ($index->level_krisis === "sedang")
                <span class="bg-blue-400 text-slate-800 rounded  px-1">{{ $index->level_krisis }}</span>
                @elseif ($index->level_krisis === "tinggi")
                <span class="bg-red-400 text-slate-800 rounded  px-1">{{ $index->level_krisis }}</span>
                @elseif ($index->level_krisis === "darurat")
                <span class="bg-red-700 text-slate-800 rounded  px-1">{{ $index->level_krisis }}</span>
                @else
                <span class="bg-yellow-300 rounded  px-1 text-slate-800">Belum Ditentukan</span>
                @endif
            </li>
            <li class="py-2">Lokasi: {{ $index->lokasi }}</li>
            <li class="py-2">
                Bukti:
                @if($index->foto)
                    <img src="{{ asset('storage/' . $index->foto) }}" alt="Bukti" class="mt-2 w-48 rounded">
                @else
                    <span class="text-gray-500">Tidak ada bukti</span>
                @endif
            </li>
            <li class="py-2">Catatan Admin: {{ $index->catatan_admin }}</li>
            <li class="py-2">Status: 
                <span class="px-2 py-1 rounded 
                    {{ $index->status == 'disetujui' ? 'bg-green-100 text-green-700' : 
                       ($index->status == 'ditolak' ? 'bg-red-100 text-red-700' : 
                       'bg-yellow-100 text-yellow-700') }}">
                    {{ ucfirst($index->status) }}
                </span>
            </li>
            <li class="py-2">Terakhir Diubah: {{ $index->updated_at->format('d M Y H:i') }}</li>
            <li class="py-2">Dibuat Pada: {{ $index->created_at->format('d M Y H:i') }}</li>
        </ul>
    </div>
    <a href="{{ url()->previous() }}">
        <button class="px-4 py-2 bg-gray-700 text-white rounded">Back</button>
    </a>
    
    <x-sweet-alert />
</x-layout>

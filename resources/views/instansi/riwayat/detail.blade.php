<x-layout_instansi>
    <x-slot:judul>{{ $judul }}</x-slot:judul>
    <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6 space-y-2">
        <ul class="divide-y divide-gray-200">
            <li class="py-2">Deskripsi: {{ $detail->report->deskripsi }}</li>
            <li class="py-2">Kategori: {{ $detail->report->kategori }}</li>
            <li class="py-2 ">Level Krisis: 
                @if ($detail->report->level_krisis === "rendah")
                <span class="bg-blue-600 text-slate-800 rounded  px-1">{{ $detail->report->level_krisis }}</span>
                @elseif ($detail->report->level_krisis === "sedang")
                <span class="bg-blue-400 text-slate-800 rounded  px-1">{{ $detail->report->level_krisis }}</span>
                @elseif ($detail->report->level_krisis === "tinggi")
                <span class="bg-red-400 text-slate-800 rounded  px-1">{{ $detail->report->level_krisis }}</span>
                @elseif ($detail->report->level_krisis === "darurat")
                <span class="bg-red-700 text-slate-800 rounded  px-1">{{ $detail->report->level_krisis }}</span>
                @else
                <span class="bg-yellow-300 rounded  px-1 text-slate-800">Belum Ditentukan</span>
                @endif
            </li>
            <li class="py-2">Lokasi: {{ $detail->report->lokasi }}</li>
            
            <li class="py-2">Catatan Instansi: {{ $detail->catatan_intansi }}</li>
            <li class="py-2">Status: 
                    {{ $detail->status }}
            </li>
            <li class="py-2">Terakhir Diubah: {{ $detail->updated_at->format('d M Y H:i') }}</li>
        </ul>
    </div>
    <a href="{{ route('instansi.histories.index') }}">
        <button class="px-4 py-2 bg-gray-700 text-white rounded">Back</button>
    </a>

        <x-sweet-alert />
</x-layout_instansi>

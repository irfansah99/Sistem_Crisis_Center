<x-layout_instansi>
    <x-slot:judul>{{ $judul }}</x-slot:judul>
    <div class="w-full max-w-3xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden">

        <div class="px-6 py-4 text-gray-700 space-y-4">
    
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="flex flex-col gap-3">
                    <p><span class="font-semibold">Pelapor:</span> {{ $detail->report->user->name }}</p>
                    <p><span class="font-semibold">Kategori:</span> {{ $detail->report->kategori }}</p>
                    <p>
                        <span class="font-semibold">Lokasi:</span>
                        <a href="{{ $detail->report->lokasi }}" target="_blank" class="text-blue-500 hover:underline">
                            Buka Maps
                        </a>
                    </p>
                </div>
    
                <div class="flex flex-col gap-3 text-sm">
                    <p>
                        <span class="font-semibold">Level Krisis:</span>
                        @if ($detail->report->level_krisis === 'rendah')
                            <span class="bg-green-500 text-white rounded px-2 py-1">Rendah</span>
                        @elseif ($detail->report->level_krisis === 'sedang')
                            <span class="bg-yellow-400 text-white rounded px-2 py-1">Sedang</span>
                        @elseif ($detail->report->level_krisis === 'tinggi')
                            <span class="bg-red-500 text-white rounded px-2 py-1">Tinggi</span>
                        @elseif ($detail->report->level_krisis === 'darurat')
                            <span class="bg-black text-white rounded px-2 py-1">Darurat</span>
                        @else
                            <span class="bg-yellow-300 text-white rounded px-2 py-1">Belum Ditentukan</span>
                        @endif
                    </p>
    
                    <p>
                        <span class="font-semibold">Status:</span>
                        <span class="px-2 py-1 rounded text-sm bg-green-500 text-white">
                            Selesai
                        </span>
                    </p>
                </div>
            </div>
    
            <div>
                <h3 class="font-semibold text-gray-800 mb-1">Deskripsi Kejadian</h3>
                <p class="bg-gray-50 border rounded-lg p-3 text-sm text-justify max-h-72 overflow-y-auto">
                    {{ $detail->report->deskripsi }}
                </p>
            </div>
    
            <div>
                <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                    Instansi yang Dikerahkan
                </h3>
                <ul class="ml-5 list-disc">
                    @foreach ($instansi_terkait as $item)
                        <li>{{ $item->nama_instansi }}</li>
                    @endforeach
                </ul>
            </div>
    
            <div>
                <h3 class="font-semibold text-gray-800 mb-1">Catatan Instansi</h3>
                <p class="bg-gray-50 border rounded-lg p-3 text-sm text-justify max-h-72 overflow-y-auto">
                    {{ $detail->catatan_intansi ?? 'Belum ada catatan' }}
                </p>
            </div>
    
            <div class="text-sm text-gray-500">
                <p>Dibuat: {{ $detail->created_at->format('d M Y H:i') }}</p>
                <p>Terakhir diubah: {{ $detail->updated_at->format('d M Y H:i') }}</p>
            </div>
    
        </div>
    
        <div class="px-6 py-3 border-t bg-gray-50 flex justify-start">
            <a href="{{ route('admin.histories.index') }}" wire:navigate>
                <button class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg transition">
                    Kembali
                </button>
            </a>
        </div>
    
    </div>
    


    <x-sweet-alert />
</x-layout_instansi>

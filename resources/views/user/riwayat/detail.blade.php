<x-layout>
    <x-slot:judul>{{ $judul }}</x-slot:judul>

    <div class="max-w-3xl w-full mx-auto bg-white shadow-lg rounded-lg p-6 space-y-4 ">
        <ul class="divide-y divide-gray-200 flex flex-col gap-4">
            <li class="py-2 flex flex-col sm:flex-row sm:items-start gap-2">
                <span class="font-semibold w-40">Deskripsi</span>
                <div class="overflow-y-auto break-words whitespace-normal max-h-64 lg:max-w-[500px] text-justify">
                    {{ $index->deskripsi }}
                </div>

            </li>
            <li class="py-2 flex flex-col sm:flex-row sm:items-center gap-2">
                <span class="font-semibold w-40">Kategori:</span>
                <span>{{ $index->kategori }}</span>
            </li>
            <li class="py-2 flex flex-col sm:flex-row sm:items-center gap-2">
                <span class="font-semibold w-40">Level Krisis</span>
                @if ($index->level_krisis === 'rendah')
                    <span class="bg-green-500 text-white rounded px-2">{{ $index->level_krisis }}</span>
                @elseif ($index->level_krisis === 'sedang')
                    <span class="bg-yellow-400 text-white rounded px-2">{{ $index->level_krisis }}</span>
                @elseif ($index->level_krisis === 'tinggi')
                    <span class="bg-red-500 text-white rounded px-2">{{ $index->level_krisis }}</span>
                @elseif ($index->level_krisis === 'darurat')
                    <span class="bg-black text-white rounded px-2">{{ $index->level_krisis }}</span>
                @else
                    <span class="bg-yellow-300 text-white rounded px-2">Belum Ditentukan</span>
                @endif
            </li>
            <li class="py-2 flex flex-col sm:flex-row sm:items-start gap-2">
                <span class="font-semibold w-40">Instansi yang dikerahkan</span>
                <ul class=list-decimal space-y-1">
                    @if ($instansi_terkait && count($instansi_terkait) > 0)
                        @foreach ($instansi_terkait as $item)
                            <li class="ml-5">{{ $item->nama_instansi }}</li>
                        @endforeach
                    @else
                        <span class="text-gray-500 italic">Belum ada instansi terkait</span>
                    @endif
                </ul>
            </li>
            </li>
            <li class="py-2 flex flex-col sm:flex-row sm:items-center gap-2">
                <span class="font-semibold w-40">Lokasi</span>
                <a href="{{ $index->lokasi }}" target="_blank" class="text-blue-500 hover:underline">Lihat
                    Lokasi</a href="">
            </li>

            <li class="py-2 flex flex-col sm:flex-row sm:items-start gap-2">
                <span class="font-semibold w-40">Bukti</span>
                @if ($index->foto)
                    <img src="{{ asset('storage/' . $index->foto) }}" alt="Bukti" class="mt-2 w-48 rounded">
                @else
                    <span class="text-gray-500">Tidak ada bukti</span>
                @endif
            </li>

            <li class="py-2 flex flex-col sm:flex-row sm:items-start gap-2">
                <span class="font-semibold w-40">Catatan Admin</span>
                <div class="overflow-auto max-h-64">
                    {{ $index->catatan_admin ?? 'Belum ada catatan' }}
                </div>
            </li>

            <li class="py-2 flex flex-col sm:flex-row sm:items-center gap-2">
                <span class="font-semibold w-40">Status</span>
                <span class="bg-green-500 py-1 rounded text-white px-2">Selesai</span>


            </li>

            <li class="py-2
                flex flex-col sm:flex-row sm:items-center gap-2">
                <span class="font-semibold w-40">Terakhir Diubah:</span>
                <span>{{ $index->updated_at->format('d M Y H:i') }}</span>
            </li>

            <li class="py-2 flex flex-col sm:flex-row sm:items-center gap-2">
                <span class="font-semibold w-40">Dibuat Pada:</span>
                <span>{{ $index->created_at->format('d M Y H:i') }}</span>
            </li>
        </ul>

        <div class="mt-4 flex justify-start">
            <a href="{{ route('riwayat.index') }}">
                <button class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                    Back</button>
            </a>

        </div>
    </div>

    <x-sweet-alert />
</x-layout>

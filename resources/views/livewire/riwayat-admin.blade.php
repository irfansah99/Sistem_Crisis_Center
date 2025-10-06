<div>
    <table class="min-w-full border-2 border-gray-300 rounded-lg shadow-sm text-sm text-left table-auto mt-20">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border-2">No</th>
                <th class="px-4 py-2 border-2">Pelapor</th>
                <th class="px-4 py-2 border-2">Judul</th>
                <th class="px-4 py-2 border-2">Deskripsi</th>
                <th class="px-4 py-2 border-2">Kategori</th>
                <th class="px-4 py-2 border-2">Terakhir diubah</th>
                <th class="px-4 py-2 border-2">Status</th>
                <th class="px-4 py-2 border-2">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($reports as $row)
                <tr>
                    <td class="px-4 py-2 border-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border-2">{{ $row->user->name }}</td>
                    <td class="px-4 py-2 border-2">{{ $row->judul }}</td>
                    <td class="px-4 py-2 border-2">{{ $row->deskripsi }}</td>
                    <td class="px-4 py-2 border-2">{{ $row->kategori }}</td>
                    <td class="px-4 py-2 border-2">{{ $row->updated_at->diffForHumans() }}</td>
                    <td class="px-4 py-2 border-2">{{ $row->status }}</td>
                    <td class="px-4 py-2 border-2 text-center">
                        <button class="px-2 py-1 bg-yellow-500 hover:bg-yellow-700 text-white rounded"
                            wire:click="OpenModal({{ $row->id }})">
                            Detail
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-gray-500">Tidak ada laporan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if ($detail)
        <div class=" fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6 space-y-2">
                <ul class="divide-y divide-gray-200">
                    <li class="py-2">Pelaport: {{ $detail->user->name }}</li>
                    <li class="py-2">Judul: {{ $detail->judul }}</li>
                    <li class="py-2">Deskripsi: {{ $detail->deskripsi }}</li>
                    <li class="py-2">Kategori: {{ $detail->kategori }}</li>
                    <h3 class="text-lg font-semibold mt-4">Instansi Terkait</h3>
                    @if ($instansi_terkait->isNotEmpty())
                        <table class="w-full border mt-2">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-2 py-1">No</th>
                                    <th class="border px-2 py-1">Nama Instansi</th>
                                    <th class="border px-2 py-1">Status</th>
                                    <th class="border px-2 py-1">Catatan</th>
                                    <th class="border px-2 py-1">Teerakhir Diubah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($instansi_terkait as $i => $item)
                                    <tr>
                                        <td class="border px-2 py-1">{{ $i + 1 }}</td>
                                        <td class="border px-2 py-1">{{ $item->instansi->nama_instansi }}</td>
                                        <td class="border px-2 py-1">{{ $item->status }}</td>
                                        <td class="border px-2 py-1">{{ $item->catatan_intansi }}</td>
                                        <td class="border px-2 py-1">{{ $item->updated_at->format('d M Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500">Belum ada instansi terkait.</p>
                    @endif


                    <li class="py-2 ">Level Krisis:
                        @if ($detail->level_krisis === 'rendah')
                            <span class="bg-blue-600 text-slate-300 rounded  px-1">{{ $detail->level_krisis }}</span>
                        @elseif ($detail->level_krisis === 'sedang')
                            <span class="bg-blue-400 text-slate-300 rounded  px-1">{{ $detail->level_krisis }}</span>
                        @elseif ($detail->level_krisis === 'tinggi')
                            <span class="bg-red-400 text-slate-300 rounded  px-1">{{ $detail->level_krisis }}</span>
                        @elseif ($detail->level_krisis === 'darurat')
                            <span class="bg-red-700 text-slate-300 rounded  px-1">{{ $detail->level_krisis }}</span>
                        @else
                            <span class="bg-yellow-300 rounded  px-1 text-slate-800">Belum Ditentukan</span>
                        @endif
                    </li>
                    <li class="py-2">Lokasi: {{ $detail->lokasi }}</li>
                    <li class="py-2">
                        Bukti:
                        @if ($detail->foto)
                            <img src="{{ asset('storage/' . $detail->foto) }}" alt="Bukti"
                                class="mt-2 w-48 rounded">
                        @else
                            <span class="text-gray-500">Tidak ada bukti</span>
                        @endif
                    </li>
                    <li class="py-2">Catatan Admin: {{ $detail->catatan_admin }}</li>
                    <li class="py-2">Status:
                        <span
                            class="px-2 py-1 rounded 
                            {{ $detail->status == 'disetujui'
                                ? 'bg-green-100 text-green-700'
                                : ($detail->status == 'ditolak'
                                    ? 'bg-red-100 text-red-700'
                                    : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($detail->status) }}
                        </span>
                    </li>
                    <li class="py-2">Terakhir Diubah: {{ $detail->updated_at->format('d M Y H:i') }}</li>
                    <li class="py-2">Dibuat Pada: {{ $detail->created_at->format('d M Y H:i') }}</li>
                </ul>
                <div class="mt-5 flex justify-center gap-2"> 
                        <button class="px-4 py-2 bg-gray-700 text-white rounded" wire:click="CloseModal">Back</button>
                </div>
            </div>

    @endif
</div>

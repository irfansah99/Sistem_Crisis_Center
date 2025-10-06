<div class="overflow-x-auto mt-20">
    <table class="min-w-full border-2 border-gray-300 rounded-lg shadow-sm text-sm text-left table-auto">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border-2">No</th>
                <th class="px-4 py-2 border-2">Deskripsi</th>
                <th class="px-4 py-2 border-2">Level Krisis</th>
                <th class="px-4 py-2 border-2">Terakhir Diubah</th>
                <th class="px-4 py-2 border-2">Status</th>
                <th class="px-4 py-2 border-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($reports as $row)
                <tr wire:key="report-{{ $row->id }}">
                    <td class="px-4 py-2 border-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border-2">
                        {{ Str::limit($row->report->deskripsi, 50) }}
                    </td>
                    <td class="px-4 py-2 border-2">
                        @if ($row->report->level_krisis === 'rendah')
                            <span
                                class="bg-blue-600 text-slate-300 rounded  px-1">{{ $row->report->level_krisis }}</span>
                        @elseif ($row->report->level_krisis === 'sedang')
                            <span
                                class="bg-blue-400 text-slate-300 rounded  px-1">{{ $row->report->level_krisis }}</span>
                        @elseif ($row->report->level_krisis === 'tinggi')
                            <span
                                class="bg-red-400 text-slate-300 rounded  px-1">{{ $row->report->level_krisis }}</span>
                        @elseif ($row->report->level_krisis === 'darurat')
                            <span
                                class="bg-red-700 text-slate-300 rounded  px-1">{{ $row->report->level_krisis }}</span>
                        @else
                            <span class="bg-yellow-300 rounded  px-1 text-slate-800">Belum Ditentukan</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border-2">{{ $row->updated_at->diffForHumans() }}</td>
                    <td class="px-4 py-2 border-2">
                        @if ($row->status === 'selesai')
                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">Selesai</span>
                        @elseif ($row->status === 'proses')
                            <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">Proses</span>
                        @else
                            <span
                                class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">{{ ucfirst($row->status) }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border-2 text-center">
                        <button type="button" wire:click="ModalDetail({{ $row->id }})"
                            class="px-2 py-1 bg-yellow-500 hover:bg-yellow-700 text-white rounded">
                            Detail
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        Tidak ada laporan.
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>


    @if ($detail)
        <div class=" fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6 space-y-2">
                <ul class="divide-y divide-gray-200">
                    <li class="py-2">Pelapor: {{ $detail->report->user->name }}</li>
                    <li class="py-2">Deskripsi: {{ $detail->report->deskripsi }}</li>
                    <li class="py-2">Kategori: {{ $detail->report->kategori }}</li>
                    <li class="py-2 ">Level Krisis:
                        @if ($detail->report->level_krisis === 'rendah')
                            <span
                                class="bg-blue-600 text-slate-800 rounded  px-1">{{ $detail->report->level_krisis }}</span>
                        @elseif ($detail->report->level_krisis === 'sedang')
                            <span
                                class="bg-blue-400 text-slate-800 rounded  px-1">{{ $detail->report->level_krisis }}</span>
                        @elseif ($detail->report->level_krisis === 'tinggi')
                            <span
                                class="bg-red-400 text-slate-800 rounded  px-1">{{ $detail->report->level_krisis }}</span>
                        @elseif ($detail->report->level_krisis === 'darurat')
                            <span
                                class="bg-red-700 text-slate-800 rounded  px-1">{{ $detail->report->level_krisis }}</span>
                        @else
                            <span class="bg-yellow-300 rounded  px-1 text-slate-800">Belum Ditentukan</span>
                        @endif
                    </li>
                    <li class="py-2">Lokasi: {{ $detail->report->lokasi }}</li>
                    <li class="py-2">Instansi yang dikerahkan :
                        <ul class=" ml-5">
                            @foreach ($instansi_terkait as $item)
                                <li>{{ $loop->iteration }}. {{ $item->nama_instansi }}</li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="py-2">Catatan Instansi:
                        {{ $detail->catatan_intansi ? $detail->catatan_intansi : 'belum ada catatan' }}</li>
                    <li class="py-2">Status:
                        {{ $detail->status }}
                    </li>
                    <li class="py-2">Terakhir Diubah: {{ $detail->updated_at->format('d M Y H:i') }}</li>
                </ul>
                <button type="button" wire:click="closeModal"
                    class="px-4 py-2 bg-gray-400 text-white rounded">Back</button>
            </div>

        </div>
    @endif



</div>

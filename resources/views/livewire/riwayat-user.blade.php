<div>

        <div class="relative w-full max-w-sm">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                </svg>
            </div>

            <input type="text" placeholder="Search..." wire:model.live="search"
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg   text-gray-800 placeholder-gray-400">
        </div>
    <table class="min-w-full border-2  border-gray-300 rounded-lg shadow-sm text-sm text-left table-auto mt-10">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border-2">No</th>
                <th class="px-4 py-2 border-2">deskripsi</th>
                <th class="px-4 py-2 border-2">kategori</th>
                <th class="px-4 py-2 border-2">Status</th>
                <th class="px-4 py-2 border-2">Terakhir diubah</th>
                <th class="px-4 py-2 border-2">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($index as $key =>  $row)
                <tr>
                    <td class="px-4 py-2 border-2">{{ $index->firstItem() + $key }}</td>
                    <td class="px-4 py-2 border-2 text-wrap">{{ \Illuminate\Support\Str::limit($row->deskripsi,20, '...') }}</td>
                    <td class="px-4 py-2 border-2 text-wrap text-justify">{{ $row->kategori }}</td>
                    <td class="px-4 py-2 border-2 text-wrap text-justify"><span class="bg-green-500 py-1 rounded text-white px-2">Selesai</span></td>
                    <td class="px-4 py-2 border-2 text-wrap text-justify">{{ $row->updated_at->diffForHumans() }}</td>
                    <td class="px-4 py-2 border-2 text-wrap text-center flex justify-center gap-2">
                        <a href="{{ route('riwayat.show', $row->id) }}" wire:navigate>
                            <button 
                                class="px-2 py-1 bg-yellow-500 hover:bg-yellow-700 rounded text-white transition-all hover:scale-110 active:scale-100 active:bg-yellow-300 delay-75">
                                Detail
                            </button>
    
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        Tidak ada Laporan.
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
    <div class="mt-4">
        {{ $index->links() }}
    </div>
    @if ($detail)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="max-w-3xl w-full mx-auto bg-white shadow-lg rounded-lg p-6 space-y-4 max-h-[90vh] overflow-y-auto">
            <ul class="divide-y divide-gray-200 flex flex-col gap-4">
                <li class="py-2 flex flex-col sm:flex-row sm:items-start gap-2">
                    <span class="font-semibold w-40">Deskripsi</span>
                    <div class="overflow-y-auto break-words whitespace-normal max-h-64 lg:max-w-[500px] text-justify">
                        {{ $detail->deskripsi }}
                    </div>
                </li>
                <li class="py-2 flex flex-col sm:flex-row sm:items-center gap-2">
                    <span class="font-semibold w-40">Kategori:</span>
                    <span>{{ $detail->kategori }}</span>
                </li>
                <li class="py-2 flex flex-col sm:flex-row sm:items-center gap-2">
                    <span class="font-semibold w-40">Level Krisis</span>
                    @if ($detail->level_krisis === "rendah")
                        <span class="bg-green-500 text-white rounded px-2">{{ $detail->level_krisis }}</span>
                    @elseif ($detail->level_krisis === "sedang")
                        <span class="bg-yellow-400 text-white rounded px-2">{{ $detail->level_krisis }}</span>
                    @elseif ($detail->level_krisis === "tinggi")
                        <span class="bg-red-500 text-white rounded px-2">{{ $detail->level_krisis }}</span>
                    @elseif ($detail->level_krisis === "darurat")
                        <span class="bg-black text-white rounded px-2">{{ $detail->level_krisis }}</span>
                    @else
                        <span class="bg-yellow-300 text-white rounded px-2">Belum Ditentukan</span>
                    @endif
                </li>
                <li class="py-2 flex flex-col sm:flex-row sm:items-start gap-2">
                    <span class="font-semibold w-40">Instansi yang dikerahkan</span>
                    <ul class="ml-5 list-decimal">
                        @foreach ($instansi_terkait as $item)
                            <li>{{ $item->nama_instansi }}</li>
                        @endforeach
                    </ul>
                </li>
                <li class="py-2 flex flex-col sm:flex-row sm:items-center gap-2">
                    <span class="font-semibold w-40">Lokasi</span>
                    <span>{{ $detail->lokasi }}</span>
                </li>
    
                <li class="py-2 flex flex-col sm:flex-row sm:items-start gap-2">
                    <span class="font-semibold w-40">Bukti</span>
                    @if($detail->foto)
                        <img src="{{ asset('storage/' . $detail->foto) }}" alt="Bukti" class="mt-2 w-48 rounded">
                    @else
                        <span class="text-gray-500">Tidak ada bukti</span>
                    @endif
                </li>
    
                <li class="py-2 flex flex-col sm:flex-row sm:items-start gap-2">
                    <span class="font-semibold w-40">Catatan Admin</span>
                    <div class="overflow-auto max-h-64">
                        {{ $detail->catatan_admin }}
                    </div>
                </li>

                <li class="py-2 flex flex-col sm:flex-row sm:items-center gap-2">
                    <span class="font-semibold w-40">Status</span>
                    <span class="px-2 py-1 rounded 
                        {{ $detail->status == 'disetujui' ? 'bg-green-100 text-green-700' : 
                           ($detail->status == 'ditolak' ? 'bg-red-100 text-red-700' : 
                           'bg-yellow-100 text-yellow-700') }}">
                        {{ ucfirst($detail->status) }}
                    </span>
                </li>
    
                <li class="py-2 flex flex-col sm:flex-row sm:items-center gap-2">
                    <span class="font-semibold w-40">Terakhir Diubah:</span>
                    <span>{{ $detail->updated_at->format('d M Y H:i') }}</span>
                </li>
    
                <li class="py-2 flex flex-col sm:flex-row sm:items-center gap-2">
                    <span class="font-semibold w-40">Dibuat Pada:</span>
                    <span>{{ $detail->created_at->format('d M Y H:i') }}</span>
                </li>
            </ul>
    
            <div class="mt-4 flex justify-start">
                <button class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800" wire:click="CloseModal">Back</button>
            </div>
        </div>
    </div>
    @endif
</div>

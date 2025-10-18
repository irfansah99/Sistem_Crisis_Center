<div>
    <div class="w-full max-w-3xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden">


        <div class="px-6 py-4  text-gray-700 space-y-4">

            <div class="grid sm:grid-cols-2 gap-4">
                <div class="flex flex-col gap-3">
                    <p><span class="font-semibold">Pelapor:</span> {{ $detail->user->name }}</p>
                    <p><span class="font-semibold">Kategori:</span> {{ $detail->kategori }}</p>
                    <p><span class="font-semibold">Lokasi:</span> <a href="{{ $detail->lokasi }} " target="_blank"
                            class="text-blue-500 hover:underline">Buka Maps</a></p>
                </div>
                <div class="flex flex-col gap-3 text-sm">
                    <p><span class="font-semibold">Level Krisis:</span>
                        @if ($detail->level_krisis === 'rendah')
                            <span class="bg-green-500 text-white rounded px-2 py-1">{{ $detail->level_krisis }}</span>
                        @elseif ($detail->level_krisis === 'sedang')
                            <span class="bg-yellow-400 text-white rounded px-2 py-1">{{ $detail->level_krisis }}</span>
                        @elseif ($detail->level_krisis === 'tinggi')
                            <span class="bg-red-500 text-white rounded px-2 py-1">{{ $detail->level_krisis }}</span>
                        @elseif ($detail->level_krisis === 'darurat')
                            <span class="bg-black text-white rounded px-2 py-1">{{ $detail->level_krisis }}</span>
                        @else
                            <span class="bg-yellow-300 text-white rounded px-2 py-1">Belum Ditentukan</span>
                        @endif
                    </p>
                    <p><span class="font-semibold">Status:</span>
                        <span class="px-2 py-1 rounded text-sm bg-green-500 text-white">
                            Selesai
                        </span>
                    </p>
                </div>
            </div>

            <div>
                <h3 class="font-semibold text-gray-800 mb-1">Deskripsi Kejadian</h3>
                <p class="bg-gray-50 border rounded-lg p-3 text-sm text-justify">{{ $detail->deskripsi }}</p>
            </div>

            <div>
                <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                    Instansi Terkait
                </h3>
                @if ($instansi_terkait->isNotEmpty())
                <div class="mt-4 overflow-x-auto rounded-lg shadow">
                    <table class="min-w-full border border-gray-200 bg-white text-sm">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700">
                                    <th class="border px-3 py-2">No</th>
                                    <th class="border px-3 py-2">Nama Instansi</th>
                                    <th class="border px-3 py-2">Status</th>
                                    <th class="border px-3 py-2">Catatan</th>
                                    <th class="border px-3 py-2">Terakhir Diubah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($instansi_terkait as $i => $item)
                                    <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 cursor-pointer" wire:click="OpenModal({{ $item->id }})">
                                        <td class="border px-3 py-1 text-center">{{ $i + 1 }}</td>
                                        <td class="border px-3 py-1">{{ $item->instansi->nama_instansi }}</td>
                                        <td class="border px-3 py-1">
                                            @switch($item->status)
                                                @case('sent')
                                                    <span
                                                        class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs font-medium">Dikirim</span>
                                                @break

                                                @case('received')
                                                    <span
                                                        class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded text-xs font-medium">Diterima</span>
                                                @break

                                                @case('on_progress')
                                                    <span
                                                        class="bg-orange-100 text-orange-700 px-2 py-0.5 rounded text-xs font-medium">Pengerjaan</span>
                                                @break

                                                @default
                                                    <span
                                                        class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-medium">Selesai</span>
                                            @endswitch
                                        </td>
                                        <td class="border px-3 py-1">
                                            {{ $item->catatan_intansi ? \Illuminate\Support\Str::limit($item->catatan_intansi, 20, '...') : 'Belum ada catatan' }}
                                        </td>
                                        <td class="border px-3 py-1">
                                            {{ $item->updated_at->format('d M Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-sm italic">Belum ada instansi terkait.</p>
                @endif
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 mb-1">Bukti Kejadian</h3>
                @if ($detail->foto)
                    <img src="{{ asset('storage/' . $detail->foto) }}" alt="Bukti Kejadian"
                        class="mt-2 w-64 rounded-lg shadow">
                @else
                    <p class="text-gray-500 text-sm italic">Tidak ada bukti</p>
                @endif
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 mb-1">Catatan Admin</h3>
                <p class="bg-gray-50 border rounded-lg p-3 text-sm">
                    {{ $detail->catatan_admin ?? 'Belum ada catatan' }}</p>
            </div>

            <div class="text-sm text-gray-500">
                <p>Dibuat: {{ $detail->created_at->format('d M Y H:i') }}</p>
                <p>Terakhir diubah: {{ $detail->updated_at->format('d M Y H:i') }}</p>
            </div>

        </div>

        <div class="px-6 py-3 border-t bg-gray-50 flex justify-start">
            <a href="{{ route('admin.histories.index') }}" wire:navigate>
                <button class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg transition">
                    Back
                </button>
            </a>

        </div>

    </div>

    @if ($Modal)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-center z-50">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="flex justify-between items-center px-5 py-3 border-b bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-800">
                    Detail Instansi
                </h2>
                <button 
                    wire:click="closeDetail" 
                    class="text-gray-500 hover:text-gray-700 transition"
                >
                    ✕
                </button>
            </div>

            <div class="p-6 space-y-4 text-gray-700">
                <div>
                    <p class="text-sm text-gray-500">Instansi</p>
                    <p class="font-semibold text-gray-800">
                        {{ $detail_instansi->instansi->nama_instansi }}
                    </p>
                </div>
    
                <div>
                    <p class="text-sm text-gray-500">Catatan Instansi</p>
                    <div class="mt-1 p-3 bg-gray-50 rounded-md text-sm text-gray-700 border max-h-[30vh] overflow-y-auto">
                        {{ $detail_instansi->catatan_intansi ?: 'Belum ada catatan' }}
                    </div>
                </div>
    
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <div class="mt-1">
                        @switch($detail_instansi->status)
                            @case('sent')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                    Dikirim
                                </span>
                            @break
    
                            @case('received')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                    Diterima
                                </span>
                            @break
    
                            @case('on_progress')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-700">
                                    Pengerjaan
                                </span>
                            @break
    
                            @default
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Selesai
                                </span>
                        @endswitch
                    </div>
                </div>
    
                <div>
                    <p class="text-sm text-gray-500">Terakhir Diubah</p>
                    <p class="font-medium text-gray-800">
                        {{ $detail_instansi->updated_at->format('d M Y') }}
                    </p>
                </div>
            </div>
    
        </div>
    </div>
    @endif
    
</div>

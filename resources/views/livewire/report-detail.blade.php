<div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6 space-y-2">
    <ul class="divide-y divide-gray-200">
        <li class="py-2">Pelaport: {{ $index->user->name }}</li>
        <li class="py-2">Judul: {{ $index->judul }}</li>
        <li class="py-2">Deskripsi: {{ $index->deskripsi }}</li>
        <li class="py-2">Kategori: {{ $index->kategori }}</li>
        <h3 class="text-lg font-semibold mt-4">Instansi Terkait</h3>
        @if ($instansi_terkait->isNotEmpty())
            <div class="mt-4 overflow-x-auto rounded-lg shadow">
                <table class="min-w-full border border-gray-200 bg-white text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="border px-4 py-2 text-left font-semibold">No</th>
                            <th class="border px-4 py-2 text-left font-semibold">Nama Instansi</th>
                            <th class="border px-4 py-2 text-center font-semibold">Status</th>
                            <th class="border px-4 py-2 text-left font-semibold w-[40%]">Catatan</th>
                            <th class="border px-4 py-2 text-center font-semibold">Terakhir Diubah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($instansi_terkait as $i => $item)
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 cursor-pointer"
                                wire:click="OpenDetail({{ $item->id }})">
                                <td class="border px-4 py-2 text-gray-700">{{ $i + 1 }}</td>
                                <td class="border px-4 py-2 font-medium text-gray-800">
                                    {{ $item->instansi->nama_instansi }}</td>
                                <td class="border px-4 py-2 text-center">
                                    @switch($item->status)
                                        @case('sent')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-xl bg-blue-100 text-blue-700">
                                                Dikirim
                                            </span>
                                        @break

                                        @case('received')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-xl bg-yellow-100 text-yellow-700">
                                                Diterima
                                            </span>
                                        @break

                                        @case('on_progress')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-xl bg-orange-100 text-orange-700">
                                                Pengerjaan
                                            </span>
                                        @break

                                        @default
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-xl bg-green-100 text-green-700">
                                                Selesai
                                            </span>
                                    @endswitch
                                </td>
                                <td class="border px-4 py-2 text-gray-600 italic">
                                    {{ $item->catatan_intansi ? \Illuminate\Support\Str::limit($item->catatan_intansi, 20, '...') : 'Belum ada catatan' }}
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    {{ $item->updated_at->format('d M Y H:i') }}
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada instansi terkait.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">Belum ada instansi terkait.</p>
            @endif


            <li class="py-2 ">Level Krisis:
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
            <li class="py-2">Lokasi: <a href="{{ $index->lokasi }} " target="_blank"
                    class="text-blue-500 hover:underline">Buka Maps</a></li>
            <li class="py-2">
                Bukti:
                @if ($index->foto)
                    <img src="{{ asset('storage/' . $index->foto) }}" alt="Bukti" class="mt-2 w-48 rounded">
                @else
                    <span class="text-gray-500">Tidak ada bukti</span>
                @endif
            </li>
            <li class="py-2">Catatan Admin: {{ $index->catatan_admin }}</li>
            <li class="py-2">Status:
                @if ($index->status === 'pending')
                    <span class="px-2 py-1 rounded text-slate-700 bg-slate-200">Menunggu</span>
                @elseif ($index->status === 'reject')
                    <span class="bg-red-500 text-white px-2 py-1 ">Laporan Ditolak</span>
                @elseif ($index->status === 'verified')
                    <span class="bg-blue-500 py-1 rounded text-white px-2">Laporan disetujui</span>
                @elseif ($index->status === 'on_progres')
                    <span class="bg-yellow-500 py-1 rounded text-white px-2">Diproses</span>
                @endif
            </li>
            <li class="py-2">Terakhir Diubah: {{ $index->updated_at->format('d M Y H:i') }}</li>
            <li class="py-2">Dibuat Pada: {{ $index->created_at->format('d M Y H:i') }}</li>
        </ul>
        <div class="mt-5 flex justify-center gap-2">
            <a href="{{ url()->previous() }}" wire:navigate>
                <button class="px-4 py-2 bg-gray-700 text-white rounded">Back</button>
            </a>
            <button wire:click="Edit({{ $index->id }})" class="px-4 py-2 bg-blue-600 text-white rounded">
                {{ $index->status === 'Pending' ? 'verifikasi' : 'Update' }}
            </button>
        </div>
        @if ($openModal)
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div
                    class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 flex flex-col gap-6">
                    <h2 class="text-xl font-bold">Update Laporan</h2>

                    <form class="flex flex-col gap-4" wire:submit.prevent="update">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <label for="level_krisis" class="font-semibold">Level Krisis</label>
                                <select id="level_krisis" wire:model="level_krisis"
                                    class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    <option value="">Pilih Krisis</option>
                                    <option value="rendah">Rendah</option>
                                    <option value="sedang">Sedang</option>
                                    <option value="tinggi">Tinggi</option>
                                    <option value="darurat">Darurat</option>
                                </select>
                                @error('level_krisis')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col">
                                <label for="status" class="font-semibold">Status</label>
                                <select id="status" wire:model="status"
                                    class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    @if ($index->status === 'pending')
                                        <option value="">Pilih Status</option>
                                        <option value="verified">Setujui</option>
                                        <option value="reject">Tolak</option>
                                    @else
                                        <option value="verified">Verifikasi</option>
                                        <option value="on_progres">Pengerjaan</option>
                                        <option value="done">Selesai</option>
                                    @endif
                                </select>
                                @error('status')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="flex flex-col gap-2">
                            <label class="font-semibold">Tambah Instansi</label>
                            <select name="filter" wire:model.live="filter"
                                class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <option value="">Pilih Instansi</option>
                                <option value="Keamanan & Ketertiban">Keamanan & Ketertiban</option>
                                <option value="Kesehatan">Kesehatan</option>
                                <option value="Kebakaran">Kebakaran</option>
                                <option value="Penanggulangan Bencana">Penanggulangan Bencana</option>
                                <option value="Sosial & Kemanusiaan">Sosial & Kemanusiaan</option>
                                <option value="Transportasi & Kecelakaan">Transportasi & Kecelakaan</option>
                                <option value="Lingkungan & Kebersihan">Lingkungan & Kebersihan</option>
                            </select>

                            <div
                                class="flex flex-col max-h-40 overflow-y-auto border border-gray-200 rounded p-2 gap-2 mt-2">
                                @forelse ($tambah_instansi as $item)
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" wire:model="instansi" id="instansi-{{ $item->id }}"
                                            name="instansi[]" value="{{ $item->id }}"
                                            class="form-checkbox h-4 w-4 text-blue-600">
                                        <span class="text-gray-700">{{ $item->nama_instansi }}</span>
                                    </label>
                                @empty
                                    <span class="text-gray-500">Tidak ada Instansi</span>
                                @endforelse
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label for="catatan_admin" class="font-semibold">Catatan Admin</label>
                            <textarea id="catatan_admin" wire:model="catatan_admin"
                                class="w-full h-24 border border-gray-300 rounded px-3 py-2 resize-none"></textarea>
                            @error('catatan_admin')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3 mt-2">
                            <button type="button" wire:click="closeModal"
                                class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 transition">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        @endif


        @if ($DetailInstansi)
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-center z-50">
                <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="flex justify-between items-center px-5 py-3 border-b bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">
                            Detail Instansi
                        </h2>
                        <button wire:click="closeDetail" class="text-gray-500 hover:text-gray-700 transition">
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
                            <div
                                class="mt-1 p-3 bg-gray-50 rounded-md text-sm text-gray-700 border  max-h-[30vh] overflow-y-auto">
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





    <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
    <script>
        var pusher = new Pusher("hrc1og0mjabrrlcikvyw", {
            cluster: "",
            enabledTransports: ['ws'],
            forceTLS: false,
            wsHost: "127.0.0.1",
            wsPort: "8080"
        });

        var channel = pusher.subscribe("instansi_update");


        channel.bind("instansi.updated", function(data) {
            dispatchEvent(new CustomEvent('reportInstansiUpdated', {
                detail: data
            }));
        });
    </script>

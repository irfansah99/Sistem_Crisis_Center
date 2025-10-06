<x-layout_admin>
    <x-slot:judul>{{ $judul }}</x-slot:judul>

    <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6 space-y-2">
        <ul class="divide-y divide-gray-200">
            <li class="py-2">Pelaport: {{ $index->user->name }}</li>
            <li class="py-2">Judul: {{ $index->judul }}</li>
            <li class="py-2">Deskripsi: {{ $index->deskripsi }}</li>
            <li class="py-2">Kategori: {{ $index->kategori }}</li>
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
                                <td class="border px-2 py-1">{{ $item->catatan_instansi }}</td>
                                <td class="border px-2 py-1">{{ $item->updated_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">Belum ada instansi terkait.</p>
            @endif
            
            
            <li class="py-2 ">Level Krisis:
                @if ($index->level_krisis === 'rendah')
                    <span class="bg-blue-600 text-slate-300 rounded  px-1">{{ $index->level_krisis }}</span>
                @elseif ($index->level_krisis === 'sedang')
                    <span class="bg-blue-400 text-slate-300 rounded  px-1">{{ $index->level_krisis }}</span>
                @elseif ($index->level_krisis === 'tinggi')
                    <span class="bg-red-400 text-slate-300 rounded  px-1">{{ $index->level_krisis }}</span>
                @elseif ($index->level_krisis === 'darurat')
                    <span class="bg-red-700 text-slate-300 rounded  px-1">{{ $index->level_krisis }}</span>
                @else
                    <span class="bg-yellow-300 rounded  px-1 text-slate-800">Belum Ditentukan</span>
                @endif
            </li>
            <li class="py-2">Lokasi: {{ $index->lokasi }}</li>
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
                <span
                    class="px-2 py-1 rounded 
                    {{ $index->status == 'disetujui'
                        ? 'bg-green-100 text-green-700'
                        : ($index->status == 'ditolak'
                            ? 'bg-red-100 text-red-700'
                            : 'bg-yellow-100 text-yellow-700') }}">
                    {{ ucfirst($index->status) }}
                </span>
            </li>
            <li class="py-2">Terakhir Diubah: {{ $index->updated_at->format('d M Y H:i') }}</li>
            <li class="py-2">Dibuat Pada: {{ $index->created_at->format('d M Y H:i') }}</li>
        </ul>
        <div class="mt-5 flex justify-center gap-2">
            <a href="{{ url()->previous() }}">
                <button class="px-4 py-2 bg-gray-700 text-white rounded">Back</button>
            </a>
            <button onclick="openModal()" class="px-4 py-2 bg-blue-600 text-white rounded">
                {{ $index->status === 'Pending' ? 'verifikasi' : 'Update' }}
            </button>
        </div>

    </div>

    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded shadow-lg lg:w-[50%] lg:h-[65%] w-[70%] h-[80%]">
            <h2 class="text-lg font-semibold mb-4">Update Status</h2>

            <form method="POST" action="{{ route('reports.update', $index->id) }}" class="flex flex-col">
                @csrf
                @method('PUT')
                <label for="level_krisis">Level Krisis:</label>
                <select name="level_krisis" class="w-full border rounded p-2 mb-3">
                    <option value="rendah" {{ $index->status == 'rendah' ? 'selected' : '' }}>Rendah</option>
                    <option value="sedang" {{ $index->status == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="tinggi" {{ $index->status == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                    <option value="darurat" {{ $index->status == 'darurat' ? 'selected' : '' }}>Darurat</option>
                </select>
                @if ($index->status === 'pending')
                    <label for="status">Status:</label>
                    <select name="status" class="w-full border rounded p-2 mb-3">
                        <option value="verified" {{ $index->status == 'verified' ? 'selected' : '' }}>Setujui</option>
                        <option value="reject" {{ $index->status == 'reject' ? 'selected' : '' }}>Tolak</option>
                    </select>


                    <label>Pilih Instansi</label>
                    <div class="flex flex-col gap-2">
                        @forelse ($instansi as $item)
                            <label class="block">
                                <input type="checkbox" name="instansi[]" value="{{ $item->id }}">
                                {{ $item->nama_instansi }}
                            </label>
                        @empty
                            <span>Tidak ada Instansi</span>
                        @endforelse
                    </div>
                @else
                    <div>
                        <button id="instansi_button" type="button" class="bg-blue-400 rounded px-2 py-1 text-white"
                            onclick="openInstansi()">
                            Tambah Instansi
                        </button>
                    </div>
                    <div id="instansi" class="flex flex-col gap-2 hidden">
                        @forelse ($tambah_instansi as $item)
                            <label class="block">
                                <input type="checkbox" name="instansi[]" value="{{ $item->id }}">
                                {{ $item->nama_instansi }}
                            </label>
                        @empty
                            <span>Tidak ada Instansi</span>
                        @endforelse
                    </div>

                    <label for="status">Status:</label>
                    <select name="status" class="w-full border rounded p-2 mb-3">
                        <option value="on_progres" {{ $index->status == 'on_progres' ? 'selected' : '' }}>Pengerjaan
                        </option>
                        <option value="done" {{ $index->status == 'done' ? 'selected' : '' }}>Selesai</option>
                    </select>
                @endif



                <label for="catatan_admin">Catatan Admin:</label>
                <textarea name="catatan_admin" class="w-full h-[60%] border rounded p-2 mb-3">{{ $index->catatan_admin }}</textarea>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="openModal()"
                        class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("modal").classList.toggle("hidden");
        }

        function openInstansi() {
            const instansiDiv = document.getElementById("instansi");
            const button = document.getElementById("instansi_button");

            instansiDiv.classList.toggle("hidden");

            if (!instansiDiv.classList.contains("hidden")) {
                button.innerHTML = "Tutup Instansi";
            } else {
                button.innerHTML = "Tambah Instansi";
            }
        }
    </script>

    <x-sweet-alert />
</x-layout_admin>

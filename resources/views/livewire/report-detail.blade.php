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
        <button  wire:click="Edit({{ $index->id }})" class="px-4 py-2 bg-blue-600 text-white rounded">
            {{ $index->status === 'Pending' ? 'verifikasi' : 'Update' }}
        </button>
    </div>
    @if ($openModal)
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded shadow-lg lg:w-[50%] lg:h-[65%] w-[70%] h-[80%] overflow-y-auto">
            <h2 class="text-lg font-semibold mb-4">Update Status</h2>
    
            <form class="flex flex-col" wire:submit="update" >
                @error('level_krisis') <span class="text-red-500">{{ $message }}</span> @enderror
                <label for="level_krisis">Level Krisis:</label>
                <select id="level_krisis" wire:model="level_krisis" class="w-full border rounded p-2 mb-3">
                    <option value="">pilih Krisis</option>
                    <option value="rendah">Rendah</option>
                    <option value="sedang">Sedang</option>
                    <option value="tinggi">Tinggi</option>
                    <option value="darurat">Darurat</option>
                </select>
            
                {{-- Status --}}
                @if ($index->status === 'pending')
                    <label for="status">Status:</label>
                    <select id="status" wire:model="status" class="w-full border rounded p-2 mb-3">
                        <option value="">Pilih Status</option>
                        <option value="verified">Setujui</option>
                        <option value="reject">Tolak</option>
                    </select>
            
                    <div class="flex flex-col gap-2" id="instansi">
                        @forelse ($tambah_instansi as $item)
                            <label class="block">
                                <input type="checkbox" wire:model="instansi" value="{{ $item->id }}">
                                {{ $item->nama_instansi }}
                            </label>
                        @empty
                            <span>Tidak ada Instansi</span>
                        @endforelse
                    </div>
                @else

            
                <div class="flex flex-col gap-2 " id="instansi">
                        @forelse ($tambah_instansi as $item)
                            <label class="block">
                                <input type="checkbox" wire:model="instansi" value="{{ $item->id }}">
                                {{ $item->nama_instansi }}
                            </label>
                        @empty
                            <span>Tidak ada Instansi</span>
                        @endforelse
                    </div>
                    @error('status') <span class="text-red-500">{{ $message }}</span> @enderror
                    <label for="status">Status:</label>
                    <select id="status" wire:model="status" class="w-full border rounded p-2 mb-3">
                        <option value="verified">Verifikasi</option>
                        <option value="on_progres">Pengerjaan</option>
                        <option value="done">Selesai</option>
                    </select>
                @endif
            
                @error('catatan_admin') <span class="text-red-500">{{ $message }}</span> @enderror
                <label for="catatan_admin">Catatan Admin:</label>
                <textarea id="catatan_admin" wire:model="catatan_admin" class="w-full h-[60%] border rounded p-2 mb-3"></textarea>
                <div>
                   
                </div>
                
                <div class="flex justify-end gap-2">
                    <button type="button" wire:click="closeModal"
                        class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded" >Simpan</button>
                </div>
            </form>
            
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
<div>
    <table class="min-w-full border-2  border-gray-300 rounded-lg shadow-sm text-sm text-left table-auto mt-20">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border-2">No</th>
                <th class="px-4 py-2 border-2">deskripsi</th>
                <th class="px-4 py-2 border-2">kategori</th>
                <th class="px-4 py-2 border-2">Terakhir diubah</th>
                <th class="px-4 py-2 border-2">Status</th>
                <th class="px-4 py-2 border-2">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($index as $row)
                <tr>
                    <td class="px-4 py-2 border-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border-2 text-wrap">{{ \Illuminate\Support\Str::limit($row->deskripsi,20, '...') }}</td>
                    <td class="px-4 py-2 border-2 text-wrap text-justify">{{ $row->kategori }}</td>
                    <td class="px-4 py-2 border-2 text-wrap text-justify">{{ $row->updated_at->diffForHumans() }}</td>
                    <td class="px-4 py-2 border-2 text-wrap text-justify">{{ $row->status }}</td>
                    <td class="px-4 py-2 border-2 text-wrap text-center flex justify-center gap-2">
                        @if ($row->status === 'pending')
                            <form id="form-hapus-{{ $row->id }}" action="{{ route('beranda.destroy', $row->id) }}"
                                method="POST" class="my-auto">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="konfirmasiHapus({{ $row->id }})"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md">
                                    Hapus
                                </button>
                            </form>
                                <button wire:click="OpenModal({{ $row->id }})"
                                    class="px-2 py-1 bg-yellow-500 hover:bg-yellow-700 rounded text-white transition-all hover:scale-110 active:scale-100 active:bg-yellow-300 delay-75">
                                    Detail
                                </button>
                        @else
                            <button type="button"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md pointer-events-none">
                                Hapus
                            </button>
                                <button wire:click="OpenModal({{ $row->id }})"
                                    class="px-2 py-1 bg-yellow-500 hover:bg-yellow-700 rounded text-white transition-all hover:scale-110 active:scale-100 active:bg-yellow-300 delay-75">
                                    Detail
                                </button>
                        @endif



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
    @if ($detail)
    <div
    class=" fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6 space-y-2">
        <ul class="divide-y divide-gray-200">
            <li class="py-2">Deskripsi: {{ $detail->deskripsi }}</li>
            <li class="py-2">Kategori: {{ $detail->kategori }}</li>
            <li class="py-2 ">Level Krisis: 
                @if ($detail->level_krisis === "rendah")
                <span class="bg-blue-600 text-slate-800 rounded  px-1">{{ $detail->level_krisis }}</span>
                @elseif ($detail->level_krisis === "sedang")
                <span class="bg-blue-400 text-slate-800 rounded  px-1">{{ $detail->level_krisis }}</span>
                @elseif ($detail->level_krisis === "tinggi")
                <span class="bg-red-400 text-slate-800 rounded  px-1">{{ $detail->level_krisis }}</span>
                @elseif ($detail->level_krisis === "darurat")
                <span class="bg-red-700 text-slate-800 rounded  px-1">{{ $detail->level_krisis }}</span>
                @else
                <span class="bg-yellow-300 rounded  px-1 text-slate-800">Belum Ditentukan</span>
                @endif
            </li>
            <li class="py-2">Instansi yang dikerahkan :
                <ul class=" ml-5">
                    @foreach ($instansi_terkait as $item)
                        <li>{{ $loop->iteration }}. {{ $item->nama_instansi }}</li>
                    @endforeach
                </ul>
            </li>
            <li class="py-2">Lokasi: {{ $detail->lokasi }}</li>
            <li class="py-2">
                Bukti:
                @if($detail->foto)
                    <img src="{{ asset('storage/' . $detail->foto) }}" alt="Bukti" class="mt-2 w-48 rounded">
                @else
                    <span class="text-gray-500">Tidak ada bukti</span>
                @endif
            </li>
            <li class="py-2">Catatan Admin: {{ $detail->catatan_admin }}</li>
            <li class="py-2">Status: 
                <span class="px-2 py-1 rounded 
                    {{ $detail->status == 'disetujui' ? 'bg-green-100 text-green-700' : 
                       ($detail->status == 'ditolak' ? 'bg-red-100 text-red-700' : 
                       'bg-yellow-100 text-yellow-700') }}">
                    {{ ucfirst($detail->status) }}
                </span>
            </li>
            <li class="py-2">Terakhir Diubah: {{ $detail->updated_at->format('d M Y H:i') }}</li>
            <li class="py-2">Dibuat Pada: {{ $detail->created_at->format('d M Y H:i') }}</li>
        </ul>
            <button class="px-4 py-2 bg-gray-700 text-white rounded" wire:click="CloseModal">Back</button>
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
        wsPort: 8080,
        authEndpoint: "/broadcasting/auth",
        auth: {
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}", 
            }
        }
    });


    var channel = pusher.subscribe("private-reports.{{ $user->id }}");

    channel.bind("report.updated", function(data) {
        window.dispatchEvent(new CustomEvent('reportUpdated', {
            detail: data
        }));
    });
</script>

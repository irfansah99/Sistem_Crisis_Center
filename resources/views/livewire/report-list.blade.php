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
                        <a href="{{ route('admin.reports.show', $row->id) }}">
                            <button class="px-2 py-1 bg-yellow-500 hover:bg-yellow-700 text-white rounded">
                                Detail
                            </button>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-gray-500">Tidak ada laporan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
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

    var channel = pusher.subscribe("reports");


    channel.bind("report.created", function(data) {
        dispatchEvent(new CustomEvent('reportAdded', {
            detail: data
        }));
    });

</script>


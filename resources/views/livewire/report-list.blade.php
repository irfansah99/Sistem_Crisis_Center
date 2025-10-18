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
    <table class="min-w-full border-2 border-gray-300 rounded-lg shadow-sm text-sm text-left table-auto mt-10">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border-2">No</th>
                <th class="px-4 py-2 border-2">Pelapor</th>
                <th class="px-4 py-2 border-2">Deskripsi</th>
                <th class="px-4 py-2 border-2">Kategori</th>
                <th class="px-4 py-2 border-2">Terakhir diubah</th>
                <th class="px-4 py-2 border-2">Status</th>
                <th class="px-4 py-2 border-2">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($reports as $key => $row)
                <tr>
                    <td class="px-4 py-2 border-2">{{  $reports->firstItem() + $key }}</td>
                    <td class="px-4 py-2 border-2">{{ $row->user->name }}</td>
                    <td class="px-4 py-2 border-2">{{ \Illuminate\Support\Str::limit($row->deskripsi, 20, '...') }}</td>
                    <td class="px-4 py-2 border-2">{{ $row->kategori }}</td>
                    <td class="px-4 py-2 border-2">{{ $row->updated_at->diffForHumans() }}</td>
                    <td class="px-4 py-2 border-2">
                        @if ($row->status === 'pending')
                            <span class="px-2 py-1 rounded text-slate-700 bg-slate-200">Menunggu</span>
                        @elseif ($row->status === 'reject')
                            <span class="bg-red-500 text-white px-2 py-1 ">Laporan Ditolak</span>
                        @elseif ($row->status === 'verified')
                            <span class="bg-blue-500 py-1 rounded text-white px-2">Laporan disetujui</span>
                        @elseif ($row->status === 'on_progres')
                            <span class="bg-yellow-500 py-1 rounded text-white px-2">Diproses</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border-2 text-center">
                        <a href="{{ route('admin.reports.show', $row->id) }}" wire:navigate>
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
    <div class="mt-4">
        {{ $reports->links() }}
    </div>
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

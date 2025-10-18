<div class="relative">
    <button id="tombol" class="relative text-2xl hover:scale-110 transition-all delay-150 ">
        🔔
        @if ($countnotif > 0)
            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1">
                {{ $countnotif }}
            </span>
        @endif
    </button>


    <div class="absolute right-0 mt-2 px-2   bg-white shadow-lg rounded-lg  z-50 hidden" id="list">
        <ul class="divide-y divide-gray-200  max-h-[80vh] min-h-[10vh] w-[14vw] overflow-auto py-2">
            @forelse($instansi->unreadNotifications as $notif)
                <li class="px-4 py-2 text-lg hover:bg-gray-100  flex flex-col  cursor-pointer rounded"
                    wire:click="update('{{ $notif->id }}')">
                    <span class="text-blue-400">
                        {{ $notif->data['pesan'] }}
                    </span>
                    <span x-data class="text-xs text-gray-400"
                        x-text="dayjs('{{ $notif->created_at->timezone('Asia/Jakarta') }}').fromNow()">
                    </span>
                </li>

            @empty
                <li class="px-4 py-2 text-sm text-gray-500">Tidak ada notifikasi</li>
            @endforelse
        </ul>
        <div class="flex justify-center p-2">
            <button wire:click="ClearAll"
                class="border-slate-400 border hover:bg-slate-300 active:bg- rounded px-2 py-1">Tandai
                Semua</button>
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

    var channel = pusher.subscribe("report_instansi");


    channel.bind("report.instansi", function(data) {
        console.log('event diterima');
        dispatchEvent(new CustomEvent('reportInstansiNotif', {
            detail: {
                instansi_id: data.instansi_id,
            }
        }));

    });

</script>

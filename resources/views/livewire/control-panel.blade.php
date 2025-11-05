<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mt-4">

    @if (auth()->user('admin')->role === 'superadmin')
        <a href="/admin/kelola_admin" wire:navigate>
            <div
                class="bg-white shadow rounded-lg flex h-[20vh] hover:scale-105 active:grayscale transition-transform duration-300">
                <div class="basis-1/3 bg-green-500 flex items-center justify-center text-white text-4xl rounded-l-lg">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="basis-2/3 p-4 text-center flex flex-col justify-center">
                    <h2 class="text-xl font-semibold text-green-700">Admins</h2>
                    <p class="text-4xl text-green-600">{{ $admin }}</p>
                </div>
            </div>
        </a>
    @endif


    <a href="/admin/reports" wire:navigate>
        <div
            class="bg-white shadow rounded-lg flex h-[20vh] hover:scale-105 active:grayscale transition-transform duration-300">
            <div class="basis-1/3 bg-blue-500 flex items-center justify-center text-white text-4xl rounded-l-lg">
                <i class="fas fa-file-alt"></i> {{-- laporan --}}
            </div>
            <div class="basis-2/3 p-4 text-center flex flex-col justify-center">
                <h2 class="text-xl font-semibold text-blue-700">Reports</h2>
                <p class="text-4xl text-blue-600">{{ $report }}</p>
            </div>
        </div>
    </a>


    <a href="/admin/histories" wire:navigate>
        <div
            class="bg-white shadow rounded-lg flex h-[20vh] hover:scale-105 active:grayscale transition-transform duration-300">
            <div class="basis-1/3 bg-purple-500 flex items-center justify-center text-white text-4xl rounded-l-lg">
                <i class="fas fa-history"></i>
            </div>
            <div class="basis-2/3 p-4 text-center flex flex-col justify-center">
                <h2 class="text-xl font-semibold text-purple-700">Histories</h2>
                <p class="text-4xl text-purple-600">{{ $riwayat }}</p>
            </div>
        </div>
    </a>


    <a href="/admin/kelola_instansi" wire:navigate>
        <div
            class="bg-white shadow rounded-lg flex h-[20vh] hover:scale-105 active:grayscale transition-transform duration-300">
            <div class="basis-1/3 bg-teal-500 flex items-center justify-center text-white text-4xl rounded-l-lg">
                <i class="fas fa-building"></i>
            </div>
            <div class="basis-2/3 p-4 text-center flex flex-col justify-center">
                <h2 class="text-xl font-semibold text-teal-700">Instansi</h2>
                <p class="text-4xl text-teal-600">{{ $instansi }}</p>
            </div>
        </div>
    </a>
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

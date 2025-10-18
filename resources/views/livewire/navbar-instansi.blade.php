<nav class="bg-gray-800" x-data="{ isOpen: false }">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="shrink-0">
                    <img class="size-10" src="{{ url('image/logo.png') }}" alt="Logo">
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/instansi/dashboard"
                            class="{{ request()->is('instansi/dashboard') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md  px-3 py-2 text-sm font-medium "
                            wire:navigate>Dashboard</a>
                        <a href="/instansi/histories"
                            class="{{ request()->is('instansi/histories') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md  px-3 py-2 text-sm font-medium "
                            wire:navigate>Riwayat</a>
                        @can('akses-petugas')
                            <a href="/kelola_penggunaan"
                                class="{{ request()->is('kelola_penggunaan') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium  hover:bg-gray-700 hover:text-white">Penggunaan</a>
                        @endcan
                        @can('akses-instansi')
                            <a href="/kelola_tagihan"
                                class="{{ request()->is('kelola_tagihan') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium  hover:bg-gray-700 hover:text-white">Tagihan</a>
                            <a href="/riwayat_pembayaran"
                                class="{{ request()->is('riwayat_pembayaran') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium  hover:bg-gray-700 hover:text-white">Riwayat</a>
                            <a href="/user"
                                class="{{ request()->is('user') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium  hover:bg-gray-700 hover:text-white">User</a>
                        @endcan

                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <button type="button"
                        class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">View notifications</span>
                    </button>

                    <!-- Profile dropdown -->
                    <div class="relative ml-3">
                        <div class="flex items-center">
                            <h1 class="text-white mr-3">{{ auth('instansi')->user()->nama_instansi }}</h1>
                            <div>
                                <button type="button" @click="isOpen = !isOpen"
                                    class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>

                                    @if (auth('instansi')->user()->image)
                                        <img class="size-8 rounded-full object-cover"
                                            src="{{ asset('storage/' . auth('instansi')->user()->image) }}"
                                            alt="Profil">
                                    @else
                                        <img class="size-8 rounded-full object-cover"
                                            src="{{ url('image/nophoto.jpg') }}" alt="Profil Default">
                                    @endif


                                </button>
                            </div>
                        </div>

                        <div x-show="isOpen"@click.away="isOpen = false" x-cloak
                            x-transition:enter="transition ease-out duration-100 transform"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75 transform"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-hidden"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                            tabindex="-1">
                            <!-- Active: "bg-gray-100 outline-hidden", Not Active: "" -->
                            <a href="{{ route('instansi.profil.edit') }}" class="block px-4 py-2 text-sm text-gray-700"
                                role="menuitem" tabindex="-1" id="user-menu-item-0" wire:navigate>Your Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="user-menu-item-2">
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit">Log Out</button>
                                </form>
                            </a>
                        </div>
                    </div>
                    <div x-data="{ OpenNotif: false }" class="relative">
                        <button class="relative text-2xl hover:scale-110 transition-all delay-150"
                            :class="{ 'scale-110': OpenNotif }" @click="OpenNotif = !OpenNotif">
                            🔔
                            @if ($countnotif > 0)
                                <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1 ">
                                    {{ $countnotif }}
                                </span>
                            @endif
                        </button>

                        <div x-show="OpenNotif" @click.outside="OpenNotif = false" x-cloak
                            x-transition:enter="transition ease-out duration-100 transform"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75 transform"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 z-50 mt-2 w-[16rem] bg-white rounded-lg shadow-lg ring-1 ring-black/5">
                            <ul
                                class="divide-y divide-gray-200 max-h-[70vh] min-h-[10vh] overflow-auto py-2 flex flex-col gap-2">
                                @forelse($instansi->unreadNotifications as $notif)
                                    <li class="px-4 py-3 text-lg hover:bg-gray-100 flex flex-col cursor-pointer rounded transition-all delay-150 hover:translate-y-1"
                                        wire:click="update('{{ $notif->id }}')">
                                        <span class="text-blue-400">
                                            {{ $notif->data['pesan'] }}
                                        </span>
                                        <span x-data class="text-xs text-gray-400"
                                            x-text="dayjs('{{ $notif->created_at->timezone('Asia/Jakarta') }}').fromNow()"></span>
                                    </li>
                                @empty
                                    <li class="px-4 py-2 text-sm text-gray-500 text-center">Tidak ada notifikasi</li>
                                @endforelse
                            </ul>

                            <div class="flex justify-center p-2 border-t">
                                <button wire:click="ClearAll"
                                    class="border-slate-400 border hover:bg-slate-300 active:bg-slate-200 rounded px-2 py-1 text-sm">
                                    Tandai Semua
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="-mr-2 flex md:hidden ov">
                    <!-- Mobile menu button -->
                    <button type="button" @click="isOpen = !isOpen"
                        class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <!-- Menu open: "hidden", Menu closed: "block" -->
                        <svg :class="{ 'hidden': isOpen, 'block': !isOpen }" class="block size-6" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                            data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <!-- Menu open: "block", Menu closed: "hidden" -->
                        <svg :class="{ 'block': isOpen, 'hidden': !isOpen }" class="hidden size-6" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                            data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div x-show="isOpen" class="md:hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                <a href="/dashboard"
                    class="{{ request()->is('dashboard') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} block rounded-md px-3 py-2 text-sm font-medium">
                    Dashboard
                </a>
                @can('akses-petugas')
                    <a href="/kelola_penggunaan"
                        class="{{ request()->is('kelola_penggunaan') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} block rounded-md px-3 py-2 text-sm font-medium">
                        Penggunaan
                    </a>
                @endcan

                @can('akses-instansi')
                    <a href="/kelola_tagihan"
                        class="{{ request()->is('kelola_tagihan') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} block rounded-md px-3 py-2 text-sm font-medium">
                        Tagihan
                    </a>
                    <a href="/riwayat_pembayaran"
                        class="{{ request()->is('riwayat_pembayaran') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} block rounded-md px-3 py-2 text-sm font-medium">
                        Riwayat
                    </a>
                    <a href="/user"
                        class="{{ request()->is('user') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} block rounded-md px-3 py-2 text-sm font-medium">
                        User
                    </a>
                @endcan




                <div class="border-t border-gray-700 pt-4 pb-3">
                    <div class="flex items-center my-5 px-5">
                        <div class="shrink-0">
                            <img class="size-10 rounded-full object-cover" src="{{ url('image/nophoto.jpg') }}"
                                alt="Profil Default">
                        </div>

                        <div class="ml-3">
                            <div class="text-base font-medium text-white">
                                {{ auth('instansi')->user()->name ?? 'Nama Pengguna' }}
                            </div>
                        </div>
                    </div>

                    <a href="#"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Your
                        Profile</a>
                    <form action="/logout" method="POST">
                        @csrf
                        <button
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white"
                            type="submit">Log Out</button>
                    </form>
                </div>
            </div>
        </div>
</nav>
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

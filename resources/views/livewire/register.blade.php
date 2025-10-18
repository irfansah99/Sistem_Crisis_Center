<div
    class="relative flex justify-center items-center min-h-screen w-full before:content-[''] before:absolute before:inset-0 before:bg-[url('https://asset.kompas.com/crops/jZavvc2_23rHDJzJUzILa3WMBlE=/0x0:0x0/750x500/data/photo/2024/10/27/671d7d4fe0d8d.jpg')] before:bg-cover before:bg-no-repeat before:blur-sm before:z-0">
    <form wire:submit.prevent="{{ $lagiupdate ? 'update' : 'create' }}"
        class="relative z-10 space-y-5 bg-white/70 backdrop-blur-md shadow-lg rounded-xl p-6 w-full max-w-[70%] lg:max-w-[40%]">

        <img src="image/logo.png" alt="logo" class="w-24 mx-auto my-3">
        <h1 class="text-2xl font-semibold text-gray-700 text-center">Sistem Pelaporan Cepat dan Penanganan Insiden
        </h1>
        @if (session('loginerror'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                {{ session('loginerror') }}
            </div>
        @endif
        <div class="flex flex-col">
            <label class="block text-gray-700 mb-1">Nama Lengkap</label>
            <input class="border-2 rounded bg-white p-1 @error('name') is-invalid @enderror" type="text"
                name="name" placeholder="Masukan nama lengkap" wire:model="name" required autocomplete="off">

            @error('name')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex flex-col">
            <label class="block text-gray-700 mb-1">email</label>
            <input class="border-2 rounded bg-white p-1 @error('email') is-invalid @enderror" type="text"
                placeholder="Masukan alamat email" name="email" wire:model="email" required autocomplete="off">
            @error('email')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex flex-col">
            <label class="block text-gray-700 mb-1">Alamat</label>
            <input class="border-2 rounded bg-white p-1 @error('address') is-invalid @enderror" type="text"
                placeholder="Masukan alamat tempat tinggal" name="address" wire:model="address" required autocomplete="off">
            @error('address')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex flex-col">
            <label class="block text-gray-700 mb-1">nomor Handphone</label>
            <input class="border-2 rounded bg-white p-1 @error('phone') is-invalid @enderror" type="text"
                name="phone" placeholder="Masukan no phone" wire:model="phone" required autocomplete="off">

            @error('phone')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div x-data="{ show: false }" class="relative flex flex-col">
            <label class="block text-gray-700 mb-1">Password</label>
            <div class="relative flex items-center">
                <input :type="show ? 'text' : 'password'" wire:model="password" name="password"
                    placeholder="Masukkan password" {{ $lagiupdate ? '' : 'required' }} autocomplete="off"
                    class="border-2 rounded bg-white p-2 pr-10 w-full @error('password') border-red-500 @enderror">
                <i @click="show = !show" class="absolute right-3 text-gray-500 cursor-pointer text-lg"
                    :class="show ? 'fa fa-eye' : 'fa fa-eye-slash'">
                </i>
            </div>
            @error('password')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>


        <div x-data="{ showConfirm: false }" class="relative flex flex-col">
            <label class="block text-gray-700 mb-1">Konfirmasi Password</label>
            <div class="relative flex items-center">
                <input :type="showConfirm ? 'text' : 'password'" wire:model="password_confirmation"
                    name="password_confirmation" placeholder="Ulangi password" {{ $lagiupdate ? '' : 'required' }}
                    autocomplete="off"
                    class="border-2 rounded bg-white p-2 pr-10 w-full @error('password') border-red-500 @enderror">
                <i @click="showConfirm = !showConfirm"
                    class="absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-gray-500"
                    :class="showConfirm ? 'fa fa-eye' : 'fa fa-eye-slash'">
                </i>
            </div>
            @error('password_confirmation')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <input
            class="block bg-blue-500 text-white px-4 py-2 rounded mx-auto hover:bg-indigo-500 transition transform hover:-translate-y-1 hover:scale-105 active:bg-red-600"
            type="submit" value="{{ $lagiupdate ? 'update' : 'submit' }}">

        <div class="mt-4 text-sm">
            Sudah punya akun?
            <a href="/login" class="text-blue-500 hover:underline">Login</a>
        </div>
    </form>
    @if ($OpenVerifikasi)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
                <h2 class="text-xl font-semibold mb-4 text-center">Verifikasi Email</h2>
                <p class="text-center text-gray-700 mb-4">
                    Silakan verifikasi email Anda dengan memasukkan kode OTP yang telah dikirim ke
                    <strong>{{ $email_new }}</strong>.
                </p>

                @if (session('error'))
                    <div class="bg-red-100 text-red-700 px-3 py-2 rounded mb-3 text-center">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-100 text-green-700 px-3 py-2 rounded mb-3 text-center">
                        {{ session('success') }}
                    </div>
                @endif

                <form wire:submit.prevent="verifikasi">
                    <div class="mb-4">
                        <input type="text" name="otp" id="otp" maxlength="6"
                            placeholder="Masukkan kode OTP" wire:model="otp"
                            class="w-full border-gray-300 bg-slate-100 rounded-md mt-1 px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        @error('otp')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex gap-4 justify-center">
                        @if ($Openkirimulang)
                            <button type="button" wire:click="KirimUlang"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition">
                                Kirim Ulang
                            </button>
                        @else
                            <button type="button" disabled
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition">
                                dikirim...
                            </button>
                        @endif

                        <button type="submit"
                            class="bg-blue-600  hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                            Verifikasi Sekarang
                        </button>
                    </div>

                </form>
                <button class="text-blue-500 hover:underline" wire:click="isiulang">ubah?</button>
            </div>
        </div>
    @endif
</div>

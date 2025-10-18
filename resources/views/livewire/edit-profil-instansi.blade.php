<div>
    <form wire:submit.prevent="update"
        class="m-auto w-full p-4 bg-transparent shadow-lg rounded-lg flex flex-col gap-4 backdrop-blur-sm text-sky-500 text-xl"
        enctype="multipart/form-data">

        <div>
            <label for="nama_instansi" class="mb-1">Nama Instansi</label>
            <input type="text" name="nama_instansi" id="nama_instansi" wire:model="nama_instansi"  placeholder="Masukkan nama Instansi"
                class="border rounded w-full p-2 text-slate-700 @error('nama_instansi') border-red-500 @enderror">
            @error('nama_instansi')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="email" class="mb-1">email</label>
            <input type="email" name="email" id="email" wire:model="email" placeholder="Masukkan email Lengkap"
                class="border rounded w-full p-2 text-slate-700 @error('email') border-red-500 @enderror">
            @error('email')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="phone" class="mb-1">phone</label>
            <input type="number" name="phone" id="phone" wire:model="phone" placeholder="Masukkan phone Lengkap"
                class="border rounded w-full p-2 text-slate-700 @error('phone') border-red-500 @enderror">
            @error('phone')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex flex-col">
            <label class="mb-1">Foto</label>
        
            {{-- Gambar preview --}}
            <div wire:ignore>
                <img id="preview" 
                     src="{{ $edit->image ? asset('storage/' . $edit->image) : '' }}" 
                     class="img-prev max-w-[25vw] max-h-[30vh] {{ $edit->image ? '' : 'hidden' }}" 
                     alt="Preview Gambar">
            </div>
            {{-- Input file --}}
            <input class="border-2 rounded bg-slate-200 p-1 text-slate-700 mt-2"
                name="image" id="image" wire:model="image" type="file" onchange="previewImage(event)">
        </div>
        


        <div>
            <label for="password" class="mb-1">password</label>
            <input type="password" name="password" id="password" placeholder="***********" wire:model="password"
                class="border rounded w-full p-2 text-slate-700 ">
            @error('password')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password_confirmation" class="mb-1">koniftmasi password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                placeholder="Konfirmasi password" wire:model="password_confirmation"
                class="border rounded w-full p-2 text-slate-700">

            @error('password_confirmation')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>


        <div class="flex gap-2 mt-4">
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Perbaharui</button>
            <a href="{{ route('admin.dashboard.index') }}"  wire:navigate>
                <button type="button" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Batal</button>
            </a>
        </div>
    </form>
    @if ($OpenVerifikasi)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
                <h2 class="text-xl font-semibold mb-4 text-center">Verifikasi Email</h2>
                <p class="text-center text-gray-700 mb-4">
                    Silakan verifikasi email Anda dengan memasukkan kode OTP yang telah dikirim ke
                    <strong>{{ $email }}</strong>.
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
                                dikirimm...
                            </button>
                        @endif

                        <button type="submit"
                            class="bg-blue-600  hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                            Verifikasi Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>

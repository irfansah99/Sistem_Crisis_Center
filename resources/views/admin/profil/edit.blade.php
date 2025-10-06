<x-layout>
    <x-slot:judul>{{ $judul }}</x-slot:judul>

    <form id="form-ubah-{{ $edit->id }}" action="{{ route('admin.profil.update', $edit->id) }}" method="POST"
        class="m-auto w-full p-4 bg-transparent shadow-lg rounded-lg flex flex-col gap-4 backdrop-blur-sm text-sky-500 text-xl"
        enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div>
            <label for="name" class="mb-1">Username</label>
            <input type="text" name="name" id="name" value="{{ old('name', $edit->name) }}"
                placeholder="Masukkan nama Lengkap"
                class="border rounded w-full p-2 text-slate-700 @error('name') border-red-500 @enderror">
            @error('name')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="email" class="mb-1">email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $edit->email) }}"
                placeholder="Masukkan email Lengkap"
                class="border rounded w-full p-2 text-slate-700 @error('email') border-red-500 @enderror">
            @error('email')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="phone" class="mb-1">phone</label>
            <input type="number" name="phone" id="phone" value="{{ old('phone', $edit->phone) }}"
                placeholder="Masukkan phone Lengkap"
                class="border rounded w-full p-2 text-slate-700 @error('phone') border-red-500 @enderror">
            @error('phone')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex flex-col">
            <label class="mb-1">Foto</label>
            <input type="hidden" name="fotoold" value="{{ $edit->image }}">
            <img src="{{ $edit->image ? asset('storage/' . $edit->image) : '' }}"
                class="img-prev w-1/2 {{ $edit->image ? '' : 'hidden' }}" alt="Preview Gambar">
            <input class="border-2 rounded bg-slate-200 p-1 text-slate-700 mt-2" name="image" id="image"
                type="file" onchange="previewimg()">
        </div>


        <div>
            <label for="password" class="mb-1">password</label>
            <input type="password" name="password" id="password" placeholder="***********"
                class="border rounded w-full p-2 text-slate-700 ">
            @error('password')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password_confirmation" class="mb-1">koniftmasi password</label>
            <input type="password_confirmation" name="password_confirmation" id="password_confirmation" placeholder="confirm"
                class="border rounded w-full p-2 text-slate-700 ">
            @error('password_confirmation')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>


        <div class="flex gap-2 mt-4">
            <button onclick="konfirmasiperbarui({{ $edit->id }})" type="button"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Perbaharui</button>
            <a href="{{ url()->previous() }}">
                <button type="button" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Batal</button>
            </a>
        </div>
    </form>
    <x-sweet-alert />

    <script>
        function previewimg() {
            const image = document.querySelector('#image');
            const imgprev = document.querySelector('.img-prev');

            imgprev.classList.remove('hidden');

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgprev.src = oFREvent.target.result;
            }
        }
    </script>
</x-layout>

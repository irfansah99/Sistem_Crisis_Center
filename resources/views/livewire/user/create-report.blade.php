<div>
    <form 
        class="m-auto w-9/12 h-auto p-4 bg-transparent shadow-lg rounded-lg flex flex-col gap-4 text-slate-500 text-xl" 
        wire:submit.prevent="simpan"
        enctype="multipart/form-data"
    >
        @csrf

        <!-- Judul -->
        <div class="flex flex-col">
            <label for="judul">Judul Laporan</label>
            <input
                type="text"
                id="judul"
                wire:model="judul"
                class="border-2 rounded bg-slate-200 p-1 text-slate-700"
                placeholder="Masukkan judul laporan"
            >
        </div>
        @error('judul') 
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror 

        <!-- Deskripsi -->
        <div class="flex flex-col">
            <label for="deskripsi">Deskripsi</label>
            <textarea
                id="deskripsi"
                wire:model="deskripsi"
                class="border-2 rounded bg-slate-200 p-1 text-slate-700"
                placeholder="Masukkan deskripsi laporan"
            ></textarea>
        </div>
        @error('deskripsi') 
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror 

        <!-- Kategori -->
        <div class="flex flex-col">
            <label for="kategori">Kategori</label>
            <select wire:model="kategori" id="kategori" class="border-2 rounded bg-slate-200 p-1 text-slate-700">
                <option value="">-- Pilih kategori --</option>
                <option value="Bencana Alam">Bencana Alam</option>
                <option value="Kecelakaan">Kecelakaan</option>
                <option value="Kebakaran">Kebakaran</option>
                <option value="Kriminalitas">Kriminalitas</option>
            </select>
        </div>
        @error('kategori') 
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror 

        <!-- Lokasi -->
        <div class="flex flex-col">
            <label for="lokasi">Lokasi Kejadian</label>
            <input
                type="text"
                id="lokasi"
                wire:model="lokasi"
                class="border-2 rounded bg-slate-200 p-1 text-slate-700"
                placeholder="Masukkan lokasi laporan"
            >
        </div>
        @error('lokasi') 
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror 

        <!-- Foto -->
        <div class="flex flex-col">
            <label for="foto">Bukti Kejadian (opsional)</label>

            @if ($foto)
                <img src="{{ $foto->temporaryUrl() }}" class="w-1/2" alt="Preview Gambar">
            @endif

            <input
                type="file"
                id="foto"
                wire:model="foto"
                class="border-2 rounded bg-slate-200 p-1 text-slate-700"
            >
        </div>
        @error('foto') 
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror 

        <!-- Button -->
        <div class="text-center mt-4 flex gap-2 justify-center mx-auto">
            <button 
                type="submit"
                class="bg-blue-500 w-min p-2 text-white px-4 py-2 rounded hover:scale-105 hover:bg-indigo-500 duration-300"
            >
                Kirim
            </button>
            <a href="{{ route('beranda.index') }}">
                <button 
                    type="button" 
                    class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 transition"
                >
                    Batal
                </button>
            </a>
        </div>
    </form>
</div>

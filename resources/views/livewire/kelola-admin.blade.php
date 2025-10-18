<div>
    
    <div class="flex justify-between mb-2">
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
            <button type="button" wire:click="Tammbah"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md shadow">
                Tambah Admin
            </button>
    </div>
    <table class="min-w-full border-2 border-gray-300 rounded-lg shadow-sm text-sm text-left table-auto mt-10">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border-2">No</th>
                <th class="px-4 py-2 border-2">Name</th>
                <th class="px-4 py-2 border-2">Email</th>
                <th class="px-4 py-2 border-2">No hp</th>
                <th class="px-4 py-2 border-2">Role</th>
                <th class="px-4 py-2 border-2">Bergabung pada</th>
                <th class="px-4 py-2 border-2">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($admin  as $key => $row)
                <tr>
                    <td class="px-4 py-2 border-2">{{ $admin->firstItem() + $key }}</td>
                    <td class="px-4 py-2 border-2">{{ $row->name }}</td>
                    <td class="px-4 py-2 border-2">{{ $row->email }}</td>
                    <td class="px-4 py-2 border-2">{{ $row->phone }}</td>
                    <td class="px-4 py-2 border-2">{{ $row->role === 'superadmin'? 'Super Admin' : 'Admin' }}</td>
                    <td class="px-4 py-2 border-2">{{ $row->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-2 border-2 text-center">
                        <button wire:click="OpenModal({{ $row->id }})"
                            class="px-2 py-1 bg-yellow-500 hover:bg-yellow-700 text-white rounded">
                            Detail
                        </button>
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
        {{ $admin->links() }}
    </div>
    @if ($Open)
    <div class="fixed inset-0  bg-black/50 backdrop-blur-sm flex justify-center items-center z-50">
        <div class="max-w-3xl w-full mx-auto bg-white shadow-lg rounded-lg  space-y-4 max-h-[90vh] overflow-y-auto pb-4">
            <div class="flex justify-between items-center px-5 py-3 border-b bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-800">
                    Detail Admin
                </h2>
                <button 
                wire:click="back"
                    class="text-gray-500 hover:text-gray-700 transition"
                >
                    ✕
                </button>
            </div>
            <div class="flex flex-col md:flex-row gap-6 p-6">
                <div class="flex flex-col items-center md:items-start">
                    @if ($detail->image)
                        <img class="w-64 h-64 rounded object-cover"
                            src="{{ asset('storage/' . $detail->image) }}" alt="Profil">
                    @else
                        <img class="w-64 h-64 rounded object-cover" src="{{ url('image/nophoto.jpg') }}" alt="Profil Default">
                    @endif
    
                </div>
    
                {{-- Detail Admin --}}
                <ul class="flex-1 space-y-3">
                    <li class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <span class="font-semibold w-40">Nama</span>
                        <div class="text-gray-800">: {{ $detail->name }}</div>
                    </li>
    
                    <li class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <span class="font-semibold w-40">Email</span>
                        <div class="text-gray-800">: {{ $detail->email }}</div>
                    </li>
    
                    <li class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <span class="font-semibold w-40">No. Telepon</span>
                        <div class="text-gray-800">: {{ $detail->phone }}</div>
                    </li>
    
                    <li class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <span class="font-semibold w-40">Role</span>
                        <select name="role" wire:change="updateRole({{ $detail->id }}, $event.target.value)"
                            class="border rounded p-1">: 
                            <option value="admin" {{ $detail->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="superadmin" {{ $detail->role == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                    </li>
                    <li class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <span class="font-semibold w-40">Bergabung sejak</span>
                        <div class="text-gray-800">: {{ $detail->created_at->format('d M Y') }}</div>
                    </li>
                </ul>
            </div>
    
            <div class="flex justify-end mt-4 mr-2">
                <button wire:click="deleteUser({{ $detail->id }})"
                    class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-700 transition">
                    Hapus Akun Ini
                </button>
            </div>
    
        </div>
    </div>
    

    @endif

    @if ($OpenTambah)
    <div class="fixed inset-0  bg-black/50 backdrop-blur-sm  flex justify-center items-center z-50">
        <div class="max-w-3xl w-full mx-auto bg-white shadow-lg rounded-lg p-6 space-y-4 max-h-[90vh] overflow-y-auto">
            <form wire:submit.prevent="create"
            class="relative flex flex-col gap-4">

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
                        placeholder="Masukkan password" required autocomplete="off"
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
                        name="password_confirmation" placeholder="Ulangi password" required
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
            <div class="flex gap-4 justify-center items-center">
                <button wire:click='tutup' type="button" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-700 transition transform hover:-translate-y-1 hover:scale-105 ">Back</button>
                <input
                class=" bg-blue-500 text-white px-4 py-2 rounded hover:bg-indigo-500 transition transform hover:-translate-y-1 hover:scale-105 active:bg-red-600"
                type="submit" value="create">

            </div>

    
        </form>
         
    
        </div>
    </div>
    

    @endif
</div>

<html lang="en" class="h-full bg-gray-100">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://unpkg.com/alpinejs" defer></script>
        <title>Registrasi</title>
        <link rel="icon"  href="https://mpp.palembang.go.id/static/logo/1661781006.png" />    <link rel="icon"  href="https://mpp.palembang.go.id/static/logo/1661781006.png" />
        @vite('resources/css/app.css')
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body >
        <div class="relative flex justify-center items-center min-h-screen w-full before:content-[''] before:absolute before:inset-0 before:bg-[url('https://utara.jakarta.go.id/portal/pages/1724290355_e73629dee7544639c88f.jpeg')] before:bg-cover before:bg-no-repeat before:blur-sm before:z-0">
            <form action="/register" method="POST" class="relative z-10 space-y-5 bg-white/70 backdrop-blur-md shadow-lg rounded-xl p-6 w-full max-w-[70%] lg:max-w-[40%]">
                @csrf
                <img src="https://mpp.palembang.go.id/static/logo/1661781006.png" alt="logo" class="w-24 mx-auto my-3">
                <h1 class="text-2xl font-semibold text-gray-700 text-center">Aplikasi Pembayaran Listrik Pascabayar</h1>
                @if (session('loginerror'))
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                    {{ session('loginerror') }}
                </div>
            @endif
                <div class="flex flex-col">
                    <label class="block text-gray-700 mb-1">username</label>
                    <input class="border-2 rounded bg-white p-1 @error('name') is-invalid @enderror"
                    type="text"
                    name="name"
                    placeholder="Masukan username"
                    value="{{ old('name') }}"
                    required autocomplete="off">
             
                    @error('name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <label class="block text-gray-700 mb-1">email</label>
                    <input class="border-2 rounded bg-white p-1 @error('email') is-invalid @enderror" type="text" placeholder="Masukan nama lengkap" name="email" value="{{ old('email') }}" required autocomplete="off"
                    >
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <label class="block text-gray-700 mb-1">Alamat</label>
                    <input class="border-2 rounded bg-white p-1 @error('address') is-invalid @enderror" type="text" placeholder="Masukan nama lengkap" name="address" value="{{ old('address') }}" required autocomplete="off"
                    >
                    @error('address')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <label class="block text-gray-700 mb-1">nomor Handphone</label>
                    <input class="border-2 rounded bg-white p-1 @error('phone') is-invalid @enderror"
                    type="text"
                    name="phone"
                    placeholder="Masukan phone"
                    value="{{ old('phone') }}"
                    required autocomplete="off">
             
                    @error('phone')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div x-data="{ show: false }" class="relative flex flex-col">
                    <label class="block text-gray-700 mb-1">Password</label>
                    <input
                        :type="show ? 'text' : 'password'"
                        class="border-2 rounded bg-white p-1 pr-10 @error('password') border-red-500 @enderror"
                        placeholder="Masukan password"
                        name="password"
                        required
                        autocomplete="off"
                    >
                    <i
                        :class="show ? 'fa fa-eye' : 'fa fa-eye-slash'"
                        class="absolute right-3 top-9 cursor-pointer text-gray-500"
                        @click="show = !show"
                    ></i>
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                
                <div x-data="{ showConfirm: false }" class="relative flex flex-col">
                    <label class="block text-gray-700 mb-1">Konfirmasi Password</label>
                    <input
                        :type="showConfirm ? 'text' : 'password'"
                        class="border-2 rounded bg-white p-1 pr-10 @error('password_confirmation') border-red-500 @enderror"
                        placeholder="Ulangi password"
                        name="password_confirmation"
                        required
                        autocomplete="off"
                    >
                    <i
                        :class="showConfirm ? 'fa fa-eye' : 'fa fa-eye-slash'"
                        class="absolute right-3 top-9 cursor-pointer text-gray-500"
                        @click="showConfirm = !showConfirm"
                    ></i>
                    @error('password_confirmation')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                
                
        
                <input class="block bg-blue-500 text-white px-4 py-2 rounded mx-auto hover:bg-indigo-500 transition transform hover:-translate-y-1 hover:scale-105 active:bg-red-600" type="submit" value="Submit">

                <div class="text-center mt-4 text-sm">
                    Sudah punya akun? 
                    <a href="/login" class="text-blue-500 hover:underline">Login</a>
                </div>
            </form>
        </div>
        

    

    </body>
    </html>
    
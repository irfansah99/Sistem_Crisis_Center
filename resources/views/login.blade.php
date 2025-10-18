<html lang="en" class="h-full bg-gray-100">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://unpkg.com/alpinejs" defer></script>
        <title>Login</title>
        <link rel="icon" href="{{ asset('image/logo.png') }}" type="image/png">
        @vite('resources/css/app.css')
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body >
        <div class="relative flex justify-center items-center min-h-screen w-full before:content-[''] before:absolute before:inset-0 before:bg-[url('https://asset.kompas.com/crops/jZavvc2_23rHDJzJUzILa3WMBlE=/0x0:0x0/750x500/data/photo/2024/10/27/671d7d4fe0d8d.jpg')] before:bg-cover before:bg-no-repeat before:blur-sm before:z-0">
            <form action="/login" method="POST" class="relative z-10 space-y-5 bg-white/70 backdrop-blur-md shadow-lg rounded-xl p-6 w-full max-w-sm">
                @csrf
                <img src="image/logo.png" alt="logo" class="w-24 mx-auto my-3">
                <h1 class="text-2xl font-semibold text-gray-700 text-center">Sistem Pelaporan Cepat dan Penanganan Insiden</h1>
                @if (session('loginerror'))
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                    {{ session('loginerror') }}
                </div>
            @endif
                <div class="flex flex-col">
                    <label class="block text-gray-700 mb-1">email</label>
                    <input class="border-2 rounded bg-white p-1 @error('email') is-invalid @enderror" type="text" placeholder="Masukan email" name="email" value="{{ old('email') }}" required autocomplete="off"
                    >
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
        
                <div x-data="{ show: false }" class="relative flex flex-col">
                    <label class="block text-gray-700 mb-1">Password</label>
                    <input
                        :type="show ? 'text' : 'password'"
                        class="border-2 rounded bg-white p-1 pr-10"
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
                </div>
        
                <input class="block bg-blue-500 text-white px-4 py-2 rounded mx-auto hover:bg-indigo-500 transition transform hover:-translate-y-1 hover:scale-105 active:bg-red-600" type="submit" value="Log in">

                <div class="mt-4 text-sm">
                    Belum punya akun? 
                    <a href="/register" class="text-blue-500 hover:underline">Daftar</a>
                </div>
                
            </form>

        </div>
        

    
        <x-sweet-alert />
    </body>
    </html>
    
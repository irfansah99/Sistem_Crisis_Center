<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://unpkg.com/alpinejs" defer></script>
    <title>Registrasi</title>
    <link rel="icon" href="{{ asset('image/logo.png') }}" type="image/png">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />

</head>

<body>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white px-5 py-3 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4 text-center">Verifikasi Email</h2>


            <form action="{{ route('verifikasi.proses') }}" method="POST">
                @csrf
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded mb-3">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-4">
                    <input type="text" name="otp" id="otp" maxlength="6" placeholder="Masukan kode otp"
                        class="w-full border-gray-300 bg-slate-100 rounded-md mt-1 px-2 py-1 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('otp')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex gap-5 justify-center mb-3">
                    <button type="submit" class=" bg-yellow-500 hover:bg-blue-700 text-white py-2 rounded transition px-2">
                        Kirim Ulang
                    </button>
                    <button  class=" bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition px-2">
                        Verifikasi Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>



</body>

</html>

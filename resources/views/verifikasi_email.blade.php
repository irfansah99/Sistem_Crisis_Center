<html lang="en" class="h-full bg-gray-100">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Registrasi</title>
        <link rel="icon"  href="https://mpp.palembang.go.id/static/logo/1661781006.png" />    <link rel="icon"  href="https://mpp.palembang.go.id/static/logo/1661781006.png" />
        @vite('resources/css/app.css')
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </head>
    <body >
        @section('content')
        <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
            <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
                <h2 class="text-xl font-semibold mb-4 text-center">Verifikasi Email</h2>
        
                @if(session('error'))
                    <div class="bg-red-100 text-red-700 px-3 py-2 rounded mb-3">
                        {{ session('error') }}
                    </div>
                @endif
        
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 px-3 py-2 rounded mb-3">
                        {{ session('success') }}
                    </div>
                @endif
        
                <form action="{{ route('verifikasi.proses') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="otp" class="block text-sm font-medium text-gray-700">Kode OTP</label>
                        <input type="text" name="otp" id="otp" maxlength="6"
                            class="w-full border-gray-300 rounded-md mt-1 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        @error('otp')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
        
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">
                        Verifikasi Sekarang
                    </button>
                </form>
            </div>
        </div>
        @endsection

    

    </body>
    </html>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - OneIn</title>
    <link rel="icon" type="image/png" href="{{ asset('images/telkom-icon.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-[#e2e2e2]">
<div id="popupMessage" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" style="display:none;">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm text-center relative"> 
        
        <div id="popupContent"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var popup = document.getElementById('popupMessage');
    var content = document.getElementById('popupContent');
    var closeButton = document.getElementById('closePopupButton'); // <-- TAMBAHAN
    var show = false;

    @if (session('error'))
        show = true;
        content.innerHTML = '<strong class="font-bold text-red-700">Error!</strong><div class="mt-2 text-red-700">{!! session('error') !!}</div>';
    @endif
    @if (session('success'))
        show = true;
        content.innerHTML = '<strong class="font-bold text-green-700">Sukses!</strong><div class="mt-2 text-green-700">{!! session('success') !!}</div>';
    @endif
    @if ($errors->any())
        show = true;
        var errorList = `<strong class="font-bold text-red-700">Error!</strong><ul class="list-disc pl-5 mt-2 text-left text-red-700">`;
        @foreach ($errors->all() as $error)
            errorList += `<li>{{ $error }}</li>`;
        @endforeach
        errorList += '</ul>';
        content.innerHTML = errorList;
    @endif

    if(show) {
        popup.style.display = 'flex';
    }

    // ==========================================================
    // === TAMBAHAN: LOGIKA UNTUK MENUTUP POP-UP ===
    // ==========================================================
    function hidePopup() {
        popup.style.display = 'none';
    }

    // 2. Menutup saat area di luar kotak putih (overlay) diklik
    popup.addEventListener('click', function(event) {
        // Cek jika elemen yang diklik adalah overlay itu sendiri
        if (event.target === popup) {
            hidePopup();
        }
    });
});
</script>
    <div class="bg-white shadow-xl rounded-2xl w-full max-w-md p-8 border-t-8 border-[#981318]">
        <!-- Judul -->
        <h2 class="text-2xl font-bold text-center text-[#981318] mb-6 tracking-wide">
            Sign in to your account
        </h2>

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" required value="{{ old('username') }}"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#981318] focus:border-[#981318]">
            </div>

            <!-- Password dengan ikon mata SVG -->
           <div class="relative mt-1">
    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
    <div class="relative flex items-center">
        <input id="password" type="password" name="password" required
               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#981318] focus:border-[#981318] pr-10"
               autocomplete="current-password">
        <button type="button" id="togglePassword"
                class="absolute right-2 flex items-center justify-center text-gray-600 hover:text-gray-800 h-full">
            <svg id="iconShow" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg id="iconHide" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 012.246-3.797M6.4 6.4L3 3m18 18l-3.4-3.4M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </button>
    </div>
</div>
            <!-- Forgot password -->
            <div class="flex justify-end">
                <a href="{{ route('password.request') }}" class="text-sm text-[#981318] hover:underline">Forgot Password?</a>
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full bg-[#981318] text-white py-2 rounded-md hover:bg-red-800 transition">
                Sign in
            </button>
        </form>
    </div>

    <!-- Script toggle password -->
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const iconShow = document.getElementById('iconShow');
        const iconHide = document.getElementById('iconHide');

        togglePassword.addEventListener('click', function (e) {
            e.preventDefault();
            if (password.type === 'password') {
                password.type = 'text';
                iconShow.classList.add('hidden');
                iconHide.classList.remove('hidden');
            } else {
                password.type = 'password';
                iconShow.classList.remove('hidden');
                iconHide.classList.add('hidden');
            }
        });
    </script>

</body>
</html>

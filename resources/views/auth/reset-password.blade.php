<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reset Password - OneIn</title>
        <link rel="icon" type="image/png" href="{{ asset('images/telkom-icon.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
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
    <body class="min-h-screen flex items-center justify-center bg-[#e2e2e2]">
        <div class="bg-white shadow-xl rounded-lg w-full max-w-md p-8 border border-gray-300">
            <h2 class="text-2xl font-bold text-center text-[#981318] py-1 mb-6">
                Set New Password
            </h2>
            
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <label for="password" class="block text-sm text-gray-600 mb-1">New Password</label>
                <div class="relative mb-3">
                    <input id="password" type="password" name="password" placeholder="New Password" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-black focus:outline-none focus:ring-2 focus:ring-[#981318] focus:border-[#981318] pr-10">
                    <button type="button" onclick="togglePassword('password', this)" tabindex="-1" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 focus:outline-none">
                        <svg id="icon-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>

                <label for="password_confirmation" class="block text-sm text-gray-600 mb-1">Confirm Password</label>
                <div class="relative mb-5">
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-black focus:outline-none focus:ring-2 focus:ring-[#981318] focus:border-[#981318] pr-10">
                    <button type="button" onclick="togglePassword('password_confirmation', this)" tabindex="-1" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 focus:outline-none">
                        <svg id="icon-password_confirmation" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>

                <button type="submit" value="Reset Password" class="w-full bg-[#981318] text-white py-2 rounded-md text-base hover:bg-red-800 transition cursor-pointer">Reset Password</button>
            </form>
            <script>
            function togglePassword(id, btn) {
                const input = document.getElementById(id);
                const icon = btn.querySelector('svg');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.innerHTML = `<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.368m3.087-2.933A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.043 5.306M15 12a3 3 0 11-6 0 3 3 0 016 0z' /><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 3l18 18' />`;
                } else {
                    input.type = 'password';
                    icon.innerHTML = `<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z' /><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z' />`;
                }
            }
            </script>
        </div>
    </body>
</html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forgot Password - OneIn</title>
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
                Get Reset OTP
            </h2>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.sendOtp') }}" class="space-y-5">
                @csrf
                <p class="text-sm text-gray-600 text-justify" >
                    Masukan ID Telegram Anda, dan kode OTP untuk reset password akan dikirimkan langsung ke akun Anda.
                </p>

                <input type="text" name="id_telegram" placeholder="ID Telegram" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-black focus:outline-none focus:ring-2 focus:ring-[#981318] focus:border-[#981318]">

                <button type="submit" class="w-full bg-[#981318] text-white py-2 rounded-md text-base hover:bg-red-800 transition cursor-pointer">
                    Send Reset OTP
                </button>
            </form>
        </div>
    </body>
</html>
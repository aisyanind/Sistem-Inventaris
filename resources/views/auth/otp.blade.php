<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification - OneIn</title>
    <link rel="icon" type="image/png" href="{{ asset('images/telkom-icon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
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
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg w-full max-w-md p-8 border border-[#e2e2e2]">
        <h2 class="text-2xl font-bold text-center text-[#981318] mb-6">Verifikasi OTP</h2>

        {{-- Info user / pesan --}}
        @auth
            <p class="text-center text-gray-600 mb-4">
                Halo, <span class="font-semibold">{{ Auth::user()->name }}</span> <br>
                Masukkan kode Anda
            </p>
        @else
            <p class="text-center text-gray-600 mb-4">
                Masukkan kode Anda
            </p>
        @endauth

        {{-- Form OTP --}}
        <form method="POST" action="{{ route('otp.login.verify') }}" class="space-y-5">
            @csrf
            <div>
                <label for="otp" class="block text-sm font-medium text-gray-700">One-time code</label>
                <input type="text" name="kode_otp" id="otp" maxlength="6"
                    class="mt-1 w-full border-b-2 border-[#e2e2e2] focus:border-[#981318] outline-none py-2 text-center tracking-widest text-lg"
                    placeholder="••••••" required>
            </div>

            <button type="submit"
                class="w-full bg-[#981318] text-white py-2 rounded-md hover:bg-red-700 transition">
                Verifikasi
            </button>
        </form>
    </div>

</body>
</html>
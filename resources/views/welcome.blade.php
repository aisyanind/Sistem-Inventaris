<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>OneIn</title>
        <link rel="icon" type="image/png" href="{{ asset('images/telkom-icon.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex items-center justify-center min-h-screen flex-col bg-[#e2e2e2] w-full gap-0">
        <main class="flex w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
            <div class="flex-1 p-10 lg:px-18 lg:py-20 bg-[#981318] text-white text-justify shadow-xl rounded-b-lg lg:rounded-l-2xl lg:rounded-r-none flex flex-col justify-center">
                <h1 class="mb-1 font-medium text-xl">Selamat Datang di Sistem Inventaris TIF!</h1>
                <p class="mb-2 text-sm">Kelola dan pantau data perangkat infrastruktur jaringan dengan lebih mudah, cepat, dan terorganisir.<br><br><br><br><br></p>
                <form action="{{ route('welcome.login') }}">
                    <button type="submit" class="w-full p-2 bg-white text-black rounded-md text-base font-medium hover:bg-gray-200 transition">
                        Login
                    </button>
                </form>
            </div>
            <div class="flex-1 p-10 lg:py-10 bg-white rounded-t-lg shadow-xl lg:rounded-r-2xl lg:rounded-l-none flex items-center justify-center border border-gray-300">
                <img
                    src="{{ asset('images\telkom-logo.png') }}"
                    alt="Sistem Inventarisasi Perangkat Infrastruktur Jaringan Telkom Infrastruktur Indonesia"
                    class="w-full h-full object-contain">
            </div>
        </main>
    </body>
</html>
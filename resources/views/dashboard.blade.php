<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - OneIn</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/telkom-icon.png') }}">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #981318; /* Sesuaikan warna navbar */
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 15px;
        }
        .navbar a:hover {
            background-color: #7c0f14;
            border-radius: 5px;
        }
        .container {
            padding: 30px 20px;
        }
        .card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .card h3 {
            color: #981318; /* Warna utama */
        }
        .card p {
            color: #2d3748;
            font-size: 16px;
        }
        footer {
            background-color: #981318; /* Warna footer sesuai tema */
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="card">
            <!-- Pesan Selamat Datang -->
            @if ($user->is_admin)
                <h3>Selamat datang, Admin!</h3>
            @else
                <h3>Selamat datang, Teknisi!</h3>
            @endif
        </div>

        <!-- Form Logout -->
        <div class="card">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2 px-4 py-2 text-sm font-medium text-black 
                    hover:text-red-600 transition-colors rounded-md focus:outline-none"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25a.75.75 0 00-.75-.75h-9a.75.75 0 00-.75.75v13.5a.75.75 0 00.75.75h9a.75.75 0 00.75-.75V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 OneIn - All Rights Reserved</p>
    </footer>

</body>
</html>

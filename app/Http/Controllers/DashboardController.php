<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mendapatkan informasi pengguna yang sedang login
        $user = Auth::user();

        // Mengirim data pengguna ke tampilan
        return view('dashboard', compact('user'));
    }
}

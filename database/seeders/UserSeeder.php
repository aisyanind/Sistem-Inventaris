<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [ // User pertama
                'nama' => 'Super Admin',
                'username' => 'admin',
                'password' => Hash::make('password123'),
                'id_telegram' => '1255103352',
                'is_admin' => true,
            ],
            [ // User kedua
                'nama' => 'Teknisi',
                'username' => 'teknisi',
                'password' => Hash::make('password123'),
                'id_telegram' => '1179460230',
                'is_admin' => false,
            ]
        ]);
    }
}
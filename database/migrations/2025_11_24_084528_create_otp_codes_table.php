<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otp', function (Blueprint $table) {
            $table->id('id_user'); // id_user jadi primary key
            $table->string('kode_otp', 6); 
            $table->timestamp('berlaku_sampai')->nullable();
            $table->boolean('sudah_digunakan')->default(false);

            // Relasi ke tabel users
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otp');
    }
};

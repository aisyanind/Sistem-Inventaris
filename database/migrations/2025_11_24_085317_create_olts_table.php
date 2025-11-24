<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void 
    {
        Schema::create('olt', function (Blueprint $table) {
            $table->id('id_olt')->comment('Primary Key');
            $table->string('hostname_olt', 255)->unique();
            $table->string('ip_address', 45)->unique();
            $table->string('alamat', 255);
            $table->string('lokasi', 255);
            $table->decimal('longitude', 11, 8);
            $table->decimal('latitude', 11, 8);
            $table->string('foto_olt', 255)->nullable();
            $table->string('foto_rak', 255)->nullable();
            $table->string('foto_topologi', 255)->nullable();
            $table->string('jenis_pembayaran', 50);
            $table->string('id_pln', 50);
            $table->string('pic_pln', 255);
            $table->string('source', 50);
            $table->unsignedInteger('vlan');
            $table->unsignedInteger('core_idle');

            $table->unique(['hostname_olt', 'ip_address'], 'unique_hostname_ip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('olt');
    }
};

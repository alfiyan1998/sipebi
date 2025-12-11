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
        Schema::create('tb_penggunaan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_list')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->date('tanggal_penggunaan');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status', ['Diajukan', 'Digunakan', 'Selesai']);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_penggunaan');
    }
};

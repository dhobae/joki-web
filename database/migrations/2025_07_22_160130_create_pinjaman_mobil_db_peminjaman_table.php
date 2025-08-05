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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_mobil');
            
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_pengembalian')->nullable();
            $table->enum('status_peminjaman', ['dipinjam', 'dikembalikan']);
            $table->text('bukti_pengembalian')->nullable();
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_mobil')->references('id')->on('mobil')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};

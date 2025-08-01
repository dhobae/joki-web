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
        Schema::create('mobil', function (Blueprint $table) {
            $table->id();
            $table->string('plat_mobil', 15)->unique();

            $table->unsignedBigInteger('id_merk');
            $table->unsignedBigInteger('id_jenis');

            $table->string('model', 200);
            $table->integer('kapasitas');
            $table->text('foto_mobil')->nullable();
            $table->text('catatan_lain')->nullable();
            $table->enum('status_mobil', ['Tersedia', 'Tidak Tersedia']);
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('id_merk')->references('id')->on('merk')->onDelete('cascade');
            $table->foreign('id_jenis')->references('id')->on('jenis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Foreign key ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Foreign key ke tabel rooms
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->dateTime('checkin_date');
            $table->dateTime('checkout_date');
            $table->integer('person_number');
            $table->enum('status', ['pending', 'used', 'done', 'canceled'])->default('pending');
            $table->enum('repeat_schedule', ['none', 'daily', 'weekly', 'monthly'])->default('none');
            $table->text('repeat_weekly')->nullable();
            $table->text('repeat_monthly')->nullable();
            $table->string('title', 100);
            $table->text('description');
            $table->enum('type', ['internal', 'eksternal']);
            $table->boolean('fullday')->default(0); // tinyint(1)
            $table->enum('confirmation_status', ['tentative', 'confirmed'])->default('tentative'); // konfirmasi dari admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};

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
        Schema::create('mutasi_obats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('daftar_obats_id');
            $table->foreign('daftar_obats_id')->references('id')->on('daftar_obats');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            // jenis (Enum: 'masuk', 'keluar')
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->integer('jumlah')->unsigned();
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_obats');
    }
};

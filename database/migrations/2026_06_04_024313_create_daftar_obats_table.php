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
        Schema::create('daftar_obats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_obats_id');
            $table->foreign('kategori_obats_id')->references('id')->on('kategori_obats');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('kode_obat',20)->unique();
            $table->string('nama_obat',150);
            $table->integer('stok')->unsigned()->default(0);
            $table->string('satuan',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_obats');
    }
};

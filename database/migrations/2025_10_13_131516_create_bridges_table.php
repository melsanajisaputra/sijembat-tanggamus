<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bridges', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->string('lokasi');
            $table->string('kecamatan');
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->float('panjang')->nullable();
            $table->float('lebar')->nullable();
            $table->year('tahun')->nullable();
            $table->enum('kondisi', ['Baik', 'Sedang', 'Rusak Ringan', 'Rusak Berat']);
            $table->text('deskripsi')->nullable();
            $table->string('foto_depan')->nullable();
            $table->string('foto_belakang')->nullable();
            $table->string('foto_kanan')->nullable();
            $table->string('foto_kiri')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bridges');
    }
};

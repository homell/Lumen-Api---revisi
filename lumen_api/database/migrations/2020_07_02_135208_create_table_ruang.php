<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRuang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruang', function (Blueprint $table) {
            $table->integer('nomor', 10);
            $table->string('ruang');
            $table->string('keterangan');
            $table->integer('kepala');
            $table->integer('asisten');
            $table->integer('teknisi');
            $table->integer('jurusan');
            $table->string('homepage');
            $table->string('email');
            $table->string('username');
            $table->string('password');
            $table->string('kode');
            $table->integer('telp');
            $table->string('tender');
            $table->integer('is_ruang_kuliah');
            $table->integer('kapasitas_mahasiswa');
            $table->string('pemakai');
            $table->integer('teknisi3');
            $table->integer('teknisi4');
            $table->integer('teknisi5');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ruang');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->integer('nomor', 20);
            $table->integer('program')->nullable();
            $table->integer('jurusan')->nullable();
            $table->integer('kelas')->nullable();
            $table->string('paralel')->nullable();
            $table->string('kode')->nullable();
            $table->string('kode_kelas_absen')->nullable();
            $table->string('kode_epsbed')->nullable();
            $table->string('konsentrasi')->nullable();
            $table->integer('wali_kelas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelas');
    }
}

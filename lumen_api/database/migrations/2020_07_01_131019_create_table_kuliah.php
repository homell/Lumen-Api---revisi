<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKuliah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah', function (Blueprint $table) {
            $table->integer('nomor', 20);
            $table->integer('tahun')->nullable();
            $table->integer('semester')->nullable();
            $table->integer('kelas')->nullable();
            $table->integer('matakuliah')->nullable();
            $table->string('hari')->nullable();
            $table->time('jam')->nullable();
            $table->integer('ruang')->nullable();
            $table->integer('dosen')->nullable();
            $table->integer('asisten')->nullable();
            $table->string('kehadiran')->nullable();
            $table->date('tglujian')->nullable();
            $table->integer('ruangujian')->nullable();
            $table->date('tglnilai')->nullable();
            $table->string('ip_pc')->nullable();
            $table->string('host_pc')->nullable();
            $table->string('user_pc')->nullable();
            $table->string('prosenq1')->nullable();
            $table->string('prosenq2')->nullable();
            $table->string('prosent')->nullable();
            $table->string('prosenu')->nullable();
            $table->integer('kunci')->nullable();
            $table->integer('publik')->nullable();
            $table->integer('teknisi')->nullable();
            $table->integer('hari_2')->nullable();
            $table->time('jam_2')->nullable();
            $table->integer('asisten_2')->nullable();
            $table->integer('teknisi_2')->nullable();
            $table->integer('ruang_2')->nullable();
            $table->integer('dosen_2')->nullable();
            $table->integer('dosen_3')->nullable();
            $table->integer('dosen_4')->nullable();
            $table->integer('dosen_5')->nullable();
            $table->integer('prosen_kuis')->nullable();
            $table->integer('prosen_prak')->nullable();
            $table->string('hari_3')->nullable();
            $table->time('jam_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kuliah');
    }
}

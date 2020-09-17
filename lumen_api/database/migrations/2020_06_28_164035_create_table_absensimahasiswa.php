<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAbsensimahasiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_mahasiswa', function (Blueprint $table) {
            $table->integer('nomor', 20);
            $table->integer('kuliah')->nullable();
            $table->integer('mahasiswa')->nullable();
            $table->integer('minggu')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('keterangan', 50)->nullable();
            $table->string('status', 10)->nullable();
            $table->string('pengganti', 1)->nullable();
            $table->integer('dosen')->nullable();
            $table->integer('hari_pengganti')->nullable();
            $table->date('tanggal_entry')->nullable();
            $table->integer('telat')->nullable();
            $table->integer('server')->nullable();
            $table->integer('pegawai')->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->integer('jam_pengajar')->nullable();
            $table->integer('dosen_pengajar')->nullable();
            $table->integer('teknisi_pengajar1')->nullable();
            $table->integer('teknisi_pengajar2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi_mahasiswa');
    }
}

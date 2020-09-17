<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAbsensimhsminggu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_mhs_minggu', function (Blueprint $table) {
            $table->integer('nomor', 10);
            $table->integer('kelas')->nullable();
            $table->string('tahun_ajaran', 10)->nullable();
            $table->integer('semester')->nullable();
            $table->date('tanggal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi_mhs_minggu');
    }
}

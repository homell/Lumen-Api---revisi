<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMatakuliah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matakuliah', function (Blueprint $table) {
            $table->integer('nomor', 20);
            $table->integer('program')->nullable();
            $table->integer('jurusan')->nullable();
            $table->integer('kelas')->nullable();
            $table->integer('semester')->nullable();
            $table->string('kode')->nullable();
            $table->string('matakuliah')->nullable();
            $table->time('jam')->nullable();
            $table->integer('sks')->nullable();
            $table->integer('mk_group')->nullable();
            $table->integer('mk_wajib')->nullable();
            $table->integer('tahun')->nullable();
            $table->string('matakuliah_inggris')->nullable();
            $table->string('matakuliah_singkatan')->nullable();
            $table->integer('tanggal_mulai_efektif')->nullable();
            $table->integer('tanggal_akhir_efektif')->nullable();
            $table->integer('matakuliah_jenis')->nullable();
            $table->integer('masuk_penilaian')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matakuliah');
    }
}

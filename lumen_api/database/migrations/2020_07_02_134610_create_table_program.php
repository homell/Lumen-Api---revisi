<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program', function (Blueprint $table) {
            $table->integer('nomor', 10);
            $table->string('program');
            $table->string('keterangan');
            $table->integer('lama_studi');
            $table->integer('kode_epsbed');
            $table->string('gelar');
            $table->string('gelar_inggris');
            $table->integer('max_kelas');
            $table->string('keterangan_inggris');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program');
    }
}

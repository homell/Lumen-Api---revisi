<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableIzin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('izin', function (Blueprint $table) {
            $table->integer('izin_id', 10);
            $table->string('nrp', 20);
            $table->integer('absen_id');
            $table->text('file_upload');
            $table->string('alasan', 20);
            $table->text('keterangan');
            $table->date('tanggal');
            $table->date('sampai_tanggal');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('izin');
    }
}

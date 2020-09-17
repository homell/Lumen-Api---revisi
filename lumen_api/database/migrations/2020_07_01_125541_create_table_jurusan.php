<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableJurusan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurusan', function (Blueprint $table) {
            $table->integer('nomor', 20);
            $table->string('jurusan', 50)->nullable();
            $table->integer('kajur')->nullable();
            $table->integer('sekjur')->nullable();
            $table->string('alias', 10)->nullable();
            $table->string('jurusan_inggris')->nullable();
            $table->string('jurusan_lengkap')->nullable();
            $table->string('konsentrasi')->nullable();
            $table->char('akreditasi')->nullable();
            $table->string('sk_akreditasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jurusan');
    }
}

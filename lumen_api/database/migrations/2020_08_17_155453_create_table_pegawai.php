<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->integer('nomor', 10);
            $table->string('nip', 50)->nullable();
            $table->integer('noid')->nullable();
            $table->string('nama')->nullable();
            $table->integer('staff')->nullable();
            $table->integer('jurusan')->nullable();
            $table->string('homepage')->nullable();
            $table->string('password')->nullable();
            $table->integer('hak')->nullable();
            $table->string('username')->nullable();
            $table->string('jabatan')->nullable();
            $table->char('sex')->nullable();
            $table->integer('agama')->nullable();
            $table->string('email')->nullable();
            $table->string('alamat')->nullable();
            $table->string('notelp')->nullable();
            $table->string('golawal')->nullable();
            $table->string('golakhir')->nullable();
            $table->string('tmtcpns')->nullable();
            $table->string('tmtpns')->nullable();
            $table->string('tmtfungsional')->nullable();
            $table->string('tmtakhir')->nullable();
            $table->string('fungsional')->nullable();
            $table->string('karpeg')->nullable();
            $table->string('masakerja_tahun')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('ruang')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('tmplahir')->nullable();
            $table->date('tgllahir')->nullable();
            $table->string('shift')->nullable();
            $table->string('hp')->nullable();
            $table->string('goldarah')->nullable();
            $table->string('gelar_dpn')->nullable();
            $table->string('gelar_blk')->nullable();
            $table->string('kredit')->nullable();
            $table->string('kuma')->nullable();
            $table->string('kumb')->nullable();
            $table->string('kumc')->nullable();
            $table->string('kumd')->nullable();
            $table->string('rapat')->nullable();
            $table->string('status_kawin')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            // $table->integer('tinggi');
            // $table->integer('berat');
            // $table->string('rambut');
            // $table->string('muka');
            // $table->string('warna');
            // $table->string('ciri');
            // $table->string('cacat');
            // $table->string('hobby');
            // $table->string('alamat2');
            // $table->string('notelp2');
            // $table->string('alamat3');
            // $table->string('notelp3');
            // $table->string('manager');
            // $table->string('surat');
            // $table->string('status');
            // $table->string('akses');
            // $table->string('pangkat');
            // $table->string('rekening_bank');
            // $table->string('masakerja_bulan');
            // $table->string('level_mrc');
            // $table->string('jabatan_honorarium');
            // $table->string('status_karyawan');
            // $table->string('level_agenda');
            // $table->string('jabatan_khusus');
            // $table->string('perpus_kode_staff');
            // $table->string('dapat_uang_kinerja');
            // $table->string('dapat_uang_kehadiran');
            // $table->string('dapat_uang_makan');
            // $table->string('tmtstruktural');
            // $table->string('tmttugas_tambahan');
            // $table->string('jabatan_tugas_tambahan');
            // $table->string('kode_dosen_sk034');
            // $table->string('dosen_vedc');
            // $table->string('nip_baru');
            // $table->string('kode_smart_card');
            // $table->string('nip_lama');
            // $table->integer('program');
            // $table->string('npwp');
            // $table->string('nidn');
            // $table->string('serdos');
            // $table->string('lama_istirahat');
            // $table->string('tmt_kerja');
            // $table->string('edit_absen');
            // $table->string('dapat_remunisasi');
            // $table->string('u');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai');
    }
}

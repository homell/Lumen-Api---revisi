<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDatamahasiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datamahasiswa', function (Blueprint $table) {
            $table->integer('nomor', 10);
            $table->string('nrp', 20)->nullable();
            $table->string('nama')->nullable();
            $table->integer('kelas')->nullable();
            $table->integer('dosen_wali')->nullable();
            $table->char('status', 1)->nullable();
            $table->date('tgllahir')->nullable();
            $table->string('tmplahir')->nullable();
            $table->date('tglmasuk')->nullable();
            $table->char('dan_lain_lain', 1)->nullable();
            $table->char('jenis_kelamin', 1)->nullable();
            $table->string('warga', 10)->nullable();
            $table->integer('agama')->nullable();
            $table->string('alamat')->nullable();
            $table->string('notelp')->nullable();
            $table->string('smu')->nullable();
            $table->string('beasiswa', 30)->nullable();
            // $table->string('ayah')->nullable();
            // $table->string('kerja_ayah')->nullable();
            // $table->string('ibu')->nullable();
            // $table->string('kerja_ibu')->nullable();
            // $table->integer('penghasilan')->nullable();
            // $table->string('alamat_ortu')->nullable();
            // $table->string('notelp_ortu')->nullable();
            // $table->string('darah', 10)->nullable();
            // $table->integer('nijazah')->nullable();
            // $table->double('nun')->nullable();
            $table->string('password', 20)->nullable();
            // $table->date('tgllulus')->nullable();
            // $table->integer('lulussmu')->nullable();
            // $table->string('no_bni', 16)->nullable();
            // $table->integer('anak_ke')->nullable();
            // $table->string('id_asuransi', 20)->nullable();
            // $table->string('alamat_smu')->nullable();
            // $table->integer('penghasilan_ibu')->nullable();
            // $table->integer('jumlah_anak')->nullable();
            // $table->string('keterangan_ayah')->nullable();
            // $table->string('keterangan_ibu')->nullable();
            // $table->string('prestasi_olahraga')->nullable();
            // $table->string('tempat_kerja')->nullable();
            // $table->string('gaji_kerja', 20)->nullable();
            // $table->string('jabatan_kerja')->nullable();
            // $table->integer('hak')->nullable()->default(0);
            // $table->integer('el')->default(0)->nullable();
            // $table->string('no_pendaftaran', 20)->nullable();
            // $table->integer('jalur_daftar')->nullable();
            // $table->string('nisn')->nullable();
            // $table->string('npsn')->nullable();
            // $table->string('spp1')->nullable();
            // $table->string('spp2')->nullable();
            // $table->string('spp3')->nullable();
            // $table->string('spp4')->nullable();
            // $table->string('spp5')->nullable();
            // $table->string('spp6')->nullable();
            // $table->string('spp7')->nullable();
            // $table->string('spp8')->nullable();
            // $table->integer('angkatan')->nullable();
            // $table->integer('semester_masuk')->nullable();
            // $table->integer('mahasiswa_jalur_penerimaan')->nullable();
            // $table->string('nik')->nullable();
            // $table->string('kota_ortu', 20)->nullable();
            // $table->string('alamat_kota', 20)->nullable();
            // $table->string('subkampus', 20)->nullable();
            // $table->integer('ukt')->nullable();
            // $table->integer('sekolah')->nullable();
            // $table->string('foto')->nullable();
            // $table->string('ijazah')->nullable();
            // $table->integer('status_kawin')->nullable();
            // $table->string('ukuran_baju', 5)->nullable();
            // $table->integer('pernahpt')->nullable();
            // $table->integer('tahunmasuk_pt')->nullable();
            // $table->integer('jumlah_sks')->nullable();
            // $table->string('pt_asal')->nullable();
            // $table->integer('nunmapel')->nullable();
            // $table->integer('nijazahmapel')->nullable();
            // $table->integer('status_smu')->nullable();
            // $table->integer('jurusan_smu')->nullable();
            // $table->integer('thlahirayah')->nullable();
            // $table->string('pendidikanayah')->nullable();
            // $table->integer('thlahiribu')->nullable();
            // $table->string('pendidikanibu')->nullable();
            // $table->integer('sumberbiaya')->nullable();
            // $table->string('lembaga')->nullable();
            // $table->integer('jenis_lembaga')->nullable();
            // $table->string('jenis_tempattinggal')->nullable();
            // $table->string('transportasi')->nullable();
            // $table->string('minat')->nullable();
            // $table->integer('infopolije')->nullable();
            // $table->integer('semester')->nullable();
            // $table->integer('mahasiswa_pembiayaan')->nullable();
            // $table->integer('ijin_login')->nullable();
            // $table->string('kode_transaksi', 11)->nullable();
            // $table->integer('kirim_tagih_foto')->default(0)->nullable();
            // $table->string('nomor_ijazah')->nullable();
            // $table->integer('tanda')->nullable();
            // $table->integer('biaya_lain')->nullable();
            // $table->string('nik_ktp')->nullable();
            // $table->string('jalan')->nullable();
            // $table->string('rt', 30)->nullable();
            // $table->string('rw', 30)->nullable();
            // $table->string('kelurahan')->nullable();
            // $table->string('kecamatan')->nullable();
            // $table->string('kabupaten_kota')->nullable();
            // $table->string('propinsi')->nullable();
            // $table->string('kode_pos')->nullable();
            // $table->string('tempat_lahir_ayah')->nullable();
            // $table->string('tempat_lahir_ibu')->nullable();
            // $table->date('tanggal_lahir_ayah')->nullable();
            // $table->date('tanggal_lahir_ibu')->nullable();
            // $table->string('pendidikan_ayah')->nullable();
            // $table->string('pendidikan_ibu')->nullable();
            // $table->string('jalan_ortu')->nullable();
            // $table->string('rt_ortu', 30)->nullable();
            // $table->string('rw_ortu', 30)->nullable();
            // $table->string('kelurahan_ortu')->nullable();
            // $table->string('kecamatan_ortu')->nullable();
            // $table->string('kabupaten_kota_ortu')->nullable();
            // $table->string('propinsi_ortu')->nullable();
            // $table->string('kode_pos_ortu', 5)->nullable();
            // $table->integer('tahun_lulus')->nullable();
            // $table->integer('semester_lulus')->nullable();
            // $table->integer('feeder_wilayah')->nullable();
            // $table->string('nrp_lama', 20)->nullable();
            // $table->date('tglterbit')->nullable();
            // $table->string('blangko_ijazah')->nullable();
            // $table->string('email')->nullable();
            // $table->string('pin_pddikti')->nullable();
            // $table->string('akreditasi')->nullable();
            // $table->string('sk_akreditasi')->nullable();
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datamahasiswa');
    }
}

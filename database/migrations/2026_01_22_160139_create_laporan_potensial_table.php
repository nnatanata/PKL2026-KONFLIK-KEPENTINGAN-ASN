<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_potensial', function (Blueprint $table) {
            $table->id();
            $table->string('judul_potensial');
            $table->date('tanggal_potensial');
            $table->string('status_potensial');

            $table->string('nama_terduga');
            $table->string('divisi_terduga');

            $table->text('daftar_keluarga')->nullable();
            $table->text('kepemilikan_saham')->nullable();
            $table->text('aset_investasi')->nullable();
            $table->text('pekerjaan_lain')->nullable();
            $table->text('jabatan_lain')->nullable();
            $table->text('keanggotaan_lain')->nullable();
            $table->text('organisasi_nirlaba')->nullable();
            $table->text('rencana_pensiun')->nullable();

            $table->foreignId('pengguna_id')->constrained('pengguna');
            $table->foreignId('verifikasi_id')->nullable()->constrained('verifikasi');

            $table->timestamps();
            $table->softDeletes();

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_potensial');
    }
};
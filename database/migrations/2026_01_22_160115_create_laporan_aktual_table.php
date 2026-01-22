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
        Schema::create('laporan_aktual', function (Blueprint $table) {
            $table->id();
            $table->string('judul_aktual');
            $table->date('tanggal_aktual');
            $table->string('status_aktual');

            $table->string('nama_pelaku');
            $table->string('divisi_pelaku');
            $table->string('sumber_konflik');
            $table->text('kaitan_konflik');
            $table->text('saran_pengendalian')->nullable();

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
        Schema::dropIfExists('laporan_aktual');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('level');
            $table->string('status');
            $table->date('tanggal')->nullable();
            $table->text('komentar')->nullable();
            $table->text('rekomendasi')->nullable();

            //kolom untuk inspektorat
            $table->string('status_inspektorat')->nullable();
            $table->date('tanggal_inspektorat')->nullable();
            $table->text('komentar_inspektorat')->nullable();
            $table->text('rekomendasi_inspektorat')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi');
    }
};
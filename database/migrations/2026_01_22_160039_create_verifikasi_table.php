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
        Schema::create('verifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('level');
            $table->string('status');
            $table->date('tanggal')->nullable();
            $table->text('komentar')->nullable();
            $table->text('rekomendasi')->nullable();

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
        Schema::dropIfExists('verifikasi');
    }
};

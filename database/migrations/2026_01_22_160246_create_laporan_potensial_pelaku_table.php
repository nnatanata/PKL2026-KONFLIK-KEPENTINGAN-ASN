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
        Schema::create('laporan_potensial_pelaku', function (Blueprint $table) {
            $table->id();

            $table->string('pegawai_nip');
            $table->foreign('pegawai_nip')->references('nip')->on('pegawai');

            $table->foreignId('laporan_potensial_id')->constrained('laporan_potensial');

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
        Schema::dropIfExists('laporan_potensial_pelaku');
    }
};

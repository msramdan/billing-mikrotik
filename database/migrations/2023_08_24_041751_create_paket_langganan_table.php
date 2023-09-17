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
        Schema::create('paket_langganan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket', 255);
            $table->integer('jumlah_router');
            $table->integer('jumlah_pelanggan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paket_langganan');
    }
};

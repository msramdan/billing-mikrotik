<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan', 255);
			$table->integer('harga');
			$table->foreignId('kategori_paket_id')->nullable()->constrained('package_categories')->restrictOnUpdate()->nullOnDelete();
			$table->text('keterangan');
            $table->string('profile', 255);
			$table->enum('is_active', ['Yes', 'No']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
};

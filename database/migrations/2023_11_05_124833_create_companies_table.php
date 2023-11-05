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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan', 255);
			$table->string('nama_pemilik', 255);
			$table->string('telepon_perusahaan', 20)->nullable();
			$table->string('email')->nullable()->unique();
			$table->string('no_wa', 14);
			$table->text('alamat')->nullable();
			$table->text('deskripsi_perusahaan')->nullable();
			$table->string('logo')->nullable();
			$table->string('favicon')->nullable();
			$table->string('url_wa_gateway', 255);
			$table->string('api_key_wa_gateway', 255);
			$table->enum('is_active', ['Yes', 'No']);
			$table->text('footer_pesan_wa_tagihan')->nullable();
			$table->text('footer_pesan_wa_pembayaran')->nullable();
			$table->string('url_tripay', 255);
			$table->string('api_key_tripay', 255);
			$table->string('kode_merchant', 255);
			$table->string('private_key', 255);
			$table->foreignId('paket_id')->constrained('pakets')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('companies');
    }
};

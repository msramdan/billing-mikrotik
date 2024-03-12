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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->restrictOnUpdate()->cascadeOnDelete();
            $table->string('no_tagihan', 50);
			$table->foreignId('pelanggan_id')->nullable()->constrained('pelanggans')->restrictOnUpdate()->nullOnDelete();
            $table->string('periode', 10);
			$table->enum('metode_bayar', ['Cash', 'Transfer Bank', 'Payment Tripay'])->nullable();
            $table->foreignId('bank_account_id')->nullable()->constrained('bank_accounts')->restrictOnUpdate()->nullOnDelete();
			$table->enum('status_bayar', ['Sudah Bayar', 'Belum Bayar']);
			$table->integer('nominal_bayar');
			$table->integer('potongan_bayar');
            $table->enum('ppn', ['Yes', 'No'])->nullable();
			$table->integer('nominal_ppn');
            $table->integer('total_bayar');
			$table->dateTime('tanggal_bayar')->nullable();
			$table->dateTime('tanggal_create_tagihan');
			$table->dateTime('tanggal_kirim_notif_wa')->nullable();
            $table->text('payload_tripay')->nullable();
            $table->enum('is_send', ['Yes', 'No']);
            $table->foreignId('user_id')->nullable()->constrained('users')->restrictOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihans');
    }
};

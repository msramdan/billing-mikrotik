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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coverage_area')->nullable()->constrained('area_coverages')->restrictOnUpdate()->nullOnDelete();
			$table->foreignId('odc')->nullable()->constrained('odcs')->restrictOnUpdate()->nullOnDelete();
			$table->foreignId('odp')->nullable()->constrained('odps')->restrictOnUpdate()->nullOnDelete();
			$table->enum('no_port_odp', ['1', '2'])->nullable();
			$table->string('no_layanan', 12)->nullable();
			$table->string('nama', 255);
			$table->date('tanggal_daftar');
			$table->string('email')->unique();
			$table->string('no_wa', 15);
			$table->string('no_ktp', 50);
			$table->string('photo_ktp');
			$table->text('alamat');
			$table->string('password');
			$table->enum('ppn', ['Yes', 'No'])->nullable();
			$table->enum('status_berlangganan', ['Aktif', 'Non Aktif', 'Menungu']);
			$table->foreignId('paket_layanan')->nullable()->constrained('packages')->cascadeOnUpdate()->nullOnDelete();
			$table->integer('jatuh_tempo')->nullable();
			$table->enum('kirim_tagihan_wa', ['Yes', 'No'])->nullable();
			$table->string('latitude', 50)->nullable();
			$table->string('longitude', 50)->nullable();
			$table->enum('auto_isolir', ['Yes', 'No'])->nullable();
			$table->integer('tempo_isolir')->nullable();
			$table->foreignId('router')->nullable()->nullable()->constrained('settingmikrotiks')->restrictOnUpdate()->nullOnDelete();
			$table->string('user_pppoe', 100)->nullable();
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
        Schema::dropIfExists('pelanggans');
    }
};

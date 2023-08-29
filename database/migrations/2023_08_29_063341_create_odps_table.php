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
        Schema::create('odps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kode_odc')->nullable()->constrained('odcs')->restrictOnUpdate()->nullOnDelete();
			$table->integer('nomor_port_odc');
			$table->string('kode_odp', 50);
			$table->foreignId('wilayah_odp')->nullable()->constrained('area_coverages')->restrictOnUpdate()->nullOnDelete();
			$table->string('warna_tube_fo', 50);
			$table->integer('nomor_tiang');
			$table->integer('jumlah_port');
			$table->string('document')->nullable();
			$table->text('description');
			$table->string('latitude', 100);
			$table->string('longitude', 100);
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
        Schema::dropIfExists('odps');
    }
};

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
        Schema::create('odcs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_odc', 20);
			$table->foreignId('wilayah_odc')->nullable()->constrained('area_coverages')->restrictOnUpdate()->nullOnDelete();
			$table->integer('nomor_port_olt');
			$table->string('warna_tube_fo', 100);
			$table->integer('nomor_tiang');
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
        Schema::dropIfExists('odcs');
    }
};

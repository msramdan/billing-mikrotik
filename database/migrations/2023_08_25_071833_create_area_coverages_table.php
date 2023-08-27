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
        Schema::create('area_coverages', function (Blueprint $table) {
            $table->id();
            $table->string('kode_area', 50);
            $table->enum('tampilkan_register', ['Yes', 'No']);
            $table->string('nama', 255);
            $table->text('alamat');
            $table->text('keterangan');
            $table->integer('radius');
            $table->string('latitude', 50);
            $table->string('longitude', 50);
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
        Schema::dropIfExists('area_coverages');
    }
};

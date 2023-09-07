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
        Schema::create('sendnotifs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coverage_area')->nullable()->constrained('area_coverages')->restrictOnUpdate()->nullOnDelete();
			$table->foreignId('odc')->nullable()->constrained('odcs')->restrictOnUpdate()->nullOnDelete();
			$table->foreignId('odp')->nullable()->constrained('odps')->restrictOnUpdate()->nullOnDelete();
			$table->text('pesan');
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
        Schema::dropIfExists('sendnotifs');
    }
};

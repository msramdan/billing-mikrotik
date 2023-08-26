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
        Schema::create('dhcps', function (Blueprint $table) {
            $table->id();
            $table->string('address', 255);
			$table->string('mac_address', 255);
			$table->string('host_name', 255);
			$table->string('server', 255);
			$table->string('status', 255);
			$table->string('last_seen', 255);
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
        Schema::dropIfExists('dhcps');
    }
};

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
        Schema::create('profile_pppoes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
			$table->string('local', 255);
			$table->string('remote', 255);
			$table->string('limit', 255);
			$table->string('parent', 255);
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
        Schema::dropIfExists('profile_pppoes');
    }
};

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
        Schema::create('olts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->restrictOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->enum('type', ['Zte', 'Huawei']);
            $table->string('host');
            $table->integer('telnet_port');
            $table->string('telnet_username');
            $table->string('telnet_password');
            $table->string('snmp_port');
            $table->string('ro_community');
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
        Schema::dropIfExists('olts');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voucher_hotspot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('generate_voucher_id')
                ->constrained('generate_voucher')
                ->restrictOnUpdate()
                ->cascadeOnDelete();
            $table->text('name');
            $table->text('password');
            $table->text('profile');
            $table->integer('price');
            $table->enum('is_aktif', ['Yes', 'No']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voucher_hotspot');
    }
};

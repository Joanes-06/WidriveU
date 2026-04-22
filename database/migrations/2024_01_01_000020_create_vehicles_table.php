<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->string('model');
            $table->unsignedSmallInteger('year');
            $table->string('license_plate')->unique()->nullable();
            $table->unsignedTinyInteger('seats')->default(5);
            $table->enum('fuel_type', ['essence', 'diesel', 'electrique', 'hybride']);
            $table->enum('transmission', ['manuelle', 'automatique']);
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['disponible', 'reservee', 'maintenance'])->default('disponible');
            $table->unsignedInteger('price_without_driver');
            $table->unsignedInteger('price_with_driver');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};

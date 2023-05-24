<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Creates the Services table with the columns specified.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Drops the Services table if exists.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

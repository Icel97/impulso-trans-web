<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('points_of_interest', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->decimal('lat', 10, 7);  // Coordenadas de latitud
            $table->decimal('lng', 10, 7);  // Coordenadas de longitud
            $table->text('documentos');     // Documentos necesarios
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points_of_interest');
    }
};

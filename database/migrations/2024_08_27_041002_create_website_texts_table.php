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
        Schema::create('website_texts', function (Blueprint $table) {
            $table->id();
            $table->string('identifier'); // Identificador único para cada texto (ej. "texto1", "texto2")
            $table->string('title'); // Título del texto
            $table->text('content')->nullable(); // Contenido del texto
            $table->text('url_img'); // Idioma del texto
            $table->timestamps(); // Timestamps para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_texts');
    }
};

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
        Schema::create('registro_acciones', function (Blueprint $table) {
            $table->id('id_accion');
            $table->enum('tipo_accion', ['editar', 'borrar']);
            $table->timestamp('fecha_accion')->useCurrent();
            $table->foreignId('id_post')->nullable()->constrained('posts')->onDelete('cascade');
            $table->foreignId('id_comentario')->nullable()->constrained('comentarios')->onDelete('cascade');
            $table->foreignId('id_usuario')->constrained('usuarios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_acciones');
    }
};

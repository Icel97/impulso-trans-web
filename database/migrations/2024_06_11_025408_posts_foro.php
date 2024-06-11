<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id('id_post');
            $table->string('titulo');
            $table->text('contenido');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_modificacion')->nullable();
            $table->foreignId('id_usuario')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('id_tema')->constrained('temas')->onDelete('cascade');
            $table->boolean('cerrado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};

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
        //tabla de consejerias la cual es para guardar el usuario que realiza la consejeria, el usuario que recibe la consejeria, el tema de la consejeria, el pronombre del usuario que recibe la consejeria, la fecha de la consejeria , el estado de la consejeria y el link de la sesion de la consejeria sin
        Schema::create('consejerias', function (Blueprint $table) {
            $table->id('id_consejeria');
            $table->foreignId('id_usuario_consejero')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('id_usuario_consultante')->constrained('usuarios')->onDelete('cascade');
            $table->timestamp('fecha_consejeria')->useCurrent();
            $table->string('estado');
            $table->string('link_sesion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

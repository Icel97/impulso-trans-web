<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PagoStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historial_pagos', function (Blueprint $table) {
            $table->id();
<<<<<<<< HEAD:database/migrations/2024_07_27_085452_create_historial__pagos_table.php
            $table->foreignId('pago_id')->constrained('pagos'); // Relación con el pago original
            $table->string('comprobante_url');
            $table->enum('validado', PagoStatusEnum::toArray())->default(PagoStatusEnum::Pendiente->value);
            $table->dateTime('fecha_envio')->nullable();
========
            $table->string('comprobante_url');
            $table->enum('validado', PagoStatusEnum::toArray())->default(PagoStatusEnum::Pendiente->value);
            $table->dateTime('fecha_envio')->nullable();
            $table->foreignId('pago_id')->constrained('pagos')->onDelete('cascade');
>>>>>>>> main:database/migrations/2024_07_27_085458_create_historial__pagos_table.php
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial__pagos');
    }
};

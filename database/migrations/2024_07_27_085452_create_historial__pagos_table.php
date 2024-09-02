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
            $table->foreignId('pago_id')->constrained('pagos'); // Relación con el pago original
            $table->string('comprobante_url');
            $table->enum('validado', PagoStatusEnum::toArray())->default(PagoStatusEnum::Pendiente->value);
            $table->dateTime('fecha_envio')->nullable();
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

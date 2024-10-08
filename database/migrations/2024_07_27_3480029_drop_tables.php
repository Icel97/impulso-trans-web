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
        Schema::dropIfExists('pagos_historial');
        Schema::dropIfExists('historial_pagos');
        Schema::dropIfExists('historial__suscripcions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

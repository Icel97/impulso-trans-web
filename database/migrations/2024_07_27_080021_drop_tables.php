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
<<<<<<<< HEAD:database/migrations/2024_07_27_080021_drop_tables.php
        Schema::dropIfExists('pagos_historial');
========
        Schema::dropIfExists('historial_pagos');
        Schema::dropIfExists('historial__suscripcions');
>>>>>>>> main:database/migrations/2024_07_27_3480029_drop_tables.php
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

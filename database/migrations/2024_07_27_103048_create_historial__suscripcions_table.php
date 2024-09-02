<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\SuscripcionStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historial__suscripcions', function (Blueprint $table) {
            $table->id();
<<<<<<<< HEAD:database/migrations/2024_07_27_103043_create_historial__suscripcions_table.php
            $table->foreignId('suscripcion_id')->constrained('suscripciones'); // Relación con la suscripción original
========
>>>>>>>> main:database/migrations/2024_07_27_103048_create_historial__suscripcions_table.php
            $table->enum('estatus', SuscripcionStatusEnum::toArray())->default(SuscripcionStatusEnum::Inactiva->value);
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
<<<<<<<< HEAD:database/migrations/2024_07_27_103043_create_historial__suscripcions_table.php
========
            $table->foreignId('suscripcion_id')->constrained('suscripciones')->onDelete('cascade');
>>>>>>>> main:database/migrations/2024_07_27_103048_create_historial__suscripcions_table.php
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial__suscripcions');
    }
};

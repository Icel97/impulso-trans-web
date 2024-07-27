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
            $table->foreignId('suscripcion_id')->constrained('suscripciones'); // Relación con la suscripción original
            $table->enum('estatus', SuscripcionStatusEnum::toArray())->default(SuscripcionStatusEnum::Inactiva->value);
            //dates can be null
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->foreignId('usuario_id')->constrained('users'); 
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

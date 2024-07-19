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
        Schema::create('suscripcions', function (Blueprint $table) {
            $table->id();
            $table->enum('estado', SuscripcionStatusEnum::toArray())->default(SuscripcionStatusEnum::Inactivo->value);
            $table->date('fecha_inicio')->default(now()); 
            $table->date('fecha_fin'); 
            $table->foreignId('usuario_id')->constrained('users'); 
            $table->foreignId('pago_id')->constrained('pagos'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suscripcions');
    }
};

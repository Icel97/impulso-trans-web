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
        // Schema::table('suscripciones', function (Blueprint $table) {
        //     #drop foreign key
        //     $table->dropForeign('suscripciones_usuario_id_foreign');
        //     $table->foreignId('fk_suscripciones_usuario_id')->constrained('users')->onDelete('cascade')->change();
        // });
        Schema::disableForeignKeyConstraints();


        Schema::table('pagos', function (Blueprint $table) {
            #drop foreign key
            $table->dropForeign('pagos_usuario_id_foreign');
            // $table->foreignId('pagos_historial_usuario_id_foreign')->constrained('users')->onDelete('cascade')->change();
        });


        // Schema::table('historial_suscripciones', function (Blueprint $table) {
        //     $table->foreignId('suscripcion_id')->constrained('suscripciones')->onDelete('cascade')->change();
        //     $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade')->change();
        // });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suscripciones_and_historial_suscripciones', function (Blueprint $table) {
            //
        });
    }
};

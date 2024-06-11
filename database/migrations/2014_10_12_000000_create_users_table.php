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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->integer('id_pronombre');
            $table->date('date_birth');
            $table->string('email')->unique();
            $table->string('phone', 10)->unique()->nullable();
            $table->integer('id_state')->nullable();
            $table->integer('id_rol');
            $table->string('password');
            $table->string('profile_photo_path', 2048)->nullable();
            $table->integer('id_etnia');
            $table->integer('id_discapacidad');
            $table->boolean('neurodivergencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

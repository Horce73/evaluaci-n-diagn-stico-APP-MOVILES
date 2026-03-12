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
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->text('texto');
            $table->enum('tipo', ['opcion_multiple', 'verdadero_falso', 'abierta'])->default('opcion_multiple');
            $table->json('opciones')->nullable(); // Para preguntas de opción múltiple
            $table->string('respuesta_correcta')->nullable();
            $table->integer('puntaje')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};

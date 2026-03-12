<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamenController;
use App\Http\Controllers\EstudianteController;

// Dashboard - Página principal con historial de exámenes realizados
Route::get('/', [ExamenController::class, 'index'])->name('examenes.index');

// Exámenes disponibles
Route::get('/examenes', [ExamenController::class, 'disponibles'])->name('examenes.disponibles');

// Estudiantes
Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes.index');

// Seleccionar estudiante antes de iniciar examen
Route::get('/examenes/{examen}/seleccionar-estudiante', [ExamenController::class, 'seleccionarEstudiante'])
    ->name('examenes.seleccionar-estudiante');

// Iniciar examen
Route::post('/examenes/{examen}/iniciar', [ExamenController::class, 'iniciarExamen'])
    ->name('examenes.iniciar');

// Realizar examen
Route::get('/examenes/{examen}/realizar/{estudiante}', [ExamenController::class, 'realizarExamen'])
    ->name('examenes.realizar');

// Guardar respuestas
Route::post('/examenes/{examen}/guardar/{estudiante}', [ExamenController::class, 'guardarRespuestas'])
    ->name('examenes.guardar');

// Verificar código antes de ver resultado
Route::get('/examenes/{examen}/verificar/{estudiante}', [ExamenController::class, 'verificarCodigo'])
    ->name('examenes.verificar');
Route::post('/examenes/{examen}/verificar/{estudiante}', [ExamenController::class, 'procesarVerificacion'])
    ->name('examenes.verificar.post');

// Mostrar resultado (requiere código verificado)
Route::get('/examenes/{examen}/resultado/{estudiante}', [ExamenController::class, 'mostrarResultado'])
    ->name('examenes.resultado');

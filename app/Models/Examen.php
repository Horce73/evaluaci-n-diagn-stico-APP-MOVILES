<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Examen extends Model
{
    protected $table = 'examenes';

    protected $fillable = [
        'titulo',
        'descripcion',
        'duracion_minutos',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    /**
     * Obtener las preguntas del examen
     */
    public function preguntas(): BelongsToMany
    {
        return $this->belongsToMany(Pregunta::class, 'examen_pregunta')
            ->withPivot('orden')
            ->orderBy('examen_pregunta.orden')
            ->withTimestamps();
    }

    /**
     * Obtener los estudiantes que han tomado el examen
     */
    public function estudiantes(): BelongsToMany
    {
        return $this->belongsToMany(Estudiante::class, 'examen_estudiante')
            ->withPivot(['fecha_inicio', 'fecha_fin', 'calificacion', 'estado', 'respuestas', 'preguntas_ids'])
            ->withTimestamps();
    }

    /**
     * Obtener el total de preguntas del examen
     */
    public function getTotalPreguntasAttribute(): int
    {
        return $this->preguntas()->count();
    }

    /**
     * Obtener el puntaje total del examen
     */
    public function getPuntajeTotalAttribute(): int
    {
        return $this->preguntas()->sum('puntaje');
    }
}

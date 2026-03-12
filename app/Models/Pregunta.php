<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pregunta extends Model
{
    protected $table = 'preguntas';

    protected $fillable = [
        'texto',
        'tipo',
        'opciones',
        'respuesta_correcta',
        'puntaje',
    ];

    protected $casts = [
        'opciones' => 'array',
    ];

    /**
     * Obtener los exámenes que contienen esta pregunta
     */
    public function examenes(): BelongsToMany
    {
        return $this->belongsToMany(Examen::class, 'examen_pregunta')
            ->withPivot('orden')
            ->withTimestamps();
    }

    /**
     * Verificar si la respuesta es correcta
     */
    public function esRespuestaCorrecta(string $respuesta): bool
    {
        return strtolower(trim($this->respuesta_correcta)) === strtolower(trim($respuesta));
    }
}

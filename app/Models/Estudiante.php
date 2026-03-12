<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Estudiante extends Model
{
    protected $table = 'estudiantes';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'matricula',
        'codigo_acceso',
    ];

    /**
     * Obtener los exámenes del estudiante
     */
    public function examenes(): BelongsToMany
    {
        return $this->belongsToMany(Examen::class, 'examen_estudiante')
            ->withPivot(['fecha_inicio', 'fecha_fin', 'calificacion', 'estado', 'respuestas'])
            ->withTimestamps();
    }

    /**
     * Obtener el nombre completo del estudiante
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }
}

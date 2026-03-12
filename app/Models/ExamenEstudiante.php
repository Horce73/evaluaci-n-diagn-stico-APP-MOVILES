<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamenEstudiante extends Model
{
    protected $table = 'examen_estudiante';

    protected $fillable = [
        'examen_id',
        'estudiante_id',
        'fecha_inicio',
        'fecha_fin',
        'calificacion',
        'estado',
        'respuestas',
        'preguntas_ids',
    ];

    protected $casts = [
        'fecha_inicio'  => 'datetime',
        'fecha_fin'     => 'datetime',
        'calificacion'  => 'decimal:2',
        'respuestas'    => 'array',
        'preguntas_ids' => 'array',
    ];

    /**
     * Obtener el examen
     */
    public function examen(): BelongsTo
    {
        return $this->belongsTo(Examen::class);
    }

    /**
     * Obtener el estudiante
     */
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\View\View;

class EstudianteController extends Controller
{
    /**
     * Mostrar la lista de estudiantes
     */
    public function index(): View
    {
        $estudiantes = Estudiante::with('examenes')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        return view('estudiantes.index', compact('estudiantes'));
    }
}

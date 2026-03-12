<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\Estudiante;
use App\Models\ExamenEstudiante;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamenController extends Controller
{
    /**
     * Mostrar el dashboard principal con exámenes realizados
     */
    public function index(): View
    {
        $examenesRealizados = ExamenEstudiante::with(['examen', 'estudiante'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalExamenes = Examen::count();
        $totalRealizados = ExamenEstudiante::where('estado', 'completado')->count();
        $totalEstudiantes = Estudiante::count();
        $promedioGeneral = ExamenEstudiante::where('estado', 'completado')->avg('calificacion') ?? 0;

        return view('dashboard', compact(
            'examenesRealizados',
            'totalExamenes',
            'totalRealizados',
            'totalEstudiantes',
            'promedioGeneral'
        ));
    }

    /**
     * Mostrar la lista de exámenes disponibles
     */
    public function disponibles(): View
    {
        $examenes = Examen::withCount('preguntas', 'estudiantes')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('examenes.disponibles', compact('examenes'));
    }

    /**
     * Mostrar la vista de selección de estudiante antes de iniciar examen
     */
    public function seleccionarEstudiante(Examen $examen): View
    {
        $estudiantes = Estudiante::orderBy('apellido')->orderBy('nombre')->get();
        
        return view('examenes.seleccionar-estudiante', compact('examen', 'estudiantes'));
    }

    /**
     * Iniciar el examen para un estudiante — selecciona 5 preguntas aleatorias del banco
     */
    public function iniciarExamen(Request $request, Examen $examen)
    {
        $request->validate([
            'estudiante_id'  => 'required|exists:estudiantes,id',
            'codigo_acceso'  => 'required|string|size:6',
        ]);

        $estudiante = Estudiante::findOrFail($request->estudiante_id);

        // Validar código de acceso
        if (strtoupper($request->codigo_acceso) !== strtoupper($estudiante->codigo_acceso)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['codigo_acceso' => 'El código de acceso no es válido para este estudiante.']);
        }

        // Verificar si el estudiante ya completó este examen
        $examenEstudiante = $examen->estudiantes()
            ->where('estudiante_id', $estudiante->id)
            ->first();

        if ($examenEstudiante && $examenEstudiante->pivot->estado === 'completado') {
            return redirect()->back()->with('error', 'Este estudiante ya completó este examen.');
        }

        // Seleccionar 5 preguntas aleatorias del banco del examen
        // Obtener todos los IDs y mezclar con PHP (más confiable que inRandomOrder con SQLite)
        $todosLosIds = $examen->preguntas()->pluck('preguntas.id')->toArray();
        shuffle($todosLosIds);
        $preguntasIds = array_slice($todosLosIds, 0, 5);

        $pivotData = [
            'fecha_inicio'  => now(),
            'estado'        => 'en_progreso',
            'preguntas_ids' => json_encode($preguntasIds),
        ];

        if (!$examenEstudiante) {
            $examen->estudiantes()->attach($estudiante->id, $pivotData);
        } else {
            $examen->estudiantes()->updateExistingPivot($estudiante->id, $pivotData);
        }

        return redirect()->route('examenes.realizar', [
            'examen'     => $examen->id,
            'estudiante' => $estudiante->id,
        ]);
    }

    /**
     * Mostrar el formulario del examen — solo las 5 preguntas sorteadas
     */
    public function realizarExamen(Examen $examen, Estudiante $estudiante): View
    {
        $registro = $examen->estudiantes()
            ->where('estudiante_id', $estudiante->id)
            ->first();

        $preguntasIds = json_decode($registro->pivot->preguntas_ids ?? '[]', true);

        // Si por alguna razón no hay IDs guardados, sortear en el momento
        if (empty($preguntasIds)) {
            $todosLosIds = $examen->preguntas()->pluck('preguntas.id')->toArray();
            shuffle($todosLosIds);
            $preguntasIds = array_slice($todosLosIds, 0, 5);
        }

        $preguntas = $examen->preguntas()
            ->whereIn('preguntas.id', $preguntasIds)
            ->get()
            ->sortBy(fn($p) => array_search($p->id, $preguntasIds))
            ->values();

        return view('examenes.realizar', compact('examen', 'estudiante', 'preguntas'));
    }

    /**
     * Guardar las respuestas del examen — califica solo las 5 preguntas sorteadas
     */
    public function guardarRespuestas(Request $request, Examen $examen, Estudiante $estudiante)
    {
        $respuestas = $request->input('respuestas', []);

        // Recuperar los IDs sorteados para este intento
        $registro = $examen->estudiantes()
            ->where('estudiante_id', $estudiante->id)
            ->first();

        $preguntasIds = json_decode($registro->pivot->preguntas_ids ?? '[]', true);

        // Cargar solo las preguntas sorteadas
        $preguntas = $examen->preguntas()
            ->whereIn('preguntas.id', $preguntasIds)
            ->get();

        $puntajeObtenido = 0;
        $puntajeTotal    = 0;

        foreach ($preguntas as $pregunta) {
            $puntajeTotal += $pregunta->puntaje;
            if (isset($respuestas[$pregunta->id])) {
                if ($pregunta->esRespuestaCorrecta($respuestas[$pregunta->id])) {
                    $puntajeObtenido += $pregunta->puntaje;
                }
            }
        }

        $calificacion = $puntajeTotal > 0 ? ($puntajeObtenido / $puntajeTotal) * 100 : 0;

        $examen->estudiantes()->updateExistingPivot($estudiante->id, [
            'fecha_fin'    => now(),
            'calificacion' => round($calificacion, 2),
            'estado'       => 'completado',
            'respuestas'   => json_encode($respuestas),
        ]);

        // Marcar como verificado para acceso inmediato al resultado
        session()->put("resultado_verificado_{$examen->id}_{$estudiante->id}", true);

        return redirect()->route('examenes.resultado', [
            'examen'     => $examen->id,
            'estudiante' => $estudiante->id,
        ])->with('success', 'Examen completado exitosamente.');
    }

    /**
     * Mostrar el resultado del examen — requiere verificación de código
     */
    public function mostrarResultado(Examen $examen, Estudiante $estudiante): View
    {
        // Verificar que el estudiante haya sido verificado
        if (!session()->has("resultado_verificado_{$examen->id}_{$estudiante->id}")) {
            return redirect()->route('examenes.verificar', [
                'examen'     => $examen->id,
                'estudiante' => $estudiante->id,
            ])->with('info', 'Por favor ingresa tu código de acceso para ver el resultado.');
        }

        $examenEstudiante = $examen->estudiantes()
            ->where('estudiante_id', $estudiante->id)
            ->first();

        $respuestas   = json_decode($examenEstudiante->pivot->respuestas   ?? '{}', true);
        $preguntasIds = json_decode($examenEstudiante->pivot->preguntas_ids ?? '[]', true);

        // Mostrar solo las preguntas que se presentaron en ese intento
        if (!empty($preguntasIds)) {
            $preguntas = $examen->preguntas()
                ->whereIn('preguntas.id', $preguntasIds)
                ->get()
                ->sortBy(fn($p) => array_search($p->id, $preguntasIds))
                ->values();
        } else {
            $preguntas = $examen->preguntas;
        }

        return view('examenes.resultado', compact('examen', 'estudiante', 'examenEstudiante', 'preguntas', 'respuestas'));
    }

    /**
     * Mostrar formulario para verificar código antes de ver resultado
     */
    public function verificarCodigo(Examen $examen, Estudiante $estudiante): View
    {
        return view('examenes.verificar-codigo', compact('examen', 'estudiante'));
    }

    /**
     * Procesar verificación de código y redirigir a resultado
     */
    public function procesarVerificacion(Request $request, Examen $examen, Estudiante $estudiante)
    {
        $request->validate([
            'codigo_acceso' => 'required|string|size:6',
        ]);

        if (strtoupper($request->codigo_acceso) !== strtoupper($estudiante->codigo_acceso)) {
            return redirect()->back()
                ->withErrors(['codigo_acceso' => 'El código de acceso no es válido.']);
        }

        // Guardar en sesión que este estudiante fue verificado para este resultado
        session()->put("resultado_verificado_{$examen->id}_{$estudiante->id}", true);

        return redirect()->route('examenes.resultado', [
            'examen'     => $examen->id,
            'estudiante' => $estudiante->id,
        ]);
    }
}

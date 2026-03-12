<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Resultado - {{ $examen->titulo }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <a href="{{ route('examenes.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                            ← Volver a exámenes
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900 mt-2">
                            Resultado del Examen
                        </h1>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Result Summary -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 {{ $examenEstudiante->pivot->calificacion >= 60 ? 'bg-green-50' : 'bg-red-50' }}">
                    <h2 class="text-lg font-semibold {{ $examenEstudiante->pivot->calificacion >= 60 ? 'text-green-800' : 'text-red-800' }}">
                        {{ $examenEstudiante->pivot->calificacion >= 60 ? '¡Felicitaciones!' : 'Resultado' }}
                    </h2>
                </div>
                <div class="p-6">
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-32 h-32 rounded-full {{ $examenEstudiante->pivot->calificacion >= 60 ? 'bg-green-100' : 'bg-red-100' }} mb-4">
                            <span class="text-4xl font-bold {{ $examenEstudiante->pivot->calificacion >= 60 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($examenEstudiante->pivot->calificacion, 1) }}%
                            </span>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900">
                            {{ $estudiante->nombre_completo }}
                        </h3>
                        <p class="text-gray-500">{{ $examen->titulo }}</p>
                    </div>

                    <dl class="grid grid-cols-1 sm:grid-cols-3 gap-4 border-t border-gray-200 pt-6">
                        <div class="text-center">
                            <dt class="text-sm font-medium text-gray-500">Fecha de Inicio</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($examenEstudiante->pivot->fecha_inicio)->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                        <div class="text-center">
                            <dt class="text-sm font-medium text-gray-500">Fecha de Finalización</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($examenEstudiante->pivot->fecha_fin)->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                        <div class="text-center">
                            <dt class="text-sm font-medium text-gray-500">Estado</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $examenEstudiante->pivot->calificacion >= 60 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $examenEstudiante->pivot->calificacion >= 60 ? 'Aprobado' : 'Reprobado' }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Detailed Results -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Detalle de Respuestas</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($preguntas as $index => $pregunta)
                        @php
                            $respuestaUsuario = $respuestas[$pregunta->id] ?? null;
                            $esCorrecta = $pregunta->esRespuestaCorrecta($respuestaUsuario ?? '');
                        @endphp
                        <div class="p-6 {{ $esCorrecta ? 'bg-green-50' : 'bg-red-50' }}">
                            <div class="flex items-start justify-between mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $esCorrecta ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    Pregunta {{ $index + 1 }} - {{ $esCorrecta ? 'Correcta' : 'Incorrecta' }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ $pregunta->puntaje }} punto(s)
                                </span>
                            </div>
                            
                            <p class="text-gray-900 font-medium mb-4">
                                {{ $pregunta->texto }}
                            </p>

                            <div class="space-y-2 text-sm">
                                <div class="flex items-start">
                                    <span class="font-medium text-gray-700 w-32">Tu respuesta:</span>
                                    <span class="{{ $esCorrecta ? 'text-green-700' : 'text-red-700' }}">
                                        @if($pregunta->tipo === 'opcion_multiple' && $pregunta->opciones && $respuestaUsuario)
                                            {{ $pregunta->opciones[$respuestaUsuario] ?? $respuestaUsuario }}
                                        @else
                                            {{ $respuestaUsuario ?? 'Sin respuesta' }}
                                        @endif
                                    </span>
                                </div>
                                @if(!$esCorrecta)
                                    <div class="flex items-start">
                                        <span class="font-medium text-gray-700 w-32">Respuesta correcta:</span>
                                        <span class="text-green-700">
                                            @if($pregunta->tipo === 'opcion_multiple' && $pregunta->opciones)
                                                {{ $pregunta->opciones[$pregunta->respuesta_correcta] ?? $pregunta->respuesta_correcta }}
                                            @else
                                                {{ $pregunta->respuesta_correcta }}
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-8 text-center">
                <a 
                    href="{{ route('examenes.index') }}"
                    class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Volver al Inicio
                </a>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <p class="text-center text-sm text-gray-500">
                    Sistema de Evaluaciones - Desarrollado con Laravel
                </p>
            </div>
        </footer>
    </body>
</html>

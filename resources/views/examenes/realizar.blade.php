<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $examen->titulo }} - Examen</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 min-h-screen">
        <!-- Header -->
        <header class="bg-indigo-600 shadow-sm sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-bold text-white">
                            {{ $examen->titulo }}
                        </h1>
                        <p class="text-indigo-200 text-sm">
                            Estudiante: {{ $estudiante->nombre_completo }}
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="text-white font-medium" id="timer">
                            Tiempo restante: <span id="time">{{ $examen->duracion_minutos }}:00</span>
                        </div>
                        <div class="text-indigo-200 text-sm">
                            {{ $preguntas->count() }} preguntas
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <form action="{{ route('examenes.guardar', ['examen' => $examen, 'estudiante' => $estudiante]) }}" method="POST" id="examen-form">
                @csrf

                @if($preguntas->count() > 0)
                    <div class="space-y-6">
                        @foreach($preguntas as $index => $pregunta)
                            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                            Pregunta {{ $index + 1 }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            {{ $pregunta->puntaje }} punto(s)
                                        </span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <p class="text-gray-900 font-medium mb-4">
                                        {{ $pregunta->texto }}
                                    </p>

                                    @if($pregunta->tipo === 'opcion_multiple' && $pregunta->opciones)
                                        <div class="space-y-3">
                                            @foreach($pregunta->opciones as $opcionKey => $opcion)
                                                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                                    <input 
                                                        type="radio" 
                                                        name="respuestas[{{ $pregunta->id }}]" 
                                                        value="{{ $opcionKey }}"
                                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                                    >
                                                    <span class="ml-3 text-gray-700">{{ $opcion }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @elseif($pregunta->tipo === 'verdadero_falso')
                                        <div class="space-y-3">
                                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                                <input 
                                                    type="radio" 
                                                    name="respuestas[{{ $pregunta->id }}]" 
                                                    value="verdadero"
                                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                                >
                                                <span class="ml-3 text-gray-700">Verdadero</span>
                                            </label>
                                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                                <input 
                                                    type="radio" 
                                                    name="respuestas[{{ $pregunta->id }}]" 
                                                    value="falso"
                                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                                >
                                                <span class="ml-3 text-gray-700">Falso</span>
                                            </label>
                                        </div>
                                    @else
                                        <textarea 
                                            name="respuestas[{{ $pregunta->id }}]"
                                            rows="4"
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                            placeholder="Escribe tu respuesta aquí..."
                                        ></textarea>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 flex justify-end">
                        <button 
                            type="submit"
                            class="px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                            onclick="return confirm('¿Estás seguro de enviar tus respuestas? No podrás modificarlas después.');"
                        >
                            Finalizar y Enviar Examen
                        </button>
                    </div>
                @else
                    <div class="bg-white shadow-md rounded-lg p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay preguntas</h3>
                        <p class="mt-1 text-sm text-gray-500">Este examen no tiene preguntas registradas.</p>
                    </div>
                @endif
            </form>
        </main>

        <!-- Timer Script + Exit Protection -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let minutes = {{ $examen->duracion_minutos }};
                let seconds = 0;
                const timerElement = document.getElementById('time');
                const form = document.getElementById('examen-form');
                let formSubmitting = false;

                // ─── Protección contra salir de la página ────────────────────────
                window.addEventListener('beforeunload', function(e) {
                    if (!formSubmitting) {
                        e.preventDefault();
                        // Mensaje estándar (los navegadores modernos ignoran el texto personalizado)
                        e.returnValue = 'Si sales ahora, el examen se enviará automáticamente con las respuestas actuales. ¿Estás seguro?';
                        return e.returnValue;
                    }
                });

                // Cuando se hace submit legítimo, desactivar la protección
                form.addEventListener('submit', function() {
                    formSubmitting = true;
                });

                // ─── Detectar si el usuario intenta cerrar o navegar fuera ───────
                // Usar visibilitychange para auto-enviar si oculta la pestaña mucho tiempo
                let hiddenTime = null;
                document.addEventListener('visibilitychange', function() {
                    if (document.hidden) {
                        hiddenTime = Date.now();
                    } else {
                        // Si estuvo oculto más de 10 segundos, advertir
                        if (hiddenTime && (Date.now() - hiddenTime > 10000)) {
                            alert('Advertencia: Salir de esta página durante el examen puede resultar en envío automático.');
                        }
                        hiddenTime = null;
                    }
                });

                // ─── Temporizador ────────────────────────────────────────────────
                const timer = setInterval(function() {
                    if (seconds === 0) {
                        if (minutes === 0) {
                            clearInterval(timer);
                            formSubmitting = true; // Desactivar protección antes de enviar
                            alert('¡Tiempo terminado! El examen se enviará automáticamente.');
                            form.submit();
                            return;
                        }
                        minutes--;
                        seconds = 59;
                    } else {
                        seconds--;
                    }

                    timerElement.textContent = 
                        String(minutes).padStart(2, '0') + ':' + 
                        String(seconds).padStart(2, '0');

                    // Warning when 5 minutes left
                    if (minutes === 5 && seconds === 0) {
                        timerElement.parentElement.classList.add('text-yellow-300');
                    }
                    // Warning when 1 minute left
                    if (minutes === 1 && seconds === 0) {
                        timerElement.parentElement.classList.remove('text-yellow-300');
                        timerElement.parentElement.classList.add('text-red-300');
                    }
                }, 1000);
            });
        </script>
    </body>
</html>

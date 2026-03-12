<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Seleccionar Estudiante - {{ $examen->titulo }}</title>

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
                            {{ $examen->titulo }}
                        </h1>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Alerts -->
            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Exam Info Card -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-indigo-50">
                    <h2 class="text-lg font-semibold text-indigo-800">Información del Examen</h2>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $examen->descripcion ?? 'Sin descripción' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Duración</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $examen->duracion_minutos }} minutos</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total de Preguntas</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $examen->preguntas->count() }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Estado</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ ucfirst($examen->estado) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Student Selection Form -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Seleccionar Estudiante</h2>
                    <p class="text-sm text-gray-600 mt-1">Selecciona tu nombre para iniciar el examen</p>
                </div>

                <form action="{{ route('examenes.iniciar', $examen) }}" method="POST" class="p-6">
                    @csrf

                    @if($estudiantes->count() > 0)
                        <div class="mb-6">
                            <label for="estudiante_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Estudiante
                            </label>
                            <select 
                                name="estudiante_id" 
                                id="estudiante_id" 
                                required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            >
                                <option value="">-- Selecciona tu nombre --</option>
                                @foreach($estudiantes as $estudiante)
                                    <option value="{{ $estudiante->id }}">
                                        {{ $estudiante->apellido }}, {{ $estudiante->nombre }} ({{ $estudiante->matricula }})
                                    </option>
                                @endforeach
                            </select>
                            @error('estudiante_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="codigo_acceso" class="block text-sm font-medium text-gray-700 mb-2">
                                Código de Acceso
                            </label>
                            <input 
                                type="password" 
                                name="codigo_acceso" 
                                id="codigo_acceso" 
                                required
                                maxlength="6"
                                placeholder="Ingresa tu código de 6 caracteres"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 uppercase tracking-widest"
                            >
                            <p class="mt-1 text-xs text-gray-500">El código de acceso fue proporcionado por tu profesor.</p>
                            @error('codigo_acceso')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-6">
                            <div class="flex">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Importante</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Una vez iniciado, el examen tiene un tiempo límite de {{ $examen->duracion_minutos }} minutos.</li>
                                            <li>No podrás pausar el examen una vez comenzado.</li>
                                            <li>Asegúrate de tener una conexión estable a internet.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a 
                                href="{{ route('examenes.index') }}" 
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Cancelar
                            </a>
                            <button 
                                type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Iniciar Examen
                            </button>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay estudiantes registrados</h3>
                            <p class="mt-1 text-sm text-gray-500">Contacta al administrador para registrar estudiantes.</p>
                        </div>
                    @endif
                </form>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <p class="text-center text-sm text-gray-500">
                    Sistema de Evaluaciones - Desarrollado con Laravel
                </p>
            </div>
        </footer>
    </body>
</html>

@extends('layouts.app')

@section('title', 'Verificar Acceso - ' . $examen->titulo)
@section('header', 'Verificar Acceso')

@section('content')
    <div class="max-w-md mx-auto">
        <!-- Info Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="px-6 py-4 bg-indigo-50 border-b border-indigo-100">
                <h2 class="text-lg font-semibold text-indigo-800">{{ $examen->titulo }}</h2>
                <p class="text-sm text-indigo-600 mt-1">Resultado de: {{ $estudiante->nombre_completo }}</p>
            </div>

            <div class="p-6">
                @if(session('info'))
                    <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded">
                        {{ session('info') }}
                    </div>
                @endif

                <p class="text-gray-600 mb-6">
                    Para ver el resultado de este examen, por favor ingresa el código de acceso del estudiante.
                </p>

                <form action="{{ route('examenes.verificar.post', ['examen' => $examen, 'estudiante' => $estudiante]) }}" method="POST">
                    @csrf

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
                            autofocus
                            placeholder="••••••"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-center text-lg tracking-widest uppercase"
                        >
                        @error('codigo_acceso')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <a 
                            href="{{ route('examenes.index') }}" 
                            class="text-sm text-gray-600 hover:text-gray-800"
                        >
                            ← Volver al inicio
                        </a>
                        <button 
                            type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                        >
                            Verificar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Note -->
        <div class="text-center text-sm text-gray-500">
            <svg class="w-5 h-5 inline-block mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
            </svg>
            Los resultados son privados y solo accesibles con tu código personal.
        </div>
    </div>
@endsection

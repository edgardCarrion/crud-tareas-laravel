<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen py-10">

    <div class="max-w-xl mx-auto">

        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">📝 Lista de Tareas</h1>

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulario agregar tarea --}}
        <form action="{{ route('tareas.store') }}" method="POST" class="flex gap-2 mb-6">
            @csrf
            <input
                type="text"
                name="nombre"
                placeholder="Nueva tarea..."
                class="flex-1 px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400"
                value="{{ old('nombre') }}"
            >
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded font-semibold">
                Agregar
            </button>
        </form>

        {{-- Error de validación --}}
        @error('nombre')
            <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
        @enderror

        {{-- Lista de tareas --}}
        <ul class="space-y-3">
            @forelse($tareas as $tarea)
                <li class="bg-white px-4 py-3 rounded shadow flex items-center justify-between">

                    <div class="flex items-center gap-3">
                        {{-- Botón completar --}}
                        <form action="{{ route('tareas.update', $tarea) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-xl">
                                {{ $tarea->completada ? '✅' : '⬜' }}
                            </button>
                        </form>

                        <span class="{{ $tarea->completada ? 'line-through text-gray-400' : 'text-gray-800' }}">
                            {{ $tarea->nombre }}
                        </span>
                    </div>

                    {{-- Botón eliminar --}}
                    <form action="{{ route('tareas.destroy', $tarea) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                            Eliminar
                        </button>
                    </form>

                </li>
            @empty
                <p class="text-center text-gray-400 py-6">No hay tareas aún. ¡Agrega una!</p>
            @endforelse
        </ul>

    </div>

</body>
</html>
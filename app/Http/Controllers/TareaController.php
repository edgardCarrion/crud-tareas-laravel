<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index()
    {
        $tareas = Tarea::latest()->get();
        return view('tareas.index', compact('tareas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|min:3|max:255'
        ]);

        Tarea::create(['nombre' => $request->nombre]);

        return redirect()->route('tareas.index')->with('success', 'Tarea agregada correctamente');
    }

    public function destroy(Tarea $tarea)
    {
        $tarea->delete();
        return redirect()->route('tareas.index')->with('success', 'Tarea eliminada correctamente');
    }

    public function update(Request $request, Tarea $tarea)
    {
        $tarea->update(['completada' => !$tarea->completada]);
        return redirect()->route('tareas.index');
    }
}
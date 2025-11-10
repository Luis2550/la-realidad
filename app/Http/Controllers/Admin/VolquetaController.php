<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Volqueta;
use Illuminate\Http\Request;

class VolquetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.volquetas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.volquetas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'placa' => [
                'required',
                'string',
                'max:8',
                'regex:/^[A-Z]{3}-[0-9]{3,4}$/', // AAA-123 o AAA-1234
                'unique:volquetas,placa'
            ],
            'propietario' => 'required|string|max:255',
            'conductor' => 'required|string|max:255',
            'cubicaje' => 'required|numeric|min:1|max:999.99'
        ], [
            // ✅ mensajes personalizados
            'placa.required' => 'La placa es obligatoria.',
            'placa.regex' => 'Formato de placa inválido (ej: ABC-1234).',
            'placa.unique' => 'Esta placa ya está registrada.',

            'propietario.required' => 'Debe ingresar un propietario.',
            'conductor.required' => 'Debe ingresar un conductor.',

            'cubicaje.required' => 'Debe ingresar el cubicaje.',
            'cubicaje.numeric' => 'El cubicaje debe ser numérico.',
        ]);

        Volqueta::create($validated);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Volqueta creada correctamenre',
            'text' => 'Volqueta registrada correctamente'
        ]);

        return redirect()->route('admin.volquetas.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Volqueta $volqueta)
    {
        return view('admin.volquetas.show', compact('volqueta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Volqueta $volqueta)
    {
        return view('admin.volquetas.edit', compact('volqueta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Volqueta $volqueta)
    {
        $validated = $request->validate([
            'placa' => [
                'required',
                'string',
                'max:8',
                'regex:/^[A-Z]{3}-[0-9]{3,4}$/', // AAA-123 o AAA-1234
                'unique:volquetas,placa,' . $volqueta->id
            ],
            'propietario' => 'required|string|max:255',
            'conductor' => 'required|string|max:255',
            'cubicaje' => 'required|numeric|min:1|max:999.99'
        ], [
            'placa.required' => 'La placa es obligatoria.',
            'placa.regex' => 'Formato de placa inválido (ej: ABC-1234).',
            'placa.unique' => 'Esta placa ya está registrada.',

            'propietario.required' => 'Debe ingresar un propietario.',
            'conductor.required' => 'Debe ingresar un conductor.',

            'cubicaje.required' => 'Debe ingresar el cubicaje.',
            'cubicaje.numeric' => 'El cubicaje debe ser numérico.',
        ]);

        $volqueta->update($validated);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Volqueta actualizada',
            'text' => 'Los datos fueron actualizados correctamente'
        ]);

        return redirect()->route('admin.volquetas.index');
    }


    public function destroy(Volqueta $volqueta)
    {
        $volqueta->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Volqueta eliminada',
            'text' => 'El registro ha sido eliminado correctamente.'
        ]);

        return redirect()->route('admin.volquetas.index');
    }

    public function buscarPorPlaca($placa)
    {
        $volqueta = Volqueta::where('placa', strtoupper($placa))->first();

        if ($volqueta) {
            return response()->json([
                'success' => true,
                'volqueta' => [
                    'id' => $volqueta->id,
                    'placa' => $volqueta->placa,
                    'propietario' => $volqueta->propietario,
                    'conductor' => $volqueta->conductor,
                    'cubicaje' => $volqueta->cubicaje,
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Volqueta no encontrada con la placa: ' . $placa
        ], 404);
    }
}

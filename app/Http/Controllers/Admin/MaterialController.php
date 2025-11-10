<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.materiales.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.materiales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:materials,nombre',
        ], [
            'nombre.required' => 'El material es obligatorio.',
            'nombre.unique' => 'Este material ya está registrado.',
        ]);

        Material::create($validated);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Material creado correctamente',
            'text' => 'El material fue registrado exitosamente',
        ]);

        return redirect()->route('admin.material.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        return view('admin.materiales.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {

        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:materials,nombre,' . $material->id,
        ], [
            'nombre.required' => 'El material es obligatorio.',
            'nombre.unique' => 'Este Material ya está registrado.',
        ]);


        $material->update($validated);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Material actualizado',
            'text' => 'Los datos del material fueron actualizados correctamente.',
        ]);

        return redirect()->route('admin.material.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Material eliminado',
            'text' => 'El material fue eliminado correctamente.',
        ]);

        return redirect()->route('admin.material.index');
    }
}

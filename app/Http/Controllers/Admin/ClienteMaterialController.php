<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClienteMaterial;
use App\Models\Cliente;
use App\Models\Material;
use Illuminate\Http\Request;

class ClienteMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.preciomateriales.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $materiales = Material::orderBy('nombre')->get();
        
        return view('admin.preciomateriales.create', compact('clientes', 'materiales'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'material_id' => 'required|exists:materials,id',
            'precio' => 'required|numeric|min:0|max:999999.99',
        ], [
            'cliente_id.required' => 'Debe seleccionar un cliente.',
            'cliente_id.exists' => 'El cliente seleccionado no existe.',
            'material_id.required' => 'Debe seleccionar un material.',
            'material_id.exists' => 'El material seleccionado no existe.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'precio.min' => 'El precio no puede ser negativo.',
            'precio.max' => 'El precio es demasiado grande.',
        ]);

        // Verificar si ya existe la combinación cliente-material
        $existe = ClienteMaterial::where('cliente_id', $validated['cliente_id'])
            ->where('material_id', $validated['material_id'])
            ->exists();

        if ($existe) {
            return back()->withErrors([
                'material_id' => 'Ya existe un precio registrado para este cliente y material.'
            ])->withInput();
        }

        ClienteMaterial::create($validated);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Precio creado correctamente',
            'text' => 'El precio fue registrado exitosamente.',
        ]);

        return redirect()->route('admin.preciomaterial.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClienteMaterial $preciomaterial)
    {
        $preciomaterial->load(['cliente', 'material']);
        
        return view('admin.preciomateriales.show', compact('preciomaterial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClienteMaterial $preciomaterial)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $materiales = Material::orderBy('nombre')->get();
        
        return view('admin.preciomateriales.edit', compact('preciomaterial', 'clientes', 'materiales'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClienteMaterial $preciomaterial)
    {
        $validated = $request->validate([
            'precio' => 'required|numeric|min:0|max:999999.99',
        ], [
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'precio.min' => 'El precio no puede ser negativo.',
            'precio.max' => 'El precio es demasiado grande.',
        ]);

        $preciomaterial->update($validated);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Precio actualizado',
            'text' => 'El precio fue actualizado correctamente.',
        ]);

        return redirect()->route('admin.preciomaterial.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClienteMaterial $preciomaterial)
    {
        $preciomaterial->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Precio eliminado',
            'text' => 'El precio fue eliminado correctamente.',
        ]);

        return redirect()->route('admin.preciomaterial.index');
    }
}
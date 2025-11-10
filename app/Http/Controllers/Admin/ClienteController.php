<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.clientes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ Validación
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:clientes,nombre',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique' => 'Este cliente ya está registrado.',
        ]);

        // ✅ Crear cliente
        Cliente::create($validated);

        // ✅ Mensaje tipo SweetAlert (igual que usas en Volquetas)
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cliente creado correctamente',
            'text' => 'El cliente fue registrado exitosamente',
        ]);

        // ✅ Redirección
        return redirect()->route('admin.clientes.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }


    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        // ✅ Validación (ignora el nombre actual del cliente)
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:clientes,nombre,' . $cliente->id,
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique' => 'Este cliente ya está registrado.',
        ]);

        // ✅ Actualizar cliente
        $cliente->update($validated);

        // ✅ SweetAlert
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cliente actualizado',
            'text' => 'Los datos del cliente fueron actualizados correctamente.',
        ]);

        return redirect()->route('admin.clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        // ✅ Eliminar cliente
        $cliente->delete();

        // ✅ SweetAlert
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cliente eliminado',
            'text' => 'El cliente fue eliminado correctamente.',
        ]);

        return redirect()->route('admin.clientes.index');
    }
}

<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteApiController extends Controller
{
    
    public function listar()
    {
        $clientes = Cliente::orderBy('nombre')
            ->select('id', 'nombre')
            ->get();

        return response()->json([
            'success' => true,
            'clientes' => $clientes
        ]);
    }

}

<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Volqueta;

class VolquetaApiController extends Controller
{
    // Nuevo método para listar todas las volquetas
    public function index()
    {
        $volquetas = Volqueta::select('id', 'placa', 'propietario', 'conductor', 'cubicaje')
            ->orderBy('placa')
            ->get();

        return response()->json([
            'success' => true,
            'volquetas' => $volquetas
        ]);
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
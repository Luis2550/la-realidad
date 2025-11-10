<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\JsonResponse;

class MaterialApiController extends Controller
{
    /**
     * Lista todos los materiales disponibles
     */
    public function listar(): JsonResponse
    {
        try {
            $materiales = Material::select('id', 'nombre')
                ->orderBy('nombre')
                ->get();

            return response()->json([
                'success' => true,
                'materiales' => $materiales
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar materiales: ' . $e->getMessage()
            ], 500);
        }
    }
}
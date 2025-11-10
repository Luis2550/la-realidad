<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Http\Request;

class VentaApiController extends Controller
{
    public function siguienteTicket(Request $request)
    {
        $clienteId = $request->input('cliente_id');
        
        if (!$clienteId) {
            return response()->json([
                'success' => true,
                'ticket' => '000001'
            ]);
        }

        // Verificar que el cliente existe
        $cliente = Cliente::find($clienteId);
        if (!$cliente) {
            return response()->json([
                'success' => true,
                'ticket' => '000001'
            ]);
        }

        $ultimaVenta = Venta::where('cliente_id', $clienteId)
            ->orderBy('id', 'desc')
            ->first();

        if (!$ultimaVenta) {
            $siguienteNumero = 1;
        } else {
            $ultimoNumero = (int) $ultimaVenta->ticket_mina;
            $siguienteNumero = $ultimoNumero + 1;
        }

        return response()->json([
            'success' => true,
            'ticket' => str_pad($siguienteNumero, 6, '0', STR_PAD_LEFT)
        ]);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Material;
use App\Models\Venta;
use App\Models\Volqueta;
use Illuminate\Http\Request;
use App\Exports\VentasClienteExport;
use Maatwebsite\Excel\Facades\Excel;


class VentaController extends Controller
{
    public function index()
    {
        return view('admin.ventas.index');
    }

    public function create()
    {
        return view('admin.ventas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_nombre' => 'required|string|max:255',
            'placa' => 'required|string|max:20',
            'propietario' => 'required|string|max:255',
            'conductor' => 'required|string|max:255',
            'cubicaje' => 'required|numeric|min:0',
            'ticket_mina' => 'required|string|max:10',
            'ticket_transporte' => 'nullable|string|max:255',
            'material' => 'required|string|max:255',
            'tipo_volqueta' => 'required|string|max:50',
            'origen' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required',
        ]);

        // Buscar o crear cliente
        $cliente = Cliente::firstOrCreate(
            ['nombre' => strtoupper($validated['cliente_nombre'])]
        );
        $validated['cliente_id'] = $cliente->id;

        // Buscar o crear volqueta
        $volqueta = Volqueta::firstOrCreate(
            ['placa' => $validated['placa']],
            [
                'propietario' => strtoupper($validated['propietario']),
                'conductor' => strtoupper($validated['conductor']),
                'cubicaje' => $validated['cubicaje']
            ]
        );
        $validated['volqueta_id'] = $volqueta->id;

        // Buscar o crear material
        Material::firstOrCreate(
            ['nombre' => strtoupper($validated['material'])]
        );

        // Crear la venta
        $venta = Venta::create($validated);

        // Flash mensaje de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Venta guardada',
            'text' => 'La venta ha sido registrada correctamente'
        ]);

        // En el store, mantén:
        session()->flash('print_url', route('admin.ventas.print', ['venta' => $venta->id]));
        return redirect()->route('admin.ventas.index');
    }

    public function showCliente(Cliente $cliente)
    {
        $mes = request('mes');
        $ano = request('ano', date('Y'));

        $query = Venta::query()
            ->where('cliente_id', $cliente->id)
            ->with(['volqueta'])
            ->orderBy('created_at', 'desc')
            ->orderBy('hora', 'desc');

        if ($mes) {
            $query->whereMonth('created_at', $mes);
        }

        if ($ano) {
            $query->whereYear('created_at', $ano);
        }

        $ventas = $query->get();
        $totalCubicaje = $ventas->sum('volqueta.cubicaje');

        return view('admin.ventas.cliente', compact('cliente', 'ventas', 'totalCubicaje', 'mes', 'ano'));
    }

    public function print(Venta $venta)
    {
        $autoPrint = request()->query('auto_print', 0);
        return view('admin.ventas.print', compact('venta', 'autoPrint'));
    }


    public function exportarCliente(Cliente $cliente)
    {
        $mes = request('mes');
        $ano = request('ano', date('Y'));

        $query = Venta::query()
            ->where('cliente_id', $cliente->id)
            ->with(['volqueta'])
            ->orderBy('created_at', 'desc')
            ->orderBy('hora', 'desc');

        if ($mes) {
            $query->whereMonth('created_at', $mes);
        }

        if ($ano) {
            $query->whereYear('created_at', $ano);
        }

        $ventas = $query->get();

        // Generar nombre del archivo
        $nombreArchivo = 'Ventas_' . str_replace(' ', '_', $cliente->nombre);

        if ($mes && $ano) {
            $meses = [
                '',
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Octubre',
                'Noviembre',
                'Diciembre'
            ];
            $nombreArchivo .= '_' . $meses[$mes] . '_' . $ano;
        } elseif ($ano) {
            $nombreArchivo .= '_' . $ano;
        }

        $nombreArchivo .= '.xlsx';

        return Excel::download(
            new VentasClienteExport($ventas, $cliente, $mes, $ano),
            $nombreArchivo
        );
    }

    public function show(Venta $venta)
    {
        //
    }

    public function edit(Venta $venta)
    {
        return view('admin.ventas.edit', compact('venta'));
    }

    public function update(Request $request, Venta $venta)
    {
        //
    }

    public function destroy(Venta $venta)
    {
        $venta->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Venta eliminada',
            'text' => 'La venta ha sido eliminada correctamente'
        ]);

        return redirect()->route('admin.ventas.index');
    }
}

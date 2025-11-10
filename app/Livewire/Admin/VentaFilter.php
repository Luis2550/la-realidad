<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Venta;

class VentaFilter extends Component
{
    public $selectedMes = null;
    public $selectedAno = null;
    public $clientesConVentas = [];

    public function mount()
    {
        $this->selectedAno = date('Y');
        $this->loadData();
    }

    public function updatedSelectedMes()
    {
        $this->loadData();
    }

    public function updatedSelectedAno()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $query = Venta::query()
            ->with(['cliente', 'volqueta'])
            ->orderBy('created_at', 'desc')
            ->orderBy('hora', 'desc');

        if ($this->selectedMes) {
            $query->whereMonth('created_at', $this->selectedMes);
        }

        if ($this->selectedAno) {
            $query->whereYear('created_at', $this->selectedAno);
        }

        $ventas = $query->get();

        $this->clientesConVentas = $ventas->groupBy('cliente_id')->map(function ($ventasCliente) {
            $cliente = $ventasCliente->first()->cliente;
            return [
                'id' => $cliente->id,
                'nombre' => $cliente->nombre,
                'total_ventas' => $ventasCliente->count(),
                'total_cubicaje' => $ventasCliente->sum('volqueta.cubicaje'),
            ];
        })->sortByDesc('total_ventas')->values();
    }

    public function clearFilters()
    {
        $this->selectedMes = null;
        $this->selectedAno = date('Y');
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.admin.venta-filter');
    }
}
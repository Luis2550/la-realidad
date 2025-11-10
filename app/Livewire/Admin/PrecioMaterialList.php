<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;
use App\Models\ClienteMaterial;

class PrecioMaterialList extends Component
{
    use WithPagination;

    public $search = '';
    public $clienteSeleccionado = null;
    public $perPage = 10;

    protected $queryString = ['search', 'clienteSeleccionado'];

    public function mount()
    {
        // Seleccionar el primer cliente por defecto
        if (!$this->clienteSeleccionado) {
            $primerCliente = Cliente::has('preciosMateriales')->first();
            $this->clienteSeleccionado = $primerCliente?->id;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function seleccionarCliente($clienteId)
    {
        $this->clienteSeleccionado = $clienteId;
        $this->resetPage();
    }

    public function eliminar($precioId)
    {
        $precio = ClienteMaterial::find($precioId);
        
        if ($precio) {
            $precio->delete();
            
            session()->flash('swal', [
                'icon' => 'success',
                'title' => 'Precio eliminado',
                'text' => 'El precio fue eliminado correctamente.',
            ]);
        }
    }

    public function render()
    {
        // Obtener clientes con precios
        $clientes = Cliente::has('preciosMateriales')
            ->when($this->search, function ($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%');
            })
            ->withCount('preciosMateriales')
            ->orderBy('nombre')
            ->get();

        // Obtener precios del cliente seleccionado
        $precios = collect();
        $clienteActual = null;
        
        if ($this->clienteSeleccionado) {
            $clienteActual = Cliente::with(['preciosMateriales.material'])
                ->find($this->clienteSeleccionado);
            
            if ($clienteActual) {
                $precios = $clienteActual->preciosMateriales()
                    ->with('material')
                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage);
            }
        }

        return view('livewire.admin.precio-material-list', [
            'clientes' => $clientes,
            'precios' => $precios,
            'clienteActual' => $clienteActual,
        ]);
    }
}
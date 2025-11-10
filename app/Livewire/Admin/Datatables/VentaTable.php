<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use App\Models\Venta;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Builder;

class VentaTable extends DataTableComponent
{
    protected $model = Venta::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [

            Column::make("Fecha", "created_at")
                ->sortable()
                ->format(fn($value) => $value->format('d/m/Y H:i')),

            Column::make("ID", "id")
                ->sortable()
                ->searchable()
                ->hideIf(true), 

            Column::make("Cliente", "cliente.nombre")
                ->sortable()
                ->searchable(),

            Column::make("Placa", "volqueta.placa")
                ->sortable()
                ->searchable(),

            Column::make("Conductor", "volqueta.conductor")
                ->sortable()
                ->searchable(),

            Column::make("Propietario", "volqueta.propietario")
                ->sortable()
                ->searchable(),

            Column::make('Ticket Mina', 'ticket_mina')
                ->sortable()
                ->searchable(),

            Column::make("Ticket Transporte", "ticket_transporte")
                ->sortable()
                ->searchable(),

            Column::make("Acciones")
                ->label(function ($row) {
                    return view('admin.ventas.actions', [
                        'venta' => $row 
                    ]);
                })
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Cliente')
                ->options([
                    '' => 'Todos los clientes',
                ] + Cliente::orderBy('nombre')->pluck('nombre', 'id')->toArray())
                ->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('cliente_id', $value);
                    }
                }),
        ];
    }

    public function builder(): Builder
    {
        return Venta::query()
            ->with(['cliente', 'volqueta']);
    }
}
<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\ClienteMaterial;

class ClienteMaterialTable extends DataTableComponent
{
    protected $model = ClienteMaterial::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('id', 'desc')
            ->setSearchEnabled()
            ->setColumnSelectEnabled()
            ->setPerPageAccepted([10, 25, 50, 100]);
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->hideIf(true)
                ->sortable(),

            Column::make('Cliente', 'cliente.nombre')
                ->sortable()
                ->searchable(),

            Column::make('Material', 'material.nombre')
                ->sortable()
                ->searchable(),

            Column::make('Precio', 'precio')
                ->sortable()
                ->format(function ($value) {
                    return '$' . number_format($value, 2);
                }),

            Column::make('Fecha', 'created_at')
                ->sortable()
                ->format(function ($value) {
                    return $value->format('d/m/Y');
                }),

            Column::make('Acciones')
                ->label(function ($row) {
                    return view('admin.preciomateriales.actions', [
                        'precio' => $row
                    ]);
                })
        ];
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return ClienteMaterial::query()
            ->with(['cliente', 'material']);
    }

    public function delete($id)
    {
        ClienteMaterial::find($id)->delete();

        session()->flash('success', 'Precio eliminado correctamente');
    }
}

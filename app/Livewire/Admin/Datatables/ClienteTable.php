<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Cliente;

class ClienteTable extends DataTableComponent
{
    protected $model = Cliente::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("#")
                ->label(fn($row, Column $column) => $this->getRowNumber($row))
                ->excludeFromColumnSelect(),
            Column::make("Id", "id")
                ->hideIf(true)
                ->sortable(),
            Column::make("Cliente", "nombre")
                ->sortable()
                ->searchable(),
            Column::make("Acciones")->label(function ($row) {
                return view('admin.clientes.actions', [
                    'cliente' => $row
                ]);
            })
        ];
    }

    protected function getRowNumber($row): int
    {
        $currentPage = $this->getPage();
        $perPage = $this->getPerPage();
        $index = $this->getRows()->search(fn($item) => $item->id === $row->id);
        
        return ($currentPage - 1) * $perPage + $index + 1;
    }
}
<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Material;

class MaterialTable extends DataTableComponent
{
    protected $model = Material::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->hideIf(true),
            Column::make("Nombre", "nombre") // o el campo que corresponda
                ->sortable()
                ->searchable(),
            Column::make("Acciones")->label(function ($row) {
                return view('admin.materiales.actions', [
                    'material' => $row 
                ]);
            })
        ];
    }
}
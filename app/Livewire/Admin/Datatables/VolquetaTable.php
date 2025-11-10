<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Volqueta;

class VolquetaTable extends DataTableComponent
{
    protected $model = Volqueta::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("PLACA", "placa")
                ->sortable()
                ->searchable(),
            Column::make("PROPIETARIO", "propietario")
                ->sortable()
                ->searchable(),
            Column::make("CONDUCTOR", "conductor")
                ->sortable()
                ->searchable(),
            Column::make("CUBICAJE", "cubicaje")
                ->sortable()
                ->searchable(),
            Column::make("Acciones")->label(function($row){
                return view('admin.volquetas.actions',[
                    'volqueta' => $row
                ]);
            })
        ];
    }
}

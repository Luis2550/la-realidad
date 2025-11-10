<?php

namespace App\Exports;

use App\Models\Venta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VentasClienteExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $ventas;
    protected $cliente;
    protected $mes;
    protected $ano;

    public function __construct($ventas, $cliente, $mes = null, $ano = null)
    {
        $this->ventas = $ventas;
        $this->cliente = $cliente;
        $this->mes = $mes;
        $this->ano = $ano;
    }

    public function collection()
    {
        return $this->ventas;
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Hora',
            'Placa',
            'Conductor',
            'Propietario',
            'Material',
            'Ticket Mina',
            'Ticket Transporte',
            'Cubicaje (m³)',
            'Tipo Volqueta',
            'Origen',
            'Destino',
        ];
    }

    public function map($venta): array
    {
        return [
            $venta->created_at->format('d/m/Y'),
            $venta->hora,
            $venta->volqueta->placa,
            $venta->volqueta->conductor,
            $venta->volqueta->propietario,
            $venta->material,
            $venta->ticket_mina,
            $venta->ticket_transporte,
            $venta->volqueta->cubicaje,
            $venta->tipo_volqueta,
            $venta->origen,
            $venta->destino,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
            ],
        ];
    }

    public function title(): string
    {
        $periodo = '';
        if ($this->mes && $this->ano) {
            $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                     'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            $periodo = " - {$meses[$this->mes]} {$this->ano}";
        } elseif ($this->ano) {
            $periodo = " - {$this->ano}";
        }
        
        return substr($this->cliente->nombre . $periodo, 0, 31);
    }
}
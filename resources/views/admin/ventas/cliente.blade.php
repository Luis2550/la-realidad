<x-admin-layout title="Ventas de {{ $cliente->nombre }}" :breadcrumbs="[
    [
        'name' => 'Inicio',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Ventas',
        'href' => route('admin.ventas.index'),
    ],
    [
        'name' => $cliente->nombre,
    ],
]">

    {{-- Header con información del cliente --}}
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-md">
                    <span class="text-2xl font-bold text-white">
                        {{ substr($cliente->nombre, 0, 1) }}
                    </span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ $cliente->nombre }}
                    </h2>
                    <p class="text-gray-600 text-sm mt-1">
                        📦 {{ $ventas->count() }} ventas registradas
                    </p>
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="flex items-center gap-2">
               

                {{-- Botón Exportar Excel --}}
                <a href="{{ route('admin.ventas.cliente.exportar', ['cliente' => $cliente->id, 'mes' => $mes, 'ano' => $ano]) }}"
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm gap-2">
                    <i class="fa-solid fa-file-excel text-lg"></i>
                    Excel
                </a>
            </div>
        </div>

        @if($mes || $ano)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <span>Filtros aplicados:</span>
                    @if($mes)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Mes: {{ ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'][$mes] }}
                        </span>
                    @endif
                    @if($ano)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Año: {{ $ano }}
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    {{-- Tabla de Ventas --}}
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha/Hora
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Placa
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Conductor
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Propietario
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Material
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ticket Mina
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ticket Transporte
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cubicaje
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($ventas as $venta)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="font-medium">{{ $venta->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $venta->hora }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $venta->volqueta->placa }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $venta->volqueta->conductor }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $venta->volqueta->propietario }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $venta->material }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $venta->ticket_mina }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $venta->ticket_transporte }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $venta->volqueta->cubicaje }} m³
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center space-x-2">
                                    <x-wire-button 
                                        href="{{ route('admin.ventas.print', $venta) }}" 
                                        target="_blank"
                                        green 
                                        xs
                                        title="Imprimir ticket"
                                    >
                                        <i class="fa-solid fa-print"></i>
                                    </x-wire-button>

                                    <x-wire-button 
                                        href="{{ route('admin.ventas.edit', $venta) }}" 
                                        blue 
                                        xs
                                        title="Editar"
                                    >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </x-wire-button>

                                    <form action="{{ route('admin.ventas.destroy', $venta) }}" 
                                          method="POST" 
                                          class="delete-form inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-wire-button 
                                            type="submit" 
                                            red 
                                            xs
                                            title="Eliminar"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </x-wire-button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="text-4xl mb-2">📭</div>
                                <p class="text-gray-600">No hay ventas registradas para este cliente</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>
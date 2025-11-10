<div class="space-y-6">
    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Filtro Mes --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    📅 Mes
                </label>
                <select wire:model.live="selectedMes" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos los meses</option>
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
            </div>

            {{-- Filtro Año --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    📆 Año
                </label>
                <select wire:model.live="selectedAno" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @for ($year = date('Y'); $year >= 2020; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>

            {{-- Botón Limpiar --}}
            <div class="flex items-end">
                <button wire:click="clearFilters" 
                        class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200 font-medium">
                    🔄 Limpiar Filtros
                </button>
            </div>
        </div>

        {{-- Resumen --}}
        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600">
                    <strong>{{ $clientesConVentas->count() }}</strong> clientes con ventas
                </span>
                <span class="text-gray-600">
                    <strong>{{ $clientesConVentas->sum('total_ventas') }}</strong> ventas totales
                </span>
            </div>
        </div>
    </div>

    {{-- Grid de Tarjetas de Clientes --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse ($clientesConVentas as $cliente)
            {{-- Tarjeta de Cliente --}}
            <a href="{{ route('admin.ventas.cliente', ['cliente' => $cliente['id'], 'mes' => $selectedMes, 'ano' => $selectedAno]) }}"
                class="bg-white rounded-lg shadow-sm p-6 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1 hover:border-blue-500 border-2 border-transparent block">
                
                <div class="flex flex-col items-center text-center space-y-3">
                    {{-- Avatar --}}
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-md">
                        <span class="text-2xl font-bold text-white">
                            {{ substr($cliente['nombre'], 0, 1) }}
                        </span>
                    </div>
                    
                    {{-- Nombre del Cliente --}}
                    <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">
                        {{ $cliente['nombre'] }}
                    </h3>
                    
                    {{-- Número de Ventas --}}
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-medium">
                        <span class="mr-1">📦</span>
                        {{ $cliente['total_ventas'] }} {{ $cliente['total_ventas'] == 1 ? 'venta' : 'ventas' }}
                    </div>

                    {{-- Indicador de ver más --}}
                    <div class="text-xs text-blue-600 font-medium flex items-center">
                        Ver detalles
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

        @empty
            <div class="col-span-full bg-white rounded-lg shadow-sm p-12 text-center">
                <div class="text-6xl mb-4">📭</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    No hay ventas registradas
                </h3>
                <p class="text-gray-600">
                    No se encontraron ventas para el período seleccionado
                </p>
            </div>
        @endforelse
    </div>
</div>
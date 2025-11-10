<div class="space-y-6">
    
    <!-- Barra de búsqueda y botón -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
        <div class="flex-1 max-w-full sm:max-w-md">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar cliente..."
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            >
        </div>
        
        <x-wire-button 
            href="{{ route('admin.preciomaterial.create') }}" 
            blue
            class="w-full sm:w-auto justify-center"
        >
            <i class="fa-solid fa-plus mr-2"></i>
            Nuevo Precio
        </x-wire-button>
    </div>

    <!-- Contenedor principal responsive -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Lista de Clientes (Sidebar) - Ahora primero en todos los tamaños -->
        <div class="lg:col-span-4">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-700">
                        Clientes ({{ $clientes->count() }})
                    </h3>
                </div>

                <div class="divide-y divide-gray-200 max-h-[400px] lg:max-h-[600px] overflow-y-auto">
                    @forelse($clientes as $cliente)
                        <button
                            wire:click="seleccionarCliente({{ $cliente->id }})"
                            class="w-full text-left px-4 py-3 hover:bg-gray-50 transition-colors {{ $clienteSeleccionado == $cliente->id ? 'bg-blue-50 border-l-4 border-blue-500' : '' }}"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 text-sm truncate">
                                        {{ $cliente->nombre }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $cliente->precios_materiales_count }} 
                                        {{ Str::plural('material', $cliente->precios_materiales_count) }}
                                    </p>
                                </div>
                                @if($clienteSeleccionado == $cliente->id)
                                    <i class="fa-solid fa-chevron-right text-blue-500 ml-2 flex-shrink-0"></i>
                                @endif
                            </div>
                        </button>
                    @empty
                        <div class="px-4 py-8 text-center text-gray-500">
                            <i class="fa-solid fa-inbox text-3xl mb-2"></i>
                            <p class="text-sm">No hay clientes con precios registrados</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

        <!-- Materiales y Precios del Cliente Seleccionado -->
        <div class="lg:col-span-8">
            
            @if($clienteActual)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-4 sm:px-6 py-4 text-white">
                        <h2 class="text-lg sm:text-xl font-bold truncate">{{ $clienteActual->nombre }}</h2>
                        <p class="text-blue-100 text-xs sm:text-sm mt-1">
                            Precios de materiales registrados
                        </p>
                    </div>

                    <!-- Tabla de Precios - Desktop -->
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Material
                                    </th>
                                    <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Precio
                                    </th>
                                    <th class="hidden md:table-cell px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha Registro
                                    </th>
                                    <th class="px-4 lg:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($precios as $precio)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 lg:px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <i class="fa-solid fa-box text-blue-600"></i>
                                                </div>
                                                <div class="ml-3 lg:ml-4 min-w-0">
                                                    <div class="text-sm font-medium text-gray-900 truncate">
                                                        {{ $precio->material->nombre }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                            <span class="text-base lg:text-lg font-bold text-green-600">
                                                ${{ number_format($precio->precio, 2) }}
                                            </span>
                                        </td>
                                        <td class="hidden md:table-cell px-4 lg:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $precio->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-right">
                                            <div class="flex items-center justify-end space-x-2">
                                                <x-wire-button 
                                                    href="{{ route('admin.preciomaterial.edit', $precio) }}" 
                                                    blue 
                                                    xs>
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </x-wire-button>

                                                <button
                                                    wire:click="eliminar({{ $precio->id }})"
                                                    wire:confirm="¿Estás seguro de eliminar este precio?"
                                                    class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                                                >
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <i class="fa-solid fa-box-open text-4xl text-gray-300 mb-3"></i>
                                            <p class="text-gray-500 mb-4">Este cliente no tiene materiales con precios registrados</p>
                                            <x-wire-button 
                                                href="{{ route('admin.preciomaterial.create') }}" 
                                                blue
                                            >
                                                Agregar Precio
                                            </x-wire-button>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Cards de Precios - Mobile -->
                    <div class="sm:hidden divide-y divide-gray-200">
                        @forelse($precios as $precio)
                            <div class="p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center flex-1 min-w-0">
                                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fa-solid fa-box text-blue-600 text-lg"></i>
                                        </div>
                                        <div class="ml-3 min-w-0">
                                            <h3 class="text-sm font-semibold text-gray-900 truncate">
                                                {{ $precio->material->nombre }}
                                            </h3>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $precio->created_at->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Precio</p>
                                        <p class="text-xl font-bold text-green-600">
                                            ${{ number_format($precio->precio, 2) }}
                                        </p>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <x-wire-button 
                                            href="{{ route('admin.preciomaterial.edit', $precio) }}" 
                                            blue 
                                            xs>
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </x-wire-button>

                                        <button
                                            wire:click="eliminar({{ $precio->id }})"
                                            wire:confirm="¿Estás seguro de eliminar este precio?"
                                            class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-12 text-center">
                                <i class="fa-solid fa-box-open text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500 text-sm mb-4">Este cliente no tiene materiales con precios registrados</p>
                                <x-wire-button 
                                    href="{{ route('admin.preciomaterial.create') }}" 
                                    blue
                                    class="w-full justify-center"
                                >
                                    Agregar Precio
                                </x-wire-button>
                            </div>
                        @endforelse
                    </div>

                    <!-- Paginación -->
                    @if($precios->hasPages())
                        <div class="px-4 sm:px-6 py-4 border-t border-gray-200">
                            {{ $precios->links() }}
                        </div>
                    @endif

                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 sm:p-12 text-center">
                    <i class="fa-solid fa-hand-pointer text-4xl sm:text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2">Selecciona un cliente</h3>
                    <p class="text-sm text-gray-500">Elige un cliente de la lista para ver sus materiales y precios</p>
                </div>
            @endif

        </div>

    </div>

</div>
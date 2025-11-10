<x-admin-layout title="Editar Precio de Material" :breadcrumbs="[
    [
        'name' => 'Inicio',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Precios de Materiales',
        'href' => route('admin.preciomaterial.index'),
    ],
    [
        'name' => 'Editar',
    ],
]">

    <x-wire-card>

        <form action="{{ route('admin.preciomaterial.update', $preciomaterial) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="space-y-6">

                <!-- Información del Cliente y Material (Solo lectura) -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Información de la Relación</h3>
                    
                    <div class="grid lg:grid-cols-2 gap-4">
                        
                        <!-- Cliente -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Cliente
                            </label>
                            <div class="w-full rounded-md border-gray-300 bg-gray-100 px-3 py-2 text-gray-700 shadow-sm">
                                {{ $preciomaterial->cliente->nombre }}
                            </div>
                            <p class="mt-1 text-xs text-gray-500">
                                No se puede modificar el cliente en esta edición
                            </p>
                        </div>

                        <!-- Material -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Material
                            </label>
                            <div class="w-full rounded-md border-gray-300 bg-gray-100 px-3 py-2 text-gray-700 shadow-sm">
                                {{ $preciomaterial->material->nombre }}
                            </div>
                            <p class="mt-1 text-xs text-gray-500">
                                No se puede modificar el material en esta edición
                            </p>
                        </div>

                    </div>
                </div>

                <!-- Campo Precio (Editable) -->
                <div class="max-w-md">
                    <x-wire-input 
                        name="precio" 
                        label="Precio" 
                        type="number" 
                        step="0.01"
                        min="0"
                        max="999999.99"
                        required 
                        :value="old('precio', $preciomaterial->precio)"
                        placeholder="Ingrese el precio"
                        autofocus
                    />
                    <p class="mt-1 text-xs text-gray-500">
                        Precio actual: <span class="font-semibold text-gray-700">${{ number_format($preciomaterial->precio, 2) }}</span>
                    </p>
                </div>

                <!-- Información adicional -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-circle-info text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Información
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Solo puedes modificar el precio. Si necesitas cambiar el cliente o material, debes crear un nuevo registro.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex justify-end gap-2 pt-4 border-t border-gray-200">
                    <x-wire-button 
                        secondary 
                        type="button" 
                        onclick="window.location='{{ route('admin.preciomaterial.index') }}'"
                    >
                        Cancelar
                    </x-wire-button>
                    
                    <x-wire-button blue type="submit">
                        Actualizar Precio
                    </x-wire-button>
                </div>

            </div>

        </form>

    </x-wire-card>

</x-admin-layout>
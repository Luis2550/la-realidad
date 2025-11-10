<x-admin-layout title="Nuevo Precio de Material" :breadcrumbs="[
    [
        'name' => 'Inicio',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Precios de Materiales',
        'href' => route('admin.preciomaterial.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">

    <x-wire-card>

        <form x-data="{
            clientes: [],
            materiales: [],
            clienteId: '{{ old('cliente_id', '') }}',
            materialId: '{{ old('material_id', '') }}',
            sugerenciasClientes: [],
            sugerenciasMateriales: [],
            mostrarSugerenciasClientes: false,
            mostrarSugerenciasMateriales: false,
            indiceSugerenciaCliente: -1,
            indiceSugerenciaMaterial: -1,
            sugerenciaCliente: '',
            sugerenciaMaterial: '',
            clienteNombre: '{{ old('cliente_nombre', '') }}',
            materialNombre: '{{ old('material_nombre', '') }}',
            
            init() {
                this.cargarClientes();
                this.cargarMateriales();
                
                // Restaurar valores si hay errores de validación
                this.$nextTick(() => {
                    if (this.clienteNombre) {
                        this.$refs.clienteInput.value = this.clienteNombre;
                    }
                    if (this.materialNombre) {
                        this.$refs.materialInput.value = this.materialNombre;
                    }
                    if (this.clienteId) {
                        this.$refs.clienteIdInput.value = this.clienteId;
                    }
                    if (this.materialId) {
                        this.$refs.materialIdInput.value = this.materialId;
                    }
                });
            },
            
            cargarClientes() {
                fetch('/admin/api/clientes')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.clientes = data.clientes;
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar clientes:', error);
                    });
            },
            
            cargarMateriales() {
                fetch('/admin/api/materiales')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.materiales = data.materiales;
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar materiales:', error);
                    });
            },
            
            scrollToItemCliente(index) {
                this.$nextTick(() => {
                    const dropdown = this.$refs.dropdownClientes;
                    const item = dropdown?.children[index];
                    if (item && dropdown) {
                        const itemTop = item.offsetTop;
                        const itemBottom = itemTop + item.offsetHeight;
                        const dropdownTop = dropdown.scrollTop;
                        const dropdownBottom = dropdownTop + dropdown.clientHeight;
                        
                        if (itemTop < dropdownTop) {
                            dropdown.scrollTop = itemTop;
                        } else if (itemBottom > dropdownBottom) {
                            dropdown.scrollTop = itemBottom - dropdown.clientHeight;
                        }
                    }
                });
            },
            
            scrollToItemMaterial(index) {
                this.$nextTick(() => {
                    const dropdown = this.$refs.dropdownMateriales;
                    const item = dropdown?.children[index];
                    if (item && dropdown) {
                        const itemTop = item.offsetTop;
                        const itemBottom = itemTop + item.offsetHeight;
                        const dropdownTop = dropdown.scrollTop;
                        const dropdownBottom = dropdownTop + dropdown.clientHeight;
                        
                        if (itemTop < dropdownTop) {
                            dropdown.scrollTop = itemTop;
                        } else if (itemBottom > dropdownBottom) {
                            dropdown.scrollTop = itemBottom - dropdown.clientHeight;
                        }
                    }
                });
            },
            
            buscarClientes(texto) {
                if (!texto) {
                    this.sugerenciasClientes = [];
                    this.mostrarSugerenciasClientes = false;
                    this.indiceSugerenciaCliente = -1;
                    this.sugerenciaCliente = '';
                    return;
                }
                
                const textoBusqueda = texto.toUpperCase();
                this.sugerenciasClientes = this.clientes.filter(c => 
                    c.nombre.toUpperCase().startsWith(textoBusqueda)
                ).slice(0, 10);
                
                // Si hay coincidencia exacta, cerrar el dropdown
                const coincidenciaExacta = this.clientes.find(c => 
                    c.nombre.toUpperCase() === textoBusqueda
                );
                
                if (coincidenciaExacta) {
                    this.$refs.clienteIdInput.value = coincidenciaExacta.id;
                    this.clienteId = coincidenciaExacta.id;
                    this.mostrarSugerenciasClientes = false;
                    this.sugerenciasClientes = [];
                    this.sugerenciaCliente = '';
                    this.indiceSugerenciaCliente = -1;
                    return;
                }
                
                // Sugerencia inline (aparece en el input)
                if (this.sugerenciasClientes.length > 0) {
                    const primerCoincidencia = this.sugerenciasClientes[0].nombre.toUpperCase();
                    this.sugerenciaCliente = primerCoincidencia.substring(textoBusqueda.length);
                } else {
                    this.sugerenciaCliente = '';
                }
                
                this.mostrarSugerenciasClientes = this.sugerenciasClientes.length > 0;
                this.indiceSugerenciaCliente = -1;
            },
            
            seleccionarCliente(cliente) {
                this.$refs.clienteInput.value = cliente.nombre;
                this.$refs.clienteIdInput.value = cliente.id;
                this.clienteId = cliente.id;
                this.clienteNombre = cliente.nombre;
                this.mostrarSugerenciasClientes = false;
                this.sugerenciasClientes = [];
                this.indiceSugerenciaCliente = -1;
                this.sugerenciaCliente = '';
            },
            
            navegarSugerenciasCliente(event) {
                if (event.key === 'Tab' && this.sugerenciaCliente) {
                    event.preventDefault();
                    const textoActual = this.$refs.clienteInput.value;
                    this.$refs.clienteInput.value = textoActual + this.sugerenciaCliente;
                    this.buscarClientes(this.$refs.clienteInput.value);
                    return;
                }
                
                if (!this.mostrarSugerenciasClientes || this.sugerenciasClientes.length === 0) return;
                
                if (event.key === 'ArrowDown') {
                    event.preventDefault();
                    this.indiceSugerenciaCliente = Math.min(this.indiceSugerenciaCliente + 1, this.sugerenciasClientes.length - 1);
                    this.scrollToItemCliente(this.indiceSugerenciaCliente);
                } else if (event.key === 'ArrowUp') {
                    event.preventDefault();
                    this.indiceSugerenciaCliente = Math.max(this.indiceSugerenciaCliente - 1, -1);
                    if (this.indiceSugerenciaCliente >= 0) {
                        this.scrollToItemCliente(this.indiceSugerenciaCliente);
                    }
                } else if (event.key === 'Enter' && this.indiceSugerenciaCliente >= 0) {
                    event.preventDefault();
                    this.seleccionarCliente(this.sugerenciasClientes[this.indiceSugerenciaCliente]);
                } else if (event.key === 'Escape') {
                    this.mostrarSugerenciasClientes = false;
                    this.indiceSugerenciaCliente = -1;
                    this.sugerenciaCliente = '';
                }
            },
            
            buscarMateriales(texto) {
                if (!texto) {
                    this.sugerenciasMateriales = [];
                    this.mostrarSugerenciasMateriales = false;
                    this.indiceSugerenciaMaterial = -1;
                    this.sugerenciaMaterial = '';
                    return;
                }
                
                const textoBusqueda = texto.toUpperCase();
                this.sugerenciasMateriales = this.materiales.filter(m => 
                    m.nombre.toUpperCase().startsWith(textoBusqueda)
                ).slice(0, 10);
                
                // Si hay coincidencia exacta, cerrar el dropdown
                const coincidenciaExacta = this.materiales.find(m => 
                    m.nombre.toUpperCase() === textoBusqueda
                );
                
                if (coincidenciaExacta) {
                    this.$refs.materialIdInput.value = coincidenciaExacta.id;
                    this.materialId = coincidenciaExacta.id;
                    this.mostrarSugerenciasMateriales = false;
                    this.sugerenciasMateriales = [];
                    this.sugerenciaMaterial = '';
                    this.indiceSugerenciaMaterial = -1;
                    return;
                }
                
                // Sugerencia inline (aparece en el input)
                if (this.sugerenciasMateriales.length > 0) {
                    const primerCoincidencia = this.sugerenciasMateriales[0].nombre.toUpperCase();
                    this.sugerenciaMaterial = primerCoincidencia.substring(textoBusqueda.length);
                } else {
                    this.sugerenciaMaterial = '';
                }
                
                this.mostrarSugerenciasMateriales = this.sugerenciasMateriales.length > 0;
                this.indiceSugerenciaMaterial = -1;
            },
            
            seleccionarMaterial(material) {
                this.$refs.materialInput.value = material.nombre;
                this.$refs.materialIdInput.value = material.id;
                this.materialId = material.id;
                this.materialNombre = material.nombre;
                this.mostrarSugerenciasMateriales = false;
                this.sugerenciasMateriales = [];
                this.indiceSugerenciaMaterial = -1;
                this.sugerenciaMaterial = '';
                
                // Enfocar el input de precio después de seleccionar el material
                this.$nextTick(() => {
                    this.$refs.precioInput?.focus();
                });
            },
            
            navegarSugerenciasMaterial(event) {
                if (event.key === 'Tab' && this.sugerenciaMaterial) {
                    event.preventDefault();
                    const textoActual = this.$refs.materialInput.value;
                    this.$refs.materialInput.value = textoActual + this.sugerenciaMaterial;
                    this.buscarMateriales(this.$refs.materialInput.value);
                    return;
                }
                
                if (!this.mostrarSugerenciasMateriales || this.sugerenciasMateriales.length === 0) return;
                
                if (event.key === 'ArrowDown') {
                    event.preventDefault();
                    this.indiceSugerenciaMaterial = Math.min(this.indiceSugerenciaMaterial + 1, this.sugerenciasMateriales.length - 1);
                    this.scrollToItemMaterial(this.indiceSugerenciaMaterial);
                } else if (event.key === 'ArrowUp') {
                    event.preventDefault();
                    this.indiceSugerenciaMaterial = Math.max(this.indiceSugerenciaMaterial - 1, -1);
                    if (this.indiceSugerenciaMaterial >= 0) {
                        this.scrollToItemMaterial(this.indiceSugerenciaMaterial);
                    }
                } else if (event.key === 'Enter' && this.indiceSugerenciaMaterial >= 0) {
                    event.preventDefault();
                    this.seleccionarMaterial(this.sugerenciasMateriales[this.indiceSugerenciaMaterial]);
                } else if (event.key === 'Escape') {
                    this.mostrarSugerenciasMateriales = false;
                    this.indiceSugerenciaMaterial = -1;
                    this.sugerenciaMaterial = '';
                }
            }
        }" 
        action="{{ route('admin.preciomaterial.store') }}" 
        method="POST"
        @click.away="mostrarSugerenciasClientes = false; mostrarSugerenciasMateriales = false;">

            @csrf

            <div class="space-y-6">

                <!-- Cliente y Material -->
                <div class="grid lg:grid-cols-2 gap-4">
                    
                    <!-- Input Cliente con autocompletado predictivo -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Cliente <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <!-- Input sugerencia (texto gris de fondo) -->
                            <input 
                                type="text"
                                :value="$refs.clienteInput ? $refs.clienteInput.value + sugerenciaCliente : ''"
                                disabled
                                class="absolute inset-0 w-full rounded-md border-gray-300 shadow-sm uppercase text-gray-400 pointer-events-none"
                                style="background: transparent; border-color: transparent;"
                            />
                            <!-- Input real -->
                            <input 
                                x-ref="clienteInput"
                                type="text" 
                                name="cliente_nombre"
                                placeholder="Escriba para buscar cliente..."
                                @input="$event.target.value = $event.target.value.toUpperCase(); buscarClientes($event.target.value); clienteNombre = $event.target.value;"
                                @keydown="navegarSugerenciasCliente($event)"
                                @focus="if($event.target.value) buscarClientes($event.target.value)"
                                value="{{ old('cliente_nombre') }}"
                                required
                                autocomplete="off"
                                class="relative w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 uppercase bg-transparent {{ $errors->has('cliente_id') ? 'border-red-500' : '' }}"
                            />
                        </div>
                        
                        <!-- Dropdown de sugerencias -->
                        <div 
                            x-show="mostrarSugerenciasClientes" 
                            x-transition
                            x-ref="dropdownClientes"
                            class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto scroll-smooth"
                        >
                            <template x-for="(cliente, index) in sugerenciasClientes" :key="cliente.id">
                                <div 
                                    @click="seleccionarCliente(cliente)"
                                    :class="{'bg-blue-100': index === indiceSugerenciaCliente}"
                                    class="px-4 py-2 cursor-pointer hover:bg-blue-50 transition-colors"
                                    x-text="cliente.nombre"
                                ></div>
                            </template>
                        </div>
                        
                        <input type="hidden" name="cliente_id" x-ref="clienteIdInput" value="{{ old('cliente_id') }}" required>
                        @error('cliente_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500" x-show="clientes.length > 0">
                            <span x-text="clientes.length"></span> clientes disponibles
                            <span x-show="sugerenciaCliente" class="text-blue-600">• Presione Tab para autocompletar</span>
                        </p>
                    </div>

                    <!-- Input Material con autocompletado predictivo -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Material <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <!-- Input sugerencia (texto gris de fondo) -->
                            <input 
                                type="text"
                                :value="$refs.materialInput ? $refs.materialInput.value + sugerenciaMaterial : ''"
                                disabled
                                class="absolute inset-0 w-full rounded-md border-gray-300 shadow-sm uppercase text-gray-400 pointer-events-none"
                                style="background: transparent; border-color: transparent;"
                            />
                            <!-- Input real -->
                            <input 
                                x-ref="materialInput"
                                type="text" 
                                name="material_nombre"
                                placeholder="Escriba para buscar material..."
                                @input="$event.target.value = $event.target.value.toUpperCase(); buscarMateriales($event.target.value); materialNombre = $event.target.value;"
                                @keydown="navegarSugerenciasMaterial($event)"
                                @focus="if($event.target.value) buscarMateriales($event.target.value)"
                                value="{{ old('material_nombre') }}"
                                required
                                autocomplete="off"
                                class="relative w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 uppercase bg-transparent {{ $errors->has('material_id') ? 'border-red-500' : '' }}"
                            />
                        </div>
                        
                        <!-- Dropdown de sugerencias -->
                        <div 
                            x-show="mostrarSugerenciasMateriales" 
                            x-transition
                            x-ref="dropdownMateriales"
                            class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto scroll-smooth"
                        >
                            <template x-for="(material, index) in sugerenciasMateriales" :key="material.id">
                                <div 
                                    @click="seleccionarMaterial(material)"
                                    :class="{'bg-blue-100': index === indiceSugerenciaMaterial}"
                                    class="px-4 py-2 cursor-pointer hover:bg-blue-50 transition-colors"
                                    x-text="material.nombre"
                                ></div>
                            </template>
                        </div>
                        
                        <input type="hidden" name="material_id" x-ref="materialIdInput" value="{{ old('material_id') }}" required>
                        @error('material_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500" x-show="materiales.length > 0">
                            <span x-text="materiales.length"></span> materiales disponibles
                            <span x-show="sugerenciaMaterial" class="text-blue-600">• Presione Tab para autocompletar</span>
                        </p>
                    </div>

                </div>

                <!-- Campo Precio -->
                <div class="max-w-md">
                    <x-wire-input 
                        x-ref="precioInput"
                        name="precio" 
                        label="Precio" 
                        type="number" 
                        step="0.01"
                        min="0"
                        max="999999.99"
                        required 
                        :value="old('precio')"
                        placeholder="Ingrese el precio"
                    />
                    <p class="mt-1 text-xs text-gray-500">
                        Precio por unidad o volumen del material
                    </p>
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
                        Guardar Precio
                    </x-wire-button>
                </div>

            </div>

        </form>

    </x-wire-card>

</x-admin-layout>
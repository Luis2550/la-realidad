<x-admin-layout title="Nueva Venta" :breadcrumbs="[
    [
        'name' => 'Inicio',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Ventas',
        'href' => route('admin.ventas.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">

    <x-wire-card>

        <form x-data="{
            clientes: [],
            clienteId: '',
            volquetas: [],
            materiales: [],
            sugerenciasClientes: [],
            sugerenciasVolquetas: [],
            sugerenciasMateriales: [],
            mostrarSugerenciasClientes: false,
            mostrarSugerenciasVolquetas: false,
            mostrarSugerenciasMateriales: false,
            indiceSugerenciaCliente: -1,
            indiceSugerenciaVolqueta: -1,
            indiceSugerenciaMaterial: -1,
            sugerenciaCliente: '',
            sugerenciaVolqueta: '',
            sugerenciaMaterial: '',
            
            init() {
                this.cargarClientes();
                this.cargarVolquetas();
                this.cargarMateriales();
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
            
            cargarVolquetas() {
                fetch('/admin/api/volquetas')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.volquetas = data.volquetas;
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar volquetas:', error);
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

            async cargarSiguienteTicket(clienteId) {
                if (!clienteId) {
                    this.$refs.ticketMinaInput.value = '000001';
                    return;
                }

                try {
                    const response = await fetch(`/admin/api/ventas/siguiente-ticket?cliente_id=${clienteId}`);
                    const data = await response.json();
                    if (data.success) {
                        this.$refs.ticketMinaInput.value = data.ticket;
                    }
                } catch (error) {
                    console.error('Error al cargar siguiente ticket:', error);
                    this.$refs.ticketMinaInput.value = '000001';
                }
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
            
            scrollToItemVolqueta(index) {
                this.$nextTick(() => {
                    const dropdown = this.$refs.dropdownVolquetas;
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
                
                const coincidenciaExacta = this.clientes.find(c => 
                    c.nombre.toUpperCase() === textoBusqueda
                );
                
                if (coincidenciaExacta) {
                    this.clienteId = coincidenciaExacta.id;
                    this.cargarSiguienteTicket(coincidenciaExacta.id);
                    this.mostrarSugerenciasClientes = false;
                    this.sugerenciasClientes = [];
                    this.sugerenciaCliente = '';
                    this.indiceSugerenciaCliente = -1;
                    return;
                }
                
                if (this.sugerenciasClientes.length > 0) {
                    const primerCoincidencia = this.sugerenciasClientes[0].nombre.toUpperCase();
                    this.sugerenciaCliente = primerCoincidencia.substring(textoBusqueda.length);
                } else {
                    this.sugerenciaCliente = '';
                    this.clienteId = '';
                    this.cargarSiguienteTicket(null);
                }
                
                this.mostrarSugerenciasClientes = this.sugerenciasClientes.length > 0;
                this.indiceSugerenciaCliente = -1;
            },
            
            seleccionarCliente(cliente) {
                this.$refs.clienteInput.value = cliente.nombre;
                this.clienteId = cliente.id;
                this.cargarSiguienteTicket(cliente.id);
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
            
            buscarVolquetas(texto) {
                if (!texto) {
                    this.sugerenciasVolquetas = [];
                    this.mostrarSugerenciasVolquetas = false;
                    this.indiceSugerenciaVolqueta = -1;
                    this.sugerenciaVolqueta = '';
                    return;
                }
                
                const textoBusqueda = texto.toUpperCase().replace(/[^A-Z0-9-]/g, '');
                this.sugerenciasVolquetas = this.volquetas.filter(v => 
                    v.placa.toUpperCase().startsWith(textoBusqueda)
                ).slice(0, 10);
                
                const coincidenciaExacta = this.volquetas.find(v => 
                    v.placa.toUpperCase() === textoBusqueda
                );
                
                if (coincidenciaExacta) {
                    this.$refs.propietarioInput.value = coincidenciaExacta.propietario || '';
                    this.$refs.conductorInput.value = coincidenciaExacta.conductor || '';
                    this.$refs.cubicajeInput.value = coincidenciaExacta.cubicaje || '';
                    this.mostrarSugerenciasVolquetas = false;
                    this.sugerenciasVolquetas = [];
                    this.sugerenciaVolqueta = '';
                    this.indiceSugerenciaVolqueta = -1;
                    return;
                }
                
                if (this.sugerenciasVolquetas.length > 0) {
                    const primerCoincidencia = this.sugerenciasVolquetas[0].placa.toUpperCase();
                    this.sugerenciaVolqueta = primerCoincidencia.substring(textoBusqueda.length);
                } else {
                    this.sugerenciaVolqueta = '';
                }
                
                this.mostrarSugerenciasVolquetas = this.sugerenciasVolquetas.length > 0;
                this.indiceSugerenciaVolqueta = -1;
            },
            
            seleccionarVolqueta(volqueta) {
                this.$refs.placaInput.value = volqueta.placa;
                this.$refs.propietarioInput.value = volqueta.propietario || '';
                this.$refs.conductorInput.value = volqueta.conductor || '';
                this.$refs.cubicajeInput.value = volqueta.cubicaje || '';
                this.mostrarSugerenciasVolquetas = false;
                this.sugerenciasVolquetas = [];
                this.indiceSugerenciaVolqueta = -1;
                this.sugerenciaVolqueta = '';
            },
            
            navegarSugerenciasVolqueta(event) {
                if (event.key === 'Tab' && this.sugerenciaVolqueta) {
                    event.preventDefault();
                    const textoActual = this.$refs.placaInput.value;
                    this.$refs.placaInput.value = textoActual + this.sugerenciaVolqueta;
                    this.buscarVolquetas(this.$refs.placaInput.value);
                    return;
                }
                
                if (!this.mostrarSugerenciasVolquetas || this.sugerenciasVolquetas.length === 0) return;
                
                if (event.key === 'ArrowDown') {
                    event.preventDefault();
                    this.indiceSugerenciaVolqueta = Math.min(this.indiceSugerenciaVolqueta + 1, this.sugerenciasVolquetas.length - 1);
                    this.scrollToItemVolqueta(this.indiceSugerenciaVolqueta);
                } else if (event.key === 'ArrowUp') {
                    event.preventDefault();
                    this.indiceSugerenciaVolqueta = Math.max(this.indiceSugerenciaVolqueta - 1, -1);
                    if (this.indiceSugerenciaVolqueta >= 0) {
                        this.scrollToItemVolqueta(this.indiceSugerenciaVolqueta);
                    }
                } else if (event.key === 'Enter' && this.indiceSugerenciaVolqueta >= 0) {
                    event.preventDefault();
                    this.seleccionarVolqueta(this.sugerenciasVolquetas[this.indiceSugerenciaVolqueta]);
                } else if (event.key === 'Escape') {
                    this.mostrarSugerenciasVolquetas = false;
                    this.indiceSugerenciaVolqueta = -1;
                    this.sugerenciaVolqueta = '';
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
                
                const coincidenciaExacta = this.materiales.find(m => 
                    m.nombre.toUpperCase() === textoBusqueda
                );
                
                if (coincidenciaExacta) {
                    this.mostrarSugerenciasMateriales = false;
                    this.sugerenciasMateriales = [];
                    this.sugerenciaMaterial = '';
                    this.indiceSugerenciaMaterial = -1;
                    return;
                }
                
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
                this.mostrarSugerenciasMateriales = false;
                this.sugerenciasMateriales = [];
                this.indiceSugerenciaMaterial = -1;
                this.sugerenciaMaterial = '';
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
        action="{{ route('admin.ventas.store') }}" 
        method="POST"
        @click.away="mostrarSugerenciasClientes = false; mostrarSugerenciasVolquetas = false; mostrarSugerenciasMateriales = false;">

            @csrf
            @method('POST')

            <div class="space-y-6">

                <!-- Cliente y Volqueta -->
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
                                placeholder="Escriba para buscar o ingresar nuevo cliente..."
                                @input="$event.target.value = $event.target.value.toUpperCase(); buscarClientes($event.target.value);"
                                @keydown="navegarSugerenciasCliente($event)"
                                @focus="if($event.target.value) buscarClientes($event.target.value)"
                                value="{{ old('cliente_nombre') }}"
                                required
                                autocomplete="off"
                                class="relative w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 uppercase bg-transparent"
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
                        
                        @error('cliente_nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            <span x-show="sugerenciaCliente" class="text-blue-600">Presione Tab para autocompletar</span>
                            <span x-show="!sugerenciaCliente">Puede ingresar un cliente nuevo</span>
                        </p>
                    </div>

                    <!-- Placa con autocompletado predictivo -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Placa <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <!-- Input sugerencia (texto gris de fondo) -->
                            <input 
                                type="text"
                                :value="$refs.placaInput ? $refs.placaInput.value + sugerenciaVolqueta : ''"
                                disabled
                                class="absolute inset-0 w-full rounded-md border-gray-300 shadow-sm uppercase text-gray-400 pointer-events-none"
                                style="background: transparent; border-color: transparent;"
                            />
                            <!-- Input real -->
                            <input 
                                x-ref="placaInput"
                                type="text" 
                                name="placa"
                                value="{{ old('placa') }}"
                                required
                                placeholder="Escriba para buscar o ingresar nueva placa..."
                                maxlength="8"
                                autocomplete="off"
                                @input="let v = $event.target.value.toUpperCase().replace(/[^A-Z0-9]/g,''); if(v.length > 3) v = v.slice(0,3) + '-' + v.slice(3); $event.target.value = v.slice(0,8); buscarVolquetas($event.target.value);"
                                @keydown="navegarSugerenciasVolqueta($event)"
                                @focus="if($event.target.value) buscarVolquetas($event.target.value)"
                                class="relative w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 uppercase bg-transparent"
                            />
                        </div>
                        
                        <!-- Dropdown de sugerencias -->
                        <div 
                            x-show="mostrarSugerenciasVolquetas" 
                            x-transition
                            x-ref="dropdownVolquetas"
                            class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto scroll-smooth"
                        >
                            <template x-for="(volqueta, index) in sugerenciasVolquetas" :key="volqueta.id">
                                <div 
                                    @click="seleccionarVolqueta(volqueta)"
                                    :class="{'bg-blue-100': index === indiceSugerenciaVolqueta}"
                                    class="px-4 py-2 cursor-pointer hover:bg-blue-50 transition-colors"
                                >
                                    <div class="font-semibold" x-text="volqueta.placa"></div>
                                    <div class="text-xs text-gray-600">
                                        <span x-text="volqueta.propietario"></span> - 
                                        <span x-text="volqueta.conductor"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        @error('placa')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            <span x-show="sugerenciaVolqueta" class="text-blue-600">Presione Tab para autocompletar</span>
                            <span x-show="!sugerenciaVolqueta">Puede ingresar una placa nueva</span>
                        </p>
                    </div>

                </div>

                <!-- Datos de la Volqueta (editables) -->
                <div class="grid lg:grid-cols-3 gap-4">
                    
                    <x-wire-input 
                        x-ref="propietarioInput"
                        name="propietario" 
                        label="Propietario" 
                        type="text" 
                        required 
                        :value="old('propietario')"
                        placeholder="Ingrese propietario"
                        x-on:input="$event.target.value = $event.target.value.toUpperCase()"
                    />

                    <x-wire-input 
                        x-ref="conductorInput"
                        name="conductor" 
                        label="Conductor" 
                        type="text" 
                        required 
                        :value="old('conductor')"
                        placeholder="Ingrese conductor"
                        x-on:input="$event.target.value = $event.target.value.toUpperCase()"
                    />

                    <x-wire-input 
                        x-ref="cubicajeInput"
                        name="cubicaje" 
                        label="Cubicaje" 
                        type="number" 
                        step="0.001"
                        required 
                        :value="old('cubicaje')"
                        placeholder="Ingrese cubicaje"
                    />

                </div>

                <!-- Tickets -->
                <div class="grid lg:grid-cols-2 gap-4">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Ticket Mina <span class="text-red-500">*</span>
                        </label>
                        <input 
                            x-ref="ticketMinaInput"
                            type="text" 
                            name="ticket_mina"
                            value="{{ old('ticket_mina', '000001') }}"
                            required
                            readonly
                            class="w-full rounded-md border-gray-300 shadow-sm bg-gray-50 focus:border-blue-500 focus:ring-blue-500"
                        />
                        @error('ticket_mina')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Se genera automáticamente según el cliente</p>
                    </div>

                    <x-wire-input 
                        name="ticket_transporte" 
                        label="Ticket Transporte" 
                        type="text" 
                        :value="old('ticket_transporte')"
                        placeholder="Ticket transporte (opcional)"
                        x-on:input="$event.target.value = $event.target.value.toUpperCase()"
                    />

                </div>

                <!-- Material y Tipo -->
                <div class="grid lg:grid-cols-2 gap-4">
                    
                    <!-- Material con autocompletado -->
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
                                name="material"
                                placeholder="Escriba para buscar o ingresar nuevo material..."
                                @input="$event.target.value = $event.target.value.toUpperCase(); buscarMateriales($event.target.value);"
                                @keydown="navegarSugerenciasMaterial($event)"
                                @focus="if($event.target.value) buscarMateriales($event.target.value)"
                                value="{{ old('material') }}"
                                required
                                autocomplete="off"
                                class="relative w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 uppercase bg-transparent"
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
                        
                        @error('material')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            <span x-show="sugerenciaMaterial" class="text-blue-600">Presione Tab para autocompletar</span>
                            <span x-show="!sugerenciaMaterial">Puede ingresar un material nuevo</span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Tipo de Volqueta <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="tipo_volqueta" 
                            required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Seleccione tipo</option>
                            <option value="SENCILLA" {{ old('tipo_volqueta') == 'SENCILLA' ? 'selected' : '' }}>SENCILLA</option>
                            <option value="MULA SENCILLA" {{ old('tipo_volqueta') == 'MULA SENCILLA' ? 'selected' : '' }}>MULA SENCILLA</option>
                            <option value="MULA" {{ old('tipo_volqueta') == 'MULA' ? 'selected' : '' }}>MULA</option>
                            <option value="BAÑERA" {{ old('tipo_volqueta') == 'BAÑERA' ? 'selected' : '' }}>BAÑERA</option>
                        </select>
                        @error('tipo_volqueta')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Origen y Destino -->
                <div class="grid lg:grid-cols-2 gap-4">
                    
                    <x-wire-input 
                        name="origen" 
                        label="Origen" 
                        type="text" 
                        required 
                        :value="old('origen', 'MINA LA REALIDAD')"
                        placeholder="Lugar de origen"
                        x-on:input="$event.target.value = $event.target.value.toUpperCase()"
                    />

                    <x-wire-input 
                        name="destino" 
                        label="Destino" 
                        type="text" 
                        required 
                        :value="old('destino')"
                        placeholder="Lugar de destino"
                        x-on:input="$event.target.value = $event.target.value.toUpperCase()"
                    />

                </div>

                <!-- Fecha y Hora -->
                <div class="grid lg:grid-cols-2 gap-4">
                    
                    <x-wire-input 
                        name="fecha" 
                        label="Fecha" 
                        type="date" 
                        required 
                        :value="old('fecha', date('Y-m-d'))"
                    />

                    <x-wire-input 
                        name="hora" 
                        label="Hora" 
                        type="time" 
                        required 
                        :value="old('hora', date('H:i'))"
                    />

                </div>

                <!-- Botón Guardar -->
                <div class="flex justify-end gap-2">
                    <x-wire-button 
                        secondary 
                        type="button" 
                        onclick="window.location='{{ route('admin.ventas.index') }}'"
                    >
                        Cancelar
                    </x-wire-button>
                    
                    <x-wire-button blue type="submit">
                        Guardar Venta
                    </x-wire-button>
                </div>

            </div>

        </form>

    </x-wire-card>

</x-admin-layout>
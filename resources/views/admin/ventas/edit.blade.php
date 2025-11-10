<x-admin-layout title="Volquetas" :breadcrumbs="[
    [
        'name' => 'Inicio',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Clientes',
        'href' => route('admin.clientes.index'),
    ],
    [
        'name' => 'Editar',
    ],
]">


    <x-wire-card>

        <form x-data action="{{ route('admin.clientes.update', $cliente) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="space-y-4">


                <div class="grid lg:grid-cols-2 gap-4">

                    <x-wire-input name="nombre" label="Nombre" type="text" required :value="old('nombre')"
                        placeholder="Ingrese el nombre del cliente"
                        x-on:input="$event.target.value = $event.target.value.toUpperCase()" />

                </div>

                <x-wire-button blue type="submit" class="flex justify-end">
                    Actualizar
                </x-wire-button>

            </div>


        </form>

    </x-wire-card>


</x-admin-layout>

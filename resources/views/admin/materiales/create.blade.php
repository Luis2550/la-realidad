<x-admin-layout title="Material" :breadcrumbs="[
    [
        'name' => 'Inicio',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Material',
        'href' => route('admin.material.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">


    <x-wire-card>

        <form x-data action="{{ route('admin.material.store') }}" method="POST">

            @csrf
            @method('POST')

            <div class="space-y-4">


                <div class="grid lg:grid-cols-2 gap-4">


                    <x-wire-input name="nombre" label="Nombre" type="text" required :value="old('nombre')"
                        placeholder="Ingrese el nombre del material"
                        x-on:input="$event.target.value = $event.target.value.toUpperCase()" />

                 
                </div>

                <x-wire-button blue type="submit" class="flex justify-end">
                    Guardar
                </x-wire-button>

            </div>




        </form>

    </x-wire-card>


</x-admin-layout>

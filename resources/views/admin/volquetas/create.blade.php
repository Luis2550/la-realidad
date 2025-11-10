<x-admin-layout title="Volquetas" :breadcrumbs="[
    [
        'name' => 'Inicio',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Volquetas',
        'href' => route('admin.volquetas.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">


    <x-wire-card>

        <form x-data action="{{ route('admin.volquetas.store') }}" method="POST">

            @csrf
            @method('POST')

            <div class="space-y-4">


                <div class="grid lg:grid-cols-2 gap-4">


                    <x-wire-input name="placa" label="Placa" type="text" required :value="old('placa')"
                        placeholder="ABC-1234" maxlength="8"
                        x-on:input="let v = $event.target.value.toUpperCase().replace(/[^A-Z0-9]/g,''); if(v.length > 3) v = v.slice(0,3) + '-' + v.slice(3); $event.target.value = v.slice(0,8);" />


                    <x-wire-input name="propietario" label="Propietario" type="text" required :value="old('propietario')"
                        placeholder="Ingrese el propietario"
                        x-on:input="$event.target.value = $event.target.value.toUpperCase()" />

                    <x-wire-input name="conductor" label="Conductor" type="text" required :value="old('conductor')"
                        placeholder="Ingrese el conductor"
                        x-on:input="$event.target.value = $event.target.value.toUpperCase()" />


                    <x-wire-input name="cubicaje" label="Cubicaje" type="number" step="0.01" required
                        :value="old('cubicaje')" placeholder="Ingrese el cubicaje" />


                </div>

                <x-wire-button blue type="submit" class="flex justify-end">
                    Guardar
                </x-wire-button>

            </div>




        </form>

    </x-wire-card>





</x-admin-layout>

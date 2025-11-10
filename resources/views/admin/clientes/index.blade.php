<x-admin-layout title="Clientes" :breadcrumbs="[
    [
        'name' => 'Inicio',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Clientes',
    ],
]">


    <x-slot name="action">

        <x-wire-button info label="Nuevo" :href="route('admin.clientes.create')" />

    </x-slot>


    @livewire('admin.datatables.cliente-table', [])


</x-admin-layout>

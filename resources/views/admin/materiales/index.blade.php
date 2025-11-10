<x-admin-layout title="Material" :breadcrumbs="[
    [
        'name' => 'Inicio',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Material',
    ],
]">


    <x-slot name="action">

        <x-wire-button info label="Nuevo" :href="route('admin.material.create')" />

    </x-slot>


    @livewire('admin.datatables.material-table', [])


</x-admin-layout>

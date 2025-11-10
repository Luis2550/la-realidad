<x-admin-layout title="Volquetas" :breadcrumbs="[
    [
        'name' => 'Inicio',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Volquetas',
    ],
]">

    <x-slot name="action">

        <x-wire-button info label="Nuevo" :href="route('admin.volquetas.create')" />

    </x-slot>

    @livewire('admin.datatables.volqueta-table', [])


</x-admin-layout>

<x-admin-layout title="Precios de Materiales" :breadcrumbs="[
    [
        'name' => 'Inicio',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Precios de Materiales',
    ],
]">

    @livewire('admin.precio-material-list')

</x-admin-layout>
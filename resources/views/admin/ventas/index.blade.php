<x-admin-layout title="Ventas" :breadcrumbs="[
    [
        'name' => 'Inicio',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Ventas',
    ],
]">

    <x-slot name="action">
        <x-wire-button info label="Nuevo" :href="route('admin.ventas.create')" />
    </x-slot>

    {{-- ✅ Directiva sin carpeta ventas --}}
    @livewire('admin.venta-filter')

    @if (session('print_url'))
        <script>
            window.open('{{ session('print_url') }}', '_blank');
        </script>
    @endif

</x-admin-layout>
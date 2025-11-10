<div class="flex items-center space-x-2">

    <x-wire-button 
        href="{{ route('admin.ventas.print', $venta) }}" 
        target="_blank"
        green 
        xs
        title="Imprimir ticket"
    >
        <i class="fa-solid fa-print"></i>
    </x-wire-button>

    <x-wire-button href="{{ route('admin.ventas.edit', $venta) }}" blue xs>
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    <form action="{{ route('admin.ventas.destroy', $venta) }}" method="POST" class="delete-form">

        @csrf
        @method('DELETE')

        <x-wire-button type="submit" red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>

</div>
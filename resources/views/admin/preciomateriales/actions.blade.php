<div class="flex items-center space-x-2">

    <x-wire-button 
        href="{{ route('admin.preciomaterial.edit', $precio) }}" 
        blue 
        xs>
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    <form action="{{ route('admin.preciomaterial.destroy', $precio) }}" method="POST" class="delete-form">

        @csrf
        @method('DELETE')

        <x-wire-button type="submit" red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>

</div>
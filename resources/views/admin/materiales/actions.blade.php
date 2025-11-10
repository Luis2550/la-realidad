<div class="flex items-center space-x-2">

    <x-wire-button href="{{ route('admin.material.edit', $material) }}" blue xs>
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    <form action="{{ route('admin.material.destroy', $material) }}" method="POST" class="delete-form">

        @csrf
        @method('DELETE')

        <x-wire-button type="submit" red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>

</div>
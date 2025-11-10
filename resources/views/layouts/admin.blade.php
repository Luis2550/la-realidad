@props([
    'title' => config('app.name', 'laravel'),
    'breadcrumbs' => [],
])


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Styles -->
    @livewireStyles


</head>

<body class="font-sans antialiased">

    @include('admin.includes.navigation')
    @include('admin.includes.sidebar')


    <div class="p-4 sm:ml-64">

        <div class="mt-14 flex items-center">

            @include('admin.includes.breadcrumb')

            @isset($action)
                <div class="ml-auto">

                    {{ $action }}

                </div>
            @endisset


        </div>

        {{ $slot }}
    </div>

    @if (session('swal'))
        <script>
            Swal.fire({
                icon: '{{ session('swal.icon') }}',
                title: '{{ session('swal.title') }}',
                text: '{{ session('swal.text') }}',
                timer: 2500,
                showConfirmButton: true
            });
        </script>
    @endif


    @stack('modals')

    @livewireScripts
    {{-- Wire Ui --}}
    <wireui:scripts />

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    <script>
    // Usar delegación de eventos en el documento completo
    document.addEventListener('submit', function(e) {
        // Verificar si el elemento que disparó el submit tiene la clase delete-form
        if (e.target.classList.contains('delete-form')) {
            e.preventDefault();

            Swal.fire({
                title: "¿Seguro que deseas eliminar?",
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            });
        }
    });
</script>

</body>

</html>

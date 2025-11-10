  @php

      $links = [
        
          [
              'name' => 'Inicio',
              'icon' => 'fa-solid fa-house',
              'href' => route('admin.dashboard'),
              'active' => request()->routeIs('admin.dashboard'),
          ],
          [
              'name' => 'Volquetas',
              'icon' => 'fa-solid fa-truck',
              'href' => route('admin.volquetas.index'),
              'active' => request()->routeIs('admin.volquetas.*'),
          ],
          [
              'name' => 'Clientes',
              'icon' => 'fa-solid fa-users',
              'href' => route('admin.clientes.index'),
              'active' => request()->routeIs('admin.clientes.*'),
          ], 
          [
              'name' => 'Material',
              'icon' => 'fa-solid fa-store', 
              'href' => route('admin.material.index'),
              'active' => request()->routeIs('admin.material.*'),
          ], 
          [
              'name' => 'Precio Material',
              'icon' => 'fa-solid fa-money-check',
              'href' => route('admin.preciomaterial.index'),
              'active' => request()->routeIs('admin.preciomaterial.*'),
          ], 
           [
              'name' => 'Ventas',
              'icon' => 'fa-solid fa-money-check-dollar',
              'href' => route('admin.ventas.index'),
              'active' => request()->routeIs('admin.ventas.*'),
          ], 
      ];

  @endphp


  <aside id="logo-sidebar"
      class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
      aria-label="Sidebar">
      <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
          <ul class="space-y-2 font-medium">

              @foreach ($links as $link)
                  <li>
                      <a href="{{ $link['href'] }}"
                          class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-400 dark:hover:bg-gray-700 group {{ $link['active'] ? 'bg-gray-300' : '' }}">

                          <span class="w-6 h-6 inline-flex justify-center items-center">
                              <i class="{{ $link['icon'] }} text-lg"></i>
                          </span>
                          <span class="ms-3">{{ $link['name'] }}</span>
                      </a>
                  </li>
              @endforeach

          </ul>
      </div>
  </aside>

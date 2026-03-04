<div class="container-scroller">
  <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">

  <div class="row p-0 m-0 proBanner" id="proBanner">
    <div class="col-md-12 p-0 m-0">
      <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
        <div class="ps-lg-1">
          <div class="d-flex align-items-center justify-content-between">
            <p class="mb-0 font-weight-medium me-3 buy-now-text"></p>
            <a class="btn me-2 buy-now-btn border-0"></a>
          </div>
        </div>

        <div class="d-flex align-items-center justify-content-between">
          <a aria-label="Home"><i class="mdi mdi-home me-3 text-white"></i></a>
          <button id="bannerClose" class="btn border-0 p-0" aria-label="Cerrar banner">
            <i class="mdi mdi-close text-white me-0"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Sidebar -->
  <nav class="sidebar sidebar-offcanvas" id="sidebar" aria-label="Panel lateral">
    <div style="height: 140px; width:140px; margin-left: 30px;">
      <a class="sidebar-brand brand-logo" href="{{ route('redirects') }}">
        <img src="{{ asset('assets/images/logo.png') }}" alt="{{ config('app.name') }} logo">
      </a>
    </div>

    <ul class="nav">

      {{-- ADMIN: todos los módulos --}}
      @role('admin')
        <li class="nav-item menu-items {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.users.index') }}">
            <span class="menu-icon"><i class="fas fa-users"></i></span>
            <span class="menu-title">Usuarios</span>
          </a>
        </li>

        <li class="nav-item menu-items {{ request()->routeIs('admin.foods.*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.foods.index') }}">
            <span class="menu-icon"><i class="fas fa-utensils"></i></span>
            <span class="menu-title">Menus</span>
          </a>
        </li>

        <li class="nav-item menu-items {{ request()->routeIs('admin.chefs.*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.chefs.index') }}">
            <span class="menu-icon"><i class="fas fa-user-tie"></i></span>
            <span class="menu-title">Chefs</span>
          </a>
        </li>

        <li class="nav-item menu-items {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.orders.index') }}">
            <span class="menu-icon"><i class="fas fa-receipt"></i></span>
            <span class="menu-title">Ordenes</span>
          </a>
        </li>
      @endrole

      {{-- ADMIN y MESERO: reservaciones y mesas --}}
      @hasanyrole('admin|mesero')
        <li class="nav-item menu-items {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.reservations.index') }}">
            <span class="menu-icon"><i class="fas fa-calendar-check"></i></span>
            <span class="menu-title">Reservaciones</span>
          </a>
        </li>

        <li class="nav-item menu-items {{ request()->routeIs('admin.tables.*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.tables.index') }}">
            <span class="menu-icon"><i class="fas fa-chair"></i></span>
            <span class="menu-title">Mesas</span>
          </a>
        </li>
      @endhasanyrole

      {{-- CHEF: perfil y menus (chef comparte menus con admin) --}}
      @role('chef')
        <li class="nav-item menu-items {{ request()->routeIs('admin.foods.*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.foods.index') }}">
            <span class="menu-icon"><i class="fas fa-utensils"></i></span>
            <span class="menu-title">Menus</span>
          </a>
        </li>


        <li class="nav-item menu-items {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.profile.index') }}">
            <span class="menu-icon"><i class="fas fa-user-cog"></i></span>
            <span class="menu-title">Perfil</span>
          </a>
        </li>
      @endrole

    </ul>
  </nav>

  {{-- SCRIPTS --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(function() {
      var selectedClass = "";
      $("p").click(function() {
        selectedClass = $(this).attr("data-rel");
        $("#portfolio").fadeTo(50, 0.1);
        $("#portfolio div").not("." + selectedClass).fadeOut();
        setTimeout(function() {
          $("." + selectedClass).fadeIn();
          $("#portfolio").fadeTo(50, 1);
        }, 500);
      });
    });

    const themeIcon = document.getElementById('theme-icon');
    if (themeIcon) {
      let isDarkMode = false;
      themeIcon.addEventListener('click', () => {
        isDarkMode = !isDarkMode;
        document.body.classList.toggle('dark-mode', isDarkMode);
        if (isDarkMode) themeIcon.classList.replace('fa-moon', 'fa-sun');
        else themeIcon.classList.replace('fa-sun', 'fa-moon');
      });
    }
  </script>
</div>

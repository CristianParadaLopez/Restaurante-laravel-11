<nav class="sidebar sidebar-offcanvas" id="sidebar">

    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Dalezius">
            <span>Dalezius</span>
        </a>
    </div>

    <ul class="nav flex-column">

        <li class="nav-section-label">General</li>

        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-th-large nav-icon"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @role('admin')
        <li class="nav-section-label">Gestión</li>

        <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                <i class="fas fa-users nav-icon"></i>
                <span>Usuarios</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.chefs.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.chefs.index') }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <span>Chefs</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.orders.index') }}">
                <i class="fas fa-receipt nav-icon"></i>
                <span>Órdenes</span>
            </a>
        </li>
        @endrole

        @hasanyrole('admin|chef')
        <li class="nav-item {{ request()->routeIs('admin.foods.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.foods.index') }}">
                <i class="fas fa-utensils nav-icon"></i>
                <span>Menús</span>
            </a>
        </li>
        @endhasanyrole

        @hasanyrole('admin|mesero')
        <li class="nav-section-label">Operaciones</li>

        <li class="nav-item {{ request()->routeIs('admin.tables.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.tables.index') }}">
                <i class="fas fa-chair nav-icon"></i>
                <span>Mesas</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.reservations.index') }}">
                <i class="fas fa-calendar-check nav-icon"></i>
                <span>Reservaciones</span>
            </a>
        </li>
        @endhasanyrole

        @role('chef')
        <li class="nav-section-label">Mi cuenta</li>

        <li class="nav-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.profile.index') }}">
                <i class="fas fa-user-cog nav-icon"></i>
                <span>Mi Perfil</span>
            </a>
        </li>
        @endrole

    </ul>

    {{-- Botón salir al final --}}
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-sidebar-logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Cerrar sesión</span>
            </button>
        </form>
    </div>

</nav>
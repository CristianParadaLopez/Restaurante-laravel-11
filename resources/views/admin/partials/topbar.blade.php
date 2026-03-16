<nav class="navbar admin-topbar">
    <div class="topbar-left">
        {{-- Toggle sidebar mobile --}}
        <button class="navbar-toggler" type="button" data-toggle="minimize">
            <i class="fas fa-bars"></i>
        </button>
        <span class="topbar-page-title">@yield('title', 'Dashboard')</span>
    </div>

    <div class="topbar-right">
        <a href="{{ url('/') }}" class="topbar-btn" title="Ir al sitio web">
            <i class="fas fa-home"></i>
        </a>

        <div class="topbar-user">
            <div class="topbar-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="topbar-user-info">
                <span class="topbar-user-name">{{ Auth::user()->name }}</span>
                <span class="topbar-user-role">{{ ucfirst(Auth::user()->usertype) }}</span>
            </div>
        </div>
    </div>
</nav>
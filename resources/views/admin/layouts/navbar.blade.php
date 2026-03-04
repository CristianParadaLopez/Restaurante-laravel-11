@role('admin')
<li><a href="{{ route('admin.users.index') }}">Usuarios</a></li>
<li><a href="{{ route('admin.orders.index') }}">Ordenes</a></li>
@endrole

@role('chef')
<li><a href="{{ route('admin.foods.index') }}">Menus</a></li>
<li><a href="{{ route('admin.profile.index') }}">Perfil</a></li>
@endrole

@role('mesero')
<li><a href="{{ route('admin.reservations.index') }}">Reservaciones</a></li>
<li><a href="{{ route('admin.tables.index') }}">Mesas</a></li>
@endrole

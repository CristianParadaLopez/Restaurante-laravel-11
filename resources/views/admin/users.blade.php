@extends('admin.layouts.admin')
@section('title', 'Usuarios')
@section('content')

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:20px; font-weight:500; color:var(--text); margin:0;">Gestión de Usuarios</h1>
        <p style="font-size:12px; color:var(--muted); margin:2px 0 0;">Administra los usuarios del sistema</p>
    </div>
    <button class="btn-gold" data-bs-toggle="modal" data-bs-target="#createUserModal">
        <i class="fas fa-plus" style="margin-right:6px;"></i>Nuevo Usuario
    </button>
</div>

<div class="stat-card" style="padding:0; overflow:hidden;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nombre</th><th>Email</th><th>Rol</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="badge-status badge-pending">{{ ucfirst($user->usertype) }}</span></td>
                <td style="display:flex; gap:8px;">
                    <button class="btn-outline" style="padding:4px 10px; font-size:11px;"
                        data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">
                        <i class="fas fa-pen"></i> Editar
                    </button>
                    @if($user->usertype != 'admin')
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="margin:0;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-outline" style="padding:4px 10px; font-size:11px; color:#fca5a5; border-color:rgba(239,68,68,0.3);"
                            onclick="return confirm('¿Eliminar usuario?')">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                    @endif
                </td>
            </tr>

            {{-- Modal editar --}}
            <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1">
                <div class="modal-dialog"><div class="modal-content admin-modal">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Usuario</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-body">
                            <div class="admin-field"><label>Nombre</label>
                                <input type="text" name="name" class="admin-input" value="{{ $user->name }}" required></div>
                            <div class="admin-field"><label>Email</label>
                                <input type="email" name="email" class="admin-input" value="{{ $user->email }}" required></div>
                            <div class="admin-field"><label>Rol</label>
                                <select name="usertype" class="admin-input">
                                    <option value="user" {{ $user->usertype=='user'?'selected':'' }}>Usuario</option>
                                    <option value="chef" {{ $user->usertype=='chef'?'selected':'' }}>Chef</option>
                                    <option value="mesero" {{ $user->usertype=='mesero'?'selected':'' }}>Mesero</option>
                                    <option value="admin" {{ $user->usertype=='admin'?'selected':'' }}>Admin</option>
                                </select></div>
                            <div class="admin-field"><label>Nueva Contraseña <span style="color:var(--muted)">(opcional)</span></label>
                                <input type="password" name="password" class="admin-input"></div>
                            <input type="hidden" name="password_confirmation" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-outline" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn-gold">Guardar</button>
                        </div>
                    </form>
                </div></div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal crear --}}
<div class="modal fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content admin-modal">
        <div class="modal-header">
            <h5 class="modal-title">Nuevo Usuario</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="admin-field"><label>Nombre</label>
                    <input type="text" name="name" class="admin-input" required></div>
                <div class="admin-field"><label>Email</label>
                    <input type="email" name="email" class="admin-input" required></div>
                <div class="admin-field"><label>Rol</label>
                    <select name="usertype" class="admin-input">
                        <option value="user">Usuario</option>
                        <option value="chef">Chef</option>
                        <option value="mesero">Mesero</option>
                        <option value="admin">Admin</option>
                    </select></div>
                <div class="admin-field"><label>Contraseña</label>
                    <input type="password" name="password" class="admin-input" required></div>
                <div class="admin-field"><label>Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="admin-input" required></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn-gold">Crear Usuario</button>
            </div>
        </form>
    </div></div>
</div>

@endsection
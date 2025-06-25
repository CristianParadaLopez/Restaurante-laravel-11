<x-app-layout>
</x-app-layout>

<!DOCTYPE html>
<html lang="es">
<head>
    @include("admin.admincss")
    <style>
        /* Estilos personalizados */
        .user-table-container {
            margin-top: 50px;
            padding: 20px;
            color: #ffffff !important;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-table th {
            background-color: #9c49fb;
            color: #ffffff !important;
            padding: 10px;
            text-align: center;
        }

        .user-table td {
            padding: 10px;
            text-align: center;
        }

        .btn-action {
            margin: 0 5px;
        }

        .btn-edit {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-edit:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-create {
            background-color: #9c49fb;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 20px;
            text-decoration: none;
        }

        .btn-create:hover {
            background-color: #734e9e;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        @include("admin.navbar")

        <div class="container user-table-container">
            <h2 class="text-center mb-4">Gestión de Usuarios</h2>
            <table class="table table-bordered user-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody style="color: #fff">
                    @foreach($data as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->usertype) }}</td>
                        <td>
                            <!-- Botón para abrir el modal de editar usuario -->
                            <button class="btn-edit btn-action" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}" onclick="populateEditModal({{ $user->id }})">Editar</button>
                            @if($user->usertype != "admin")
                            <form action="{{ url('/deleteuser', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete btn-action" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</button>
                            </form>
                            @else
                            <span>No disponible</span>
                            @endif
                        </td>
                    </tr>

                    <!-- Modal para editar usuario -->
                    <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ url('/updateUser', $user->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="usertype" class="form-label">Rol</label>
                                            <select class="form-select" id="usertype" name="usertype">
                                                <option value="user" {{ $user->usertype == "user" ? "selected" : "" }}>Usuario</option>
                                                <option value="chef" {{ $user->usertype == "chef" ? "selected" : "" }}>Chef</option>
                                                <option value="waiter" {{ $user->usertype == "waiter" ? "selected" : "" }}>Mesero</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Contraseña (si desea cambiarla)</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>

            <!-- Botón para abrir el modal de crear usuario -->
            <button class="btn-create" data-bs-toggle="modal" data-bs-target="#createUserModal">Crear Nuevo Usuario</button>
        </div>
    </div>

    <!-- Modal para crear usuario -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Crear Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('/storeUser') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="usertype" class="form-label">Rol</label>
                            <select class="form-select" id="usertype" name="usertype">
                                <option value="user">Usuario</option>
                                <option value="chef">Chef</option>
                                <option value="waiter">Mesero</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include("admin.adminscript")
</body>
</html>

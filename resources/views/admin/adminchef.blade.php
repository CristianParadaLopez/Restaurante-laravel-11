<x-app-layout>
</x-app-layout>

<!DOCTYPE html>
<html lang="es">
<head>
    @include("admin.admincss")
    <style>
        .chef-card {
            margin-bottom: 20px;
        }
        .chef-card .card-body {
            background-color: rgba(229, 2, 250, 0.144);
            border: 2px solid #000000;
            border-radius: 5px;
        }
        .chef-card .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #9c49fb;
        }
        .chef-card .btn-action {
            background: #9c49fb !important;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        @include("admin.navbar")

        <div class="content-wrapper">
            <h1>Administración de Chefs</h1>
            <div class="row">
                @foreach($chefs as $chef)  <!-- Iteramos sobre todos los chefs -->
                    <div class="col-md-4 mb-4">
                        <div class="card chef-card">
                            <div class="card-body">
                                <!-- Imagen del Chef -->
                                <img src="/chefs/{{ $chef->image ?: 'default-profile.png' }}" alt="Imagen del Chef" class="profile-image">
                                <h5 class="card-title">{{ $chef->first_name }} {{ $chef->last_name }}</h5>
                                <p class="card-text">Especialidad: {{ $chef->specialty }}</p>
                                <p class="card-text">Área: {{ ucfirst($chef->area) }}</p>

                                <!-- Botones para ver detalles, editar y eliminar -->
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $chef->id }}">Ver Detalles</button>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $chef->id }}">Editar</button>
                                
                                <!-- Formulario de eliminación -->
                                <form action="{{ url('/deletechef', $chef->id) }}" method="POST" class="d-inline">
                                    
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para ver detalles -->
                    <div  class="modal fade" id="viewModal{{ $chef->id }}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div style="background: #9c49fb; color: white" class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewModalLabel">Detalles del Chef</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Descripción:</strong> {{ $chef->description }}</p>
                                    <p><strong>Fecha de creación:</strong> {{ $chef->created_at }}</p>
                                    <p><strong>Última actualización:</strong> {{ $chef->updated_at }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para editar -->
                    <div class="modal fade" id="editModal{{ $chef->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Editar Chef</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ url('/updatechef', $chef->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">Primer Nombre</label>
                                            <input style="background: #9c49fb; color: white" type="text" name="first_name" id="first_name" class="form-control" value="{{ $chef->first_name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Apellido</label>
                                            <input style="background: #9c49fb; color: white" type="text" name="last_name" id="last_name" class="form-control" value="{{ $chef->last_name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="specialty" class="form-label">Especialidad</label>
                                            <input style="background: #9c49fb; color: white" type="text" name="specialty" id="specialty" class="form-control" value="{{ $chef->specialty }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Descripción</label>
                                            <textarea style="background: #9c49fb; color: white" name="description" id="description" class="form-control">{{ $chef->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="area" class="form-label">Área</label>
                                            <select style="background: #9c49fb; color: white" name="area" id="area" class="form-control" required>
                                                <option value="preparacion" {{ $chef->area == 'preparacion' ? 'selected' : '' }}>Preparación</option>
                                                <option value="cocinar" {{ $chef->area == 'cocinar' ? 'selected' : '' }}>Cocinar</option>
                                                <option value="servir" {{ $chef->area == 'servir' ? 'selected' : '' }}>Servir</option>
                                                <option value="almacenamiento" {{ $chef->area == 'almacenamiento' ? 'selected' : '' }}>Almacenamiento</option>
                                                <option value="lavar" {{ $chef->area == 'lavar' ? 'selected' : '' }}>Lavar</option>
                                                <option value="pedidos" {{ $chef->area == 'pedidos' ? 'selected' : '' }}>Pedidos</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Imagen del Chef</label>
                                            <input style="background: #9c49fb; color: white" type="file" name="image" id="image" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include("admin.adminscript")
</body>
</html>

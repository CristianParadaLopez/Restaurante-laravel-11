<x-app-layout>
</x-app-layout>

<!DOCTYPE html>
<html lang="es">
<head>
    @include("chef.chefcss")
    <style>
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #9c49fb;
        }
        .profile-container {
            text-align: center;
            margin-top: 20px;
        }
        .card {
            background-color: rgba(229, 2, 250, 0.144);
            border: 2px solid #000000;
            border-radius: 5px;
            margin-top: 20px;
        }
        .boton {
            background: #9c49fb !important; 
            border-radius: 5px;
        }
    </style>
</head>
<body>
   <div class="container p-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Perfil de Chef</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($chefProfile)
        <div class="card mb-4 p-3">
            <div class="d-flex align-items-center gap-4">
                <div>
                    @if($chefProfile->image)
                        <img src="{{ asset('chefs/' . $chefProfile->image) }}" alt="Imagen del Chef" class="rounded-circle" style="width:150px;height:150px;object-fit:cover;border:4px solid #9c49fb;">
                    @else
                        <img src="{{ asset('images/default-profile.png') }}" alt="Imagen por defecto" class="rounded-circle" style="width:150px;height:150px;object-fit:cover;border:4px solid #9c49fb;">
                    @endif
                </div>

                <div>
                    <h2 style="color:#9c49fb">{{ $chefProfile->first_name }} {{ $chefProfile->last_name }}</h2>
                    <p>Especialidad: {{ $chefProfile->specialty }}</p>
                    <p>Área: {{ ucfirst($chefProfile->area) }}</p>
                </div>
            </div>

            <hr>

            <div>
                <h5>Descripción</h5>
                <p>{{ $chefProfile->description }}</p>

                <div class="mt-3">
                    <!-- Editar (GET) -->
                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">Editar Perfil</a>

                    <!-- Eliminar (DELETE) -->
                    <form action="{{ route('admin.profile.destroy') }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar perfil?')">Eliminar perfil</button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="card p-3">
            <h4>Crear Perfil de Chef</h4>
            HOLA
            <form method="POST" action="{{ route('admin.profile.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="first_name" class="form-label">Primer Nombre</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Apellido</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="specialty" class="form-label">Especialidad</label>
                    <input type="text" id="specialty" name="specialty" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea id="description" name="description" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label for="area" class="form-label">Área</label>
                    <select id="area" name="area" class="form-control" required>
                        <option value="preparacion">Preparación</option>
                        <option value="cocinar">Cocinar</option>
                        <option value="servir">Servir</option>
                        <option value="almacenamiento">Almacenamiento</option>
                        <option value="lavar">Lavar</option>
                        <option value="pedidos">Pedidos</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Imagen del Chef</label>
                    <input type="file" id="image" name="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">Guardar Perfil</button>
            </form>
        </div>
    @endif
    @include("chef.chefscript")
</body>
</html>

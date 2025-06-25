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
        .boton{
            background: #9c49fb !important; 
            border-radius: 5px;
            
            
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        @include("chef.chefnavbar")

        <div class="content-wrapper">
            @if($chef) <!-- Si el chef ya tiene un perfil -->
                <div class="profile-container">
                    @if($chef->image)
                        <img src="/chefs/{{ $chef->image }}" alt="Imagen del Chef" class="profile-image">
                    @else
                        <img src="/images/default-profile.png" alt="Imagen del Chef" class="profile-image">
                    @endif
                    <h2 style="color: #9c49fb">{{ $chef->first_name }} {{ $chef->last_name }}</h2>
                    <p style="color: #f3f3f3">Especialidad: {{ $chef->specialty }}</p>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detalles del Perfil</h5>
                        <p><strong>Descripción:</strong> {{ $chef->description }}</p>
                        <p><strong>Área:</strong> {{ ucfirst($chef->area) }}</p>
                        <p><strong>Fecha de creación:</strong> {{ $chef->created_at }}</p>
                        <p><strong>Última actualización:</strong> {{ $chef->updated_at }}</p>

                        <!-- Botón para editar -->
                        <form action="{{ route('chef.profile.edit') }}" method="GET" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-primary boton">Editar Perfil</button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Si no tiene un perfil, mostrar el formulario de creación -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Crear Perfil de Chef</h5>
                        <form method="POST" action="{{ route('chef.profile.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="first_name">Primer Nombre</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="last_name">Apellido</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="specialty">Especialidad</label>
                                <input type="text" name="specialty" id="specialty" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Descripción</label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="area">Área</label>
                                <select name="area" id="area" class="form-control" required>
                                    <option value="preparacion">Preparación</option>
                                    <option value="cocinar">Cocinar</option>
                                    <option value="servir">Servir</option>
                                    <option value="almacenamiento">Almacenamiento</option>
                                    <option value="lavar">Lavar</option>
                                    <option value="pedidos">Pedidos</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="image">Imagen del Chef</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar Perfil</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include("chef.chefscript")
</body>
</html>

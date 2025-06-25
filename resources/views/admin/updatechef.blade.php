<x-app-layout>
    
</x-app-layout>
<!DOCTYPE html>
<html lang="es">
  <head>
    <base href="/public">
    <!-- Aqui incluimos los estilos -->
    @include("admin.admincss")
  </head>
  <body>
    <div class="container-scroller">
        <!-- Aqui incluimos el Navbar -->
        @include("admin.navbar")

        <div style="position: relative; top: 60px; right: -150px">
            <form action="{{ url('/updatefoodchef', $data->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div>
                    <label>Nombre del Chef</label>
                    <input style="color:black" type="text" name="name" value="{{ $data->name }}" required>
                </div>
                <div>
                    <label>Especialidad</label>
                    <input style="color:black" type="text" name="speciality" value="{{ $data->speciality }}" required>
                </div>
                <div>
                    <label>Imagen actual</label>
                    <img height="200" width="200" src="/chefimage/{{ $data->image }}" alt="Imagen actual">
                </div>
                <div>
                    <label>Nueva imagen</label>
                    <input type="file" name="image" required>
                </div>
                <div>
                    <input type="submit" value="Guardar" required>
                </div>
            </form>
          </div>  
    </div>
    <!-- Aqui incluimos los scripts del estilo -->
    @include("admin.adminscript")
  </body>
</html>
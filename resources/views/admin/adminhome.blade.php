<x-app-layout>
    
</x-app-layout>
<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Aqui incluimos los estilos -->
    @include("admin.admincss")
  </head>
  <body>
    <div class="container-scroller">
        <!-- Aqui incluimos el Navbar -->
        @include("admin.navbar")

    </div>
    
    <!-- Aqui incluimos los scripts del estilo -->
    @include("admin.adminscript")
  </body>
</html>
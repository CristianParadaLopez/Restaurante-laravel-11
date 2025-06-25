<x-app-layout>
</x-app-layout>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Estilos personalizados -->
    @include("mesero.meserocss")
    <style>
      .mesa {
        width: 100px;
        height: 100px;
        margin: 10px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        font-weight: bold;
        font-size: 14px;
        color: white;
        position: relative;
        overflow: hidden;
        text-shadow: 2px 2px 0px rgb(0, 0, 0);
        cursor: pointer;
      }
      
      /* Colores según el estado */
      .disponible {
        background: url('/mesas/mesa.png') no-repeat center center;
        background-size: cover;
        border: solid #00ff2a;
      }

      .ocupada {
        background: url('/mesas/mesa.png') no-repeat center center;
        background-size: cover;
        border:  solid #ff0000;
      }

      .reservada {
        background: url('/mesas/mesa.png') no-repeat center center;
        background-size: cover;
        color: rgb(255, 255, 255);
        border: solid #d9ff00;
      }

      /* Estilo para los iconos en la esquina */
      .mesa .icono {
        position: absolute;
        top: 5px;
        right: 5px;
        font-size: 20px;
      }

      /* Ajustar el contenido dentro de la mesa */
      .mesa-content {
        position: absolute;
        bottom: 5px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        width: 100%;
        padding: 2px;
        font-size: 10px;
        border-radius: 0 0 8px 8px;
      }

      .titulo-area {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
      }
    </style>
</head>
<body>
  <div class="container-scroller">
      <!-- Navbar -->
      @include("mesero.meseronavbar")
<!-- Modal para mostrar información de la mesa -->
<div class="modal fade" id="mesaModal" tabindex="-1" aria-labelledby="mesaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="mesaModalLabel">Detalles de la Mesa</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <!-- Aquí se mostrará la información de la mesa -->
              <div id="mesa-details">
                  <!-- Contenido dinámico -->
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
      </div>
  </div>
</div>

      <div class="container mt-4">
          <!-- Selector de vista por Área o Estado -->
          <form method="GET" action="{{ route('meserohome') }}">
            <div class="form-group">
                <label  for="viewOption">Ver mesas por:</label>
                <select style="color: black" name="viewOption" onchange="this.form.submit()">
                    <option value="area" {{ $viewOption == 'area' ? 'selected' : '' }}>Por Área</option>
                    <option value="status" {{ $viewOption == 'status' ? 'selected' : '' }}>Por Estado</option>
                </select>
            </div>
        </form>

          <!-- Sección de mesas según el filtro seleccionado -->
          @php
              $viewOption = request()->get('viewOption', 'area'); // Valor por defecto: 'area'

              if ($viewOption == 'status') {
                  $mesas = $tables->sortBy('status'); // Ordenar por estado (disponible, ocupada, reservada)
              } else {
                  $mesas = $tables; // Mostrar las mesas sin ordenar por estado
              }
          @endphp

          @if ($viewOption == 'area')
              @php
                  $areas = ['terraza', 'interior', 'exterior'];
              @endphp

              @foreach ($areas as $area)
                  <div class="mesa-container">
                      <div class="titulo-area">Área: {{ ucfirst($area) }}</div>
                      <div class="d-flex flex-wrap">
                          @foreach ($mesas->where('type', $area) as $table)
                          <div class="mesa {{ $table->status }}" onclick="showMesaDetails({{ $table->id }}, '{{ $table->name }}', '{{ $table->number }}', '{{ ucfirst($table->type) }}', '{{ ucfirst($table->status) }}', '{{ $table->seats }}')">
                              <!-- Iconos en las esquinas -->
                              @if ($table->status == 'disponible')
                                  <i class="fas fa-check-circle icono" style="color: green;"></i>
                              @elseif ($table->status == 'ocupada')
                                  <i class="fas fa-exclamation-circle icono" style="color: red;"></i>
                              @elseif ($table->status == 'reservada')
                                  <i class="fas fa-bookmark icono" style="color: yellow;"></i>
                              @endif
                            
                            <!-- Contenido de la mesa -->
                            #{{ $table->number }}<br>
                            {{ $table->name }}<br>
                            Asientos: {{ $table->seats }}
                          </div>
                          @endforeach
                      </div>
                  </div>
              @endforeach
          @elseif ($viewOption == 'status')
              @php
                  $statuses = ['disponible', 'ocupada', 'reservada'];
              @endphp

              @foreach ($statuses as $status)
                  <div class="mesa-container">
                      <div class="titulo-area">Estado: {{ ucfirst($status) }}</div>
                      <div class="d-flex flex-wrap">
                          @foreach ($mesas->where('status', $status) as $table)
                          <div class="mesa {{ $table->status }}" onclick="showMesaDetails({{ $table->id }}, '{{ $table->name }}', '{{ $table->number }}', '{{ ucfirst($table->type) }}', '{{ ucfirst($table->status) }}', '{{ $table->seats }}')">
                              <!-- Iconos en las esquinas -->
                              @if ($table->status == 'disponible')
                                  <i class="fas fa-check-circle icono" style="color: green;"></i>
                              @elseif ($table->status == 'ocupada')
                                  <i class="fas fa-exclamation-circle icono" style="color: red;"></i>
                              @elseif ($table->status == 'reservada')
                                  <i class="fas fa-bookmark icono" style="color: yellow;"></i>
                              @endif
                            
                            <!-- Contenido de la mesa -->
                            #{{ $table->number }}<br>
                            {{ $table->name }}<br>
                            Asientos: {{ $table->seats }}
                          </div>
                          @endforeach
                      </div>
                  </div>
              @endforeach
          @endif
      </div>
  </div>

  <!-- Scripts -->
  @include("mesero.meseroscript")
  <script>
    function showMesaDetails(id, name, number, type, status, seats) {
    // Construir el contenido de la tarjeta con los detalles de la mesa
    const mesaDetails = `
        <div class="card cardN ${status}">
            <div style="background: #9c49fb" class="card-body">
                <h5 class="card-title">${name}</h5>
                <p class="card-text">Número: ${number}</p>
                <p class="card-text">Tipo: ${type}</p>
                <p class="card-text">Asientos: ${seats}</p>
                
                <!-- Formulario para cambiar el estado de la mesa -->
                <form method="POST" action="{{ route('updateTableStatus') }}">
                    @csrf
                    <input type="hidden" name="id" value="${id}">
                    
                    <!-- Selector de estado -->
                    <label for="status">Estado:</label>
                    <select style="background: #9c49fb; color: white; border: 2px solid #000000; border-radius: 8px;" name="status" id="status" class="form-control">
                        <option value="disponible" ${status == 'disponible' ? 'selected' : ''}>Disponible</option>
                        <option value="ocupada" ${status == 'ocupada' ? 'selected' : ''}>Ocupada</option>
                        <option value="reservada" ${status == 'reservada' ? 'selected' : ''}>Reservada</option>
                    </select>

                    <!-- Botón para guardar los cambios -->
                    <button type="submit" class="btn btn-success btn-sm mt-3">Guardar Cambios</button>
                </form>
            </div>
        </div>
    `;

    // Insertar los detalles de la mesa en el modal
    document.getElementById('mesa-details').innerHTML = mesaDetails;

    // Mostrar el modal
    var myModal = new bootstrap.Modal(document.getElementById('mesaModal'));
    myModal.show();
}

</script>


</body>
</html>

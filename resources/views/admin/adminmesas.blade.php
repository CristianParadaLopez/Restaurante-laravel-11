<x-app-layout></x-app-layout>

<!DOCTYPE html>
<html lang="es">
<head>
    @include("admin.admincss")
    <style>
        .disponible {
       
       border: solid #00ff2a;
     }

     .ocupada {
       
       border: solid #ff0000;
     }

     .reservada {
      
       border: solid #d9ff00;
     }
        .btn-success{
            background: #9c49fb !important;
        }
        input::placeholder {
    color: rgb(255, 255, 255) !important;  /* Cambia el color del placeholder a negro */
  opacity: 1; /* Asegura que el color se muestre claramente */
}
    </style>
</head>
<body>
    <div class="container-scroller">
        @include("admin.navbar")

        <div class="container mt-5">
            <h1 class="mb-4">Administración de Mesas</h1>

            <!-- Formulario para agregar una nueva mesa -->
            <form action="{{ route('adminmesas') }}" method="POST" class="mb-5">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <input style="background: #9c49fb; color: white" type="text" name="name" class="form-control" placeholder="Nombre" required>
                    </div>
                    <div class="col-md-2">
                        <input style="background: #9c49fb; color: white" type="text" name="number" class="form-control" placeholder="Número de Mesa" required>
                    </div>
                    <div class="col-md-3">
                        <select style="background: #9c49fb; color: white" name="type" class="form-control" required>
                            <option value="" disabled selected>Tipo de Mesa</option>
                            <option value="terraza">Terraza</option>
                            <option value="interior">Interior</option>
                            <option value="exterior">Exterior</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input style="background: #9c49fb; color: white" type="number" name="seats" class="form-control" placeholder="Número de Asientos" required>
                    </div>
                    <div class="col-md-2">
                        <select style="background: #9c49fb; color: white" name="status" class="form-control" required>
                            <option value="disponible">Disponible</option>
                            <option value="ocupada">Ocupada</option>
                            <option value="reservada">Reservada</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-3">Agregar Mesa</button>
            </form>

            <!-- Mostrar mesas -->
            <div class="row">
                @foreach ($tables as $table)
                <div class="col-md-4 mb-4">
                    <div class="card cardN {{ $table->status }}" >
                        <div class="card-body">
                            <h5 class="card-title">{{ $table->name }}</h5>
                            <p class="card-text">Número: {{ $table->number }}</p>
                            <p class="card-text">Tipo: {{ ucfirst($table->type) }}</p>
                            <p class="card-text">Estado: {{ ucfirst($table->status) }}</p>
                            <p class="card-text">Asientos: {{ $table->seats }}</p>
                    
                            @if ($table->status == 'reservada' && $table->reservation)
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#reservationModal{{ $table->id }}">Ver Reservación</button>
                            @endif
                    
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $table->id }}">Editar</button>
                            <form action="{{ route('adminmesasdelete', $table->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>

<!-- Modal para mostrar detalles de la reservación -->
@if ($table->status == 'reservada' && $table->reservation)
<div class="modal fade" id="reservationModal{{ $table->id }}" tabindex="-1" aria-labelledby="reservationModalLabel{{ $table->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reservationModalLabel{{ $table->id }}">Detalles de la Reservación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nombre:</strong> {{ $table->reservation->name }}</p>
                <p><strong>Email:</strong> {{ $table->reservation->email }}</p>
                <p><strong>Teléfono:</strong> {{ $table->reservation->phone }}</p>
                <p><strong>Invitados:</strong> {{ $table->reservation->guest }}</p>
                <p><strong>Fecha:</strong> {{ $table->reservation->date }}</p>
                <p><strong>Hora:</strong> {{ $table->reservation->time }}</p>
            </div>
            <div class="modal-footer">
                <button 
                    type="button" 
                    class="btn btn-success" 
                    onclick="markAsUsed({{ $table->id }})">
                    Marcar como Utilizada
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endif
  
                <!-- Modal para editar mesa -->
                <div class="modal fade" id="editModal{{ $table->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $table->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('adminmesasupdate', $table->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $table->id }}">Editar Mesa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nombre</label>
                                        <input style="background: #9c49fb; color: white" type="text" name="name" class="form-control" value="{{ $table->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="number" class="form-label">Número de Mesa</label>
                                        <input style="background: #9c49fb; color: white" type="text" name="number" class="form-control" value="{{ $table->number }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Tipo de Mesa</label>
                                        <select style="background: #9c49fb; color: white" name="type" class="form-control" required>
                                            <option value="terraza" {{ $table->type == 'terraza' ? 'selected' : '' }}>Terraza</option>
                                            <option value="interior" {{ $table->type == 'interior' ? 'selected' : '' }}>Interior</option>
                                            <option value="exterior" {{ $table->type == 'exterior' ? 'selected' : '' }}>Exterior</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="seats" class="form-label">Número de Asientos</label>
                                        <input style="background: #9c49fb; color: white" type="number" name="seats" class="form-control" value="{{ $table->seats }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Estado</label>
                                        <select style="background: #9c49fb; color: white" name="status" class="form-control" required>
                                            <option value="disponible" {{ $table->status == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                            <option value="ocupada" {{ $table->status == 'ocupada' ? 'selected' : '' }}>Ocupada</option>
                                            <option value="reservada" {{ $table->status == 'reservada' ? 'selected' : '' }}>Reservada</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
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

    <script>
        function markAsUsed(tableId) {
            if (confirm("¿Estás seguro de que deseas marcar esta mesa como utilizada?")) {
                fetch(`/tables/${tableId}/mark-as-used`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Mesa marcada como utilizada correctamente.");
                        location.reload(); // Recarga la página para reflejar los cambios
                    } else {
                        alert("Hubo un error al marcar la mesa como utilizada.");
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        }
    </script>
    
</body>
</html>

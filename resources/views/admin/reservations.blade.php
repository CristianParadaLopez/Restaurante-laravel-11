<x-app-layout>
</x-app-layout>
<!DOCTYPE html>
<html lang="es">
  <head>
    @include("admin.admincss")
    <style>
      /* Estilo para la tabla */
      table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
      }
      
      th, td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
      }

      th {
        background-color: #f4f4f4;
      }
      .table-wrapper {
  max-height: 500px;
  overflow-y: auto;
}

      .reservations-card, .tables-card {
        cursor: pointer;        
        margin-bottom: 10px;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        padding: 10px;
      }

      .reservations-card .card-body, .tables-card .card-body {
        padding: 5px 10px;
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        height: 100%;
        text-align: center;
      }

      .reservations-card h5, .tables-card h5 {
        font-size: 1rem;
        margin-bottom: 5px;
      }

      .reservations-card p, .tables-card p {
        font-size: 0.9rem;
        margin: 3px 0;
      }

      .tables-card {
       background: #17a2b8
        border: 2px solid #28a745;
      }

      .assigned-reservation {
        background-color: #28a745;
        color: white;
      }

      .not-assigned {
        background-color: #dc3545;
        color: white;
      }

      .tables-card:hover, .reservations-card:hover {
        transform: translateY(-5px);
      }

      .tables-card.assigned-table {
        background-color: #17a2b8;
      }

      .tables-card.available-table {
        background-color: #28a745;
      }

      .tables-card.reserved-table {
        background-color: #ffc107;
        color: white;
      }

      .tables-card p {
        margin: 0;
      }

      /* Nuevos estilos para las tarjetas de los usuarios */
      .user-card {
        background-color: #9c49fb;
        cursor: pointer;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      }

      .user-card.dragging {
        opacity: 0.5;
      }

      .user-card.valid {
        background-color: #28a745;
      }

      .user-card.invalid {
        background-color: #dc3545;
      }

      .user-card p {
        margin: 5px 0;
      }

    </style>
  </head>
  <body>
    <div class="container-scroller">
      @include("admin.navbar")

      <div class="container mt-5">
        <h3>Reservaciones</h3>
        <!-- Mostrar las reservaciones en una tabla -->
        <div class="table-wrapper">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Telefono</th>
              <th>Invitados</th>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Mensaje</th>
              <th>Mesa</th> 
            </tr>
          </thead>
          <tbody>
            @foreach($reservations as $reservation)
              <tr>
                <td>{{ $reservation->name }}</td>
                <td>{{ $reservation->email }}</td>
                <td>{{ $reservation->phone }}</td>
                <td>{{ $reservation->guest }}</td>
                <td>{{ $reservation->date }}</td>
                <td>{{ $reservation->time }}</td>
                <td>{{ $reservation->message }}</td>
                <td>
                  @if ($reservation->table_id)
                    Nombre: {{ $reservation->table->name }} #{{ $reservation->table->number }} ubicación: {{ $reservation->table->type }}
                  @else
                    <span>No asignada</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        </div>

        <h3>Mesas Disponibles</h3>
        <!-- Mostrar mesas disponibles -->
        <div class="row">
          @foreach ($tables as $table)
            @if ($table->status == 'disponible')
              <div class="col-md-2 mb-2">
                <div class="card border-success tables-card available-table" id="table-{{ $table->id }}" ondrop="drop(event)" ondragover="allowDrop(event)">
                  <div class="card-body">
                    <h5 class="card-title">Mesa #{{ $table->number }}</h5>
                    <p class="card-text">Asientos: {{ $table->seats }}</p>
                    <p class="card-text">Estado: {{ ucfirst($table->status) }}</p>
                  </div>
                </div>
              </div>
            @elseif($table->status == 'reservada')
              <div class="col-md-2 mb-2">
                <div class="card border-warning tables-card reserved-table">
                  <div class="card-body">
                    <h5 class="card-title">Mesa #{{ $table->number }}</h5>
                    <p class="card-text">Asientos: {{ $table->seats }}</p>
                    <p class="card-text">Estado: {{ ucfirst($table->status) }}</p>
                  </div>
                </div>
              </div>
            @endif
          @endforeach
        </div>

        <h3>Asignar reservacion</h3>
        <div class="row">
          @foreach ($reservations as $reservation)
            @if (!$reservation->table_id)
              <div class="col-md-3 mb-e">
                <div class="card user-card" id="user-{{ $reservation->id }}" draggable="true" ondragstart="drag(event)">
                  <div class="card-body">
                    <h5 class="card-title">{{ $reservation->name }}</h5>
                    <p>Invitados: {{ $reservation->guest }}</p>
                    <p>Fecha: {{ $reservation->date }}</p>
                    <p>Hora: {{ $reservation->time }}</p>
                    <p>Mensaje: {{ $reservation->message }}</p>
                  </div>
                </div>
              </div>
            @endif
          @endforeach
        </div>
      </div>
    </div>

    @include("admin.adminscript")

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
  let draggedUser = null;

  function allowDrop(ev) {
    ev.preventDefault();
  }

  function drag(ev) {
    draggedUser = ev.target;
    draggedUser.classList.add('dragging');
  }

  function drop(ev) {
    ev.preventDefault();

    const table = ev.target.closest('.tables-card');
    if (!table || !draggedUser) return;

    const tableId = table.id.split('-')[1];
    const userId = draggedUser.id.split('-')[1];

    const tableSeatsText = table.querySelector('.card-body p:nth-child(2)').textContent;
    const userGuestsText = draggedUser.querySelector('p:first-of-type').textContent;

    // Extraer números (en caso que tengan "Asientos: X" o "Invitados: X")
    const tableSeats = parseInt(tableSeatsText.replace(/\D/g, ''));
    const userGuests = parseInt(userGuestsText.replace(/\D/g, ''));

    if (isNaN(tableSeats) || isNaN(userGuests)) {
      Swal.fire({
        title: 'Error',
        text: 'No se pudieron leer los datos de asientos o invitados.',
        icon: 'error',
        confirmButtonText: 'Intentar nuevamente'
      });
      return;
    }

    if (tableSeats !== userGuests) {
      Swal.fire({
        title: 'Error',
        text: `La mesa tiene ${tableSeats} asientos y la reservación es para ${userGuests} invitados.`,
        icon: 'error',
        confirmButtonText: 'Intentar nuevamente'
      });
      return;
    }

    // Si todo coincide, enviar la petición al backend
    fetch(`/admin/reservations/${userId}/assign-table`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      body: JSON.stringify({ table_id: tableId })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        Swal.fire({
          title: 'Éxito',
          text: `Mesa asignada a ${data.user_name}.`,
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => location.reload());
      } else {
        Swal.fire({
          title: 'Error',
          text: data.message || 'No se pudo asignar la mesa.',
          icon: 'error',
          confirmButtonText: 'Intentar nuevamente'
        });
      }
    })
    .catch(error => {
      Swal.fire({
        title: 'Error',
        text: 'Hubo un error al asignar la mesa.',
        icon: 'error',
        confirmButtonText: 'Intentar nuevamente'
      });
    });
  }
</script>


  </body>
</html>

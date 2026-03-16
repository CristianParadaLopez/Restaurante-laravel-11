@extends('admin.layouts.admin')
@section('title', 'Reservaciones')
@section('content')

<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:20px; font-weight:500; color:var(--text); margin:0;">Reservaciones</h1>
    <p style="font-size:12px; color:var(--muted); margin:2px 0 0;">Gestiona y asigna mesas a reservaciones</p>
</div>

{{-- Tabla reservaciones --}}
<div class="stat-card" style="padding:0; overflow:hidden; margin-bottom:1.5rem;">
    <div style="padding:1rem 1.2rem; border-bottom:1px solid var(--border);">
        <span style="font-size:13px; font-weight:500; color:var(--text);">Lista de Reservaciones</span>
    </div>
    <table class="admin-table">
        <thead>
            <tr><th>Nombre</th><th>Teléfono</th><th>Invitados</th><th>Fecha</th><th>Hora</th><th>Mesa asignada</th></tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->name }}</td>
                <td>{{ $reservation->phone }}</td>
                <td>{{ $reservation->guest }}</td>
                <td>{{ $reservation->date }}</td>
                <td>{{ $reservation->time }}</td>
                <td>
                    @if($reservation->table_id)
                        <span class="badge-status badge-done">{{ $reservation->table->name }} #{{ $reservation->table->number }}</span>
                    @else
                        <span class="badge-status badge-danger">Sin asignar</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Asignar mesas por drag & drop --}}
<div class="row" style="gap:1.5rem; display:grid; grid-template-columns:1fr 1fr;">

    <div class="stat-card" style="padding:0; overflow:hidden;">
        <div style="padding:1rem 1.2rem; border-bottom:1px solid var(--border);">
            <span style="font-size:13px; font-weight:500; color:var(--text);">Mesas disponibles</span>
        </div>
        <div style="padding:1rem; display:flex; flex-wrap:wrap; gap:8px;">
            @foreach($tables as $table)
            @if($table->status == 'disponible')
            <div class="mesa-card disponible" id="table-{{ $table->id }}"
                ondrop="drop(event)" ondragover="allowDrop(event)"
                style="background:var(--card); border:1px solid rgba(34,197,94,0.3); border-radius:8px; padding:10px 14px; cursor:pointer; min-width:120px;">
                <div style="font-size:12px; font-weight:500; color:var(--text);">Mesa #{{ $table->number }}</div>
                <div style="font-size:11px; color:var(--muted);">{{ $table->seats }} asientos</div>
                <div style="font-size:10px; color:#6ee7a0; margin-top:4px;">Disponible</div>
            </div>
            @elseif($table->status == 'reservada')
            <div style="background:var(--card); border:1px solid rgba(198,161,91,0.3); border-radius:8px; padding:10px 14px; min-width:120px;">
                <div style="font-size:12px; font-weight:500; color:var(--text);">Mesa #{{ $table->number }}</div>
                <div style="font-size:11px; color:var(--muted);">{{ $table->seats }} asientos</div>
                <div style="font-size:10px; color:var(--gold); margin-top:4px;">Reservada</div>
            </div>
            @endif
            @endforeach
        </div>
    </div>

    <div class="stat-card" style="padding:0; overflow:hidden;">
        <div style="padding:1rem 1.2rem; border-bottom:1px solid var(--border);">
            <span style="font-size:13px; font-weight:500; color:var(--text);">Sin asignar — arrastra a una mesa</span>
        </div>
        <div style="padding:1rem; display:flex; flex-wrap:wrap; gap:8px;">
            @foreach($reservations as $reservation)
            @if(!$reservation->table_id)
            <div id="user-{{ $reservation->id }}" draggable="true" ondragstart="drag(event)"
                style="background:rgba(198,161,91,0.1); border:1px solid var(--gold-border); border-radius:8px; padding:10px 14px; cursor:grab; min-width:140px;">
                <div style="font-size:12px; font-weight:500; color:var(--text);">{{ $reservation->name }}</div>
                <div style="font-size:11px; color:var(--muted);">{{ $reservation->guest }} invitados</div>
                <div style="font-size:10px; color:var(--gold); margin-top:2px;">{{ $reservation->date }}</div>
            </div>
            @endif
            @endforeach
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
let draggedUser = null;

function allowDrop(ev) { ev.preventDefault(); }

function drag(ev) {
    draggedUser = ev.target.closest('[draggable]');
}

function drop(ev) {
    ev.preventDefault();
    const tableCard = ev.target.closest('.mesa-card');
    if (!tableCard || !draggedUser) return;

    const tableId = tableCard.id.split('-')[1];
    const userId  = draggedUser.id.split('-')[1];

    fetch(`/admin/reservations/${userId}/assign-table`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ table_id: tableId })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            Swal.fire({ title: 'Mesa asignada', text: `Mesa asignada a ${data.user_name}`,
                icon: 'success', background: '#1a1a1a', color: '#e8e8e8', confirmButtonColor: '#c6a15b' })
            .then(() => location.reload());
        } else {
            Swal.fire({ title: 'Error', text: data.message, icon: 'error',
                background: '#1a1a1a', color: '#e8e8e8', confirmButtonColor: '#c6a15b' });
        }
    });
}
</script>
@endpush
@endsection
@extends('admin.layouts.admin')
@section('title', 'Mesas')
@section('content')

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:20px; font-weight:500; color:var(--text); margin:0;">Mesas</h1>
        <p style="font-size:12px; color:var(--muted); margin:2px 0 0;">Administra las mesas del restaurante</p>
    </div>
    <button class="btn-gold" data-bs-toggle="modal" data-bs-target="#createTableModal">
        <i class="fas fa-plus" style="margin-right:6px;"></i>Nueva Mesa
    </button>
</div>

<div class="stat-card" style="padding:0; overflow:hidden;">
    <table class="admin-table">
        <thead>
            <tr><th>Nombre</th><th>#</th><th>Tipo</th><th>Asientos</th><th>Estado</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            @foreach($tables as $table)
            <tr>
                <td>{{ $table->name }}</td>
                <td>{{ $table->number }}</td>
                <td>{{ ucfirst($table->type) }}</td>
                <td>{{ $table->seats }}</td>
                <td>
                    @php
                        $cls = match($table->status) {
                            'disponible' => 'badge-done',
                            'reservada'  => 'badge-pending',
                            default      => 'badge-danger'
                        };
                    @endphp
                    <span class="badge-status {{ $cls }}">{{ ucfirst($table->status) }}</span>
                </td>
                <td style="display:flex; gap:8px; flex-wrap:wrap;">
                    @if($table->status == 'reservada' && $table->reservation)
                    <button class="btn-outline" style="padding:4px 10px;font-size:11px;"
                        data-bs-toggle="modal" data-bs-target="#reservModal{{ $table->id }}">
                        <i class="fas fa-eye"></i> Ver
                    </button>
                    @endif
                    <button class="btn-outline" style="padding:4px 10px;font-size:11px;"
                        data-bs-toggle="modal" data-bs-target="#editTableModal{{ $table->id }}">
                        <i class="fas fa-pen"></i> Editar
                    </button>
                    <form action="{{ route('admin.tables.destroy', $table->id) }}" method="POST" style="margin:0;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-outline" style="padding:4px 10px;font-size:11px;color:#fca5a5;border-color:rgba(239,68,68,0.3);"
                            onclick="return confirm('¿Eliminar mesa?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>

            {{-- Modal ver reservación --}}
            @if($table->status == 'reservada' && $table->reservation)
            <div class="modal fade" id="reservModal{{ $table->id }}" tabindex="-1">
                <div class="modal-dialog"><div class="modal-content admin-modal">
                    <div class="modal-header">
                        <h5 class="modal-title">Reservación — Mesa {{ $table->name }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p style="color:var(--text);font-size:13px;margin-bottom:8px;"><strong>Nombre:</strong> {{ $table->reservation->name }}</p>
                        <p style="color:var(--text);font-size:13px;margin-bottom:8px;"><strong>Teléfono:</strong> {{ $table->reservation->phone }}</p>
                        <p style="color:var(--text);font-size:13px;margin-bottom:8px;"><strong>Invitados:</strong> {{ $table->reservation->guest }}</p>
                        <p style="color:var(--text);font-size:13px;margin-bottom:8px;"><strong>Fecha:</strong> {{ $table->reservation->date }}</p>
                        <p style="color:var(--text);font-size:13px;"><strong>Hora:</strong> {{ $table->reservation->time }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-outline" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn-gold" onclick="markAsUsed({{ $table->id }})">
                            Marcar como utilizada
                        </button>
                    </div>
                </div></div>
            </div>
            @endif

            {{-- Modal editar --}}
            <div class="modal fade" id="editTableModal{{ $table->id }}" tabindex="-1">
                <div class="modal-dialog"><div class="modal-content admin-modal">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Mesa</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.tables.update', $table->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-body">
                            <div class="admin-field"><label>Nombre</label><input type="text" name="name" class="admin-input" value="{{ $table->name }}" required></div>
                            <div class="admin-field"><label>Número</label><input type="number" name="number" class="admin-input" value="{{ $table->number }}" required></div>
                            <div class="admin-field"><label>Tipo</label>
                                <select name="type" class="admin-input">
                                    <option value="terraza" {{ $table->type=='terraza'?'selected':'' }}>Terraza</option>
                                    <option value="interior" {{ $table->type=='interior'?'selected':'' }}>Interior</option>
                                    <option value="exterior" {{ $table->type=='exterior'?'selected':'' }}>Exterior</option>
                                </select></div>
                            <div class="admin-field"><label>Asientos</label><input type="number" name="seats" class="admin-input" value="{{ $table->seats }}" required></div>
                            <div class="admin-field"><label>Estado</label>
                                <select name="status" class="admin-input">
                                    <option value="disponible" {{ $table->status=='disponible'?'selected':'' }}>Disponible</option>
                                    <option value="reservada" {{ $table->status=='reservada'?'selected':'' }}>Reservada</option>
                                    <option value="ocupada" {{ $table->status=='ocupada'?'selected':'' }}>Ocupada</option>
                                </select></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-outline" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn-gold">Guardar</button>
                        </div>
                    </form>
                </div></div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal crear --}}
<div class="modal fade" id="createTableModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content admin-modal">
        <div class="modal-header">
            <h5 class="modal-title">Nueva Mesa</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form action="{{ route('admin.tables.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="admin-field"><label>Nombre</label><input type="text" name="name" class="admin-input" required></div>
                <div class="admin-field"><label>Número</label><input type="number" name="number" class="admin-input" required></div>
                <div class="admin-field"><label>Tipo</label>
                    <select name="type" class="admin-input">
                        <option value="terraza">Terraza</option>
                        <option value="interior">Interior</option>
                        <option value="exterior">Exterior</option>
                    </select></div>
                <div class="admin-field"><label>Asientos</label><input type="number" name="seats" class="admin-input" required></div>
                <div class="admin-field"><label>Estado</label>
                    <select name="status" class="admin-input">
                        <option value="disponible">Disponible</option>
                        <option value="reservada">Reservada</option>
                        <option value="ocupada">Ocupada</option>
                    </select></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn-gold">Crear Mesa</button>
            </div>
        </form>
    </div></div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function markAsUsed(tableId) {
    Swal.fire({
        title: '¿Marcar como utilizada?',
        text: 'Esto liberará la mesa y eliminará la reservación.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, marcar',
        cancelButtonText: 'Cancelar',
        background: '#1a1a1a', color: '#e8e8e8',
        confirmButtonColor: '#c6a15b'
    }).then(result => {
        if (result.isConfirmed) {
            fetch(`/admin/tables/${tableId}/mark-as-used`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({ title: 'Listo', icon: 'success', background: '#1a1a1a',
                        color: '#e8e8e8', confirmButtonColor: '#c6a15b' })
                    .then(() => location.reload());
                }
            });
        }
    });
}
</script>
@endpush
@endsection
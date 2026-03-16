@extends('admin.layouts.admin')
@section('title', 'Chefs')
@section('content')

<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:20px; font-weight:500; color:var(--text); margin:0;">Chefs</h1>
    <p style="font-size:12px; color:var(--muted); margin:2px 0 0;">Perfiles del equipo de cocina</p>
</div>

<div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:1rem;">
    @foreach($chefs as $chef)
    <div class="stat-card" style="text-align:center; padding:1.5rem 1rem;">
        <img src="{{ asset('chefimage/'.($chef->image ?? 'default-profile.png')) }}"
            style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:2px solid var(--gold-border);margin-bottom:12px;">
        <div style="font-size:14px; font-weight:500; color:var(--text);">{{ $chef->first_name }} {{ $chef->last_name }}</div>
        <div style="font-size:11px; color:var(--gold); margin:4px 0 2px;">{{ $chef->specialty }}</div>
        <div style="font-size:11px; color:var(--muted); margin-bottom:1rem;">{{ ucfirst($chef->area) }}</div>
        <div style="display:flex; gap:8px; justify-content:center;">
            <button class="btn-outline" style="padding:4px 10px;font-size:11px;"
                data-bs-toggle="modal" data-bs-target="#editChefModal{{ $chef->id }}">
                <i class="fas fa-pen"></i> Editar
            </button>
            <form action="{{ route('admin.chefs.destroy', $chef->id) }}" method="POST" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-outline" style="padding:4px 10px;font-size:11px;color:#fca5a5;border-color:rgba(239,68,68,0.3);"
                    onclick="return confirm('¿Eliminar chef?')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editChefModal{{ $chef->id }}" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content admin-modal">
            <div class="modal-header">
                <h5 class="modal-title">Editar Chef</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.chefs.update', $chef->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="admin-field"><label>Primer Nombre</label><input type="text" name="first_name" class="admin-input" value="{{ $chef->first_name }}" required></div>
                    <div class="admin-field"><label>Apellido</label><input type="text" name="last_name" class="admin-input" value="{{ $chef->last_name }}" required></div>
                    <div class="admin-field"><label>Especialidad</label><input type="text" name="specialty" class="admin-input" value="{{ $chef->specialty }}" required></div>
                    <div class="admin-field"><label>Descripción</label><textarea name="description" class="admin-input" rows="3">{{ $chef->description }}</textarea></div>
                    <div class="admin-field"><label>Área</label>
                        <select name="area" class="admin-input">
                            @foreach(['preparacion','cocinar','servir','almacenamiento','lavar','pedidos'] as $area)
                            <option value="{{ $area }}" {{ $chef->area==$area?'selected':'' }}>{{ ucfirst($area) }}</option>
                            @endforeach
                        </select></div>
                    <div class="admin-field"><label>Imagen</label><input type="file" name="image" class="admin-input"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-gold">Guardar</button>
                </div>
            </form>
        </div></div>
    </div>
    @endforeach
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
@endsection
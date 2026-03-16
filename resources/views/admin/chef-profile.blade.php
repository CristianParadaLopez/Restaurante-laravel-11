@extends('admin.layouts.admin')
@section('title', 'Mi Perfil')
@section('content')

<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:20px; font-weight:500; color:var(--text); margin:0;">Mi Perfil</h1>
    <p style="font-size:12px; color:var(--muted);">Tu información como chef</p>
</div>

@if($chefProfile)
<div class="stat-card" style="max-width:600px;">
    <div style="display:flex; align-items:center; gap:1.5rem; margin-bottom:1.2rem;">
        <img src="{{ asset('chefimage/'.($chefProfile->image ?? 'default-profile.png')) }}"
            style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:2px solid var(--gold-border);">
        <div>
            <div style="font-size:18px; font-weight:500; color:var(--text);">{{ $chefProfile->first_name }} {{ $chefProfile->last_name }}</div>
            <div style="font-size:12px; color:var(--gold); margin-top:4px;">{{ $chefProfile->specialty }}</div>
            <div style="font-size:11px; color:var(--muted);">{{ ucfirst($chefProfile->area) }}</div>
        </div>
    </div>
    <div style="border-top:1px solid var(--border); padding-top:1rem; font-size:13px; color:var(--muted); line-height:1.7;">
        {{ $chefProfile->description }}
    </div>
    <div style="display:flex; gap:8px; margin-top:1.2rem;">
        <a href="{{ route('admin.profile.edit') }}" class="btn-gold" style="text-decoration:none; padding:6px 14px; font-size:12px;">
            <i class="fas fa-pen" style="margin-right:6px;"></i>Editar Perfil
        </a>
        <form action="{{ route('admin.profile.destroy') }}" method="POST" style="margin:0;">
            @csrf @method('DELETE')
            <button type="submit" class="btn-outline" style="padding:6px 14px;font-size:12px;color:#fca5a5;border-color:rgba(239,68,68,0.3);"
                onclick="return confirm('¿Eliminar perfil?')">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </form>
    </div>
</div>
@else
<div class="stat-card" style="max-width:600px;">
    <p style="font-size:13px; color:var(--muted); margin-bottom:1.2rem;">No tienes perfil aún. Créalo a continuación.</p>
    <form method="POST" action="{{ route('admin.profile.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="admin-field"><label>Primer Nombre</label><input type="text" name="first_name" class="admin-input" required></div>
        <div class="admin-field"><label>Apellido</label><input type="text" name="last_name" class="admin-input" required></div>
        <div class="admin-field"><label>Especialidad</label><input type="text" name="specialty" class="admin-input" required></div>
        <div class="admin-field"><label>Descripción</label><textarea name="description" class="admin-input" rows="3"></textarea></div>
        <div class="admin-field"><label>Área</label>
            <select name="area" class="admin-input">
                @foreach(['preparacion','cocinar','servir','almacenamiento','lavar','pedidos'] as $area)
                <option value="{{ $area }}">{{ ucfirst($area) }}</option>
                @endforeach
            </select></div>
        <div class="admin-field"><label>Imagen</label><input type="file" name="image" class="admin-input"></div>
        <button type="submit" class="btn-gold" style="margin-top:8px;">Crear Perfil</button>
    </form>
</div>
@endif

@endsection
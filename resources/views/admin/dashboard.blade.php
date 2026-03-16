@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 22px; font-weight: 500; color: var(--text); margin-bottom: 4px;">Bienvenido de nuevo</h1>
    <p style="font-size: 13px; color: var(--muted);">Resumen general del restaurante</p>
</div>

{{-- Stats --}}
<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card accent">
            <div class="stat-label">Usuarios</div>
            <div class="stat-value">{{ $usersCount }}</div>
            <div class="stat-sub">registrados</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <div class="stat-label">Menús</div>
            <div class="stat-value">{{ $foodsCount }}</div>
            <div class="stat-sub">platillos activos</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <div class="stat-label">Órdenes</div>
            <div class="stat-value">{{ $ordersCount }}</div>
            <div class="stat-sub">este mes</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <div class="stat-label">Mesas</div>
            <div class="stat-value">{{ $tablesCount }}</div>
            <div class="stat-sub">disponibles</div>
        </div>
    </div>
</div>

{{-- Tabla últimas órdenes --}}
<div class="stat-card" style="padding: 0; overflow: hidden;">
    <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.2rem; border-bottom: 1px solid var(--border);">
        <span style="font-size: 14px; font-weight: 500; color: var(--text);">Últimas órdenes</span>
        <span style="font-size: 10px; background: var(--gold-dim); color: var(--gold); border: 1px solid var(--gold-border); border-radius: 4px; padding: 2px 10px;">Hoy</span>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($latestOrders ?? [] as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>${{ number_format($order->total, 2) }}</td>
                <td>
                    <span class="badge-status {{ $order->status === 'completed' ? 'badge-done' : 'badge-pending' }}">
                        {{ $order->status === 'completed' ? 'Completada' : 'Pendiente' }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: var(--muted); padding: 2rem;">
                    No hay órdenes registradas aún
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
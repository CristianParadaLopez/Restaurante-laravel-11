@extends('admin.layouts.admin')
@section('title', 'Órdenes')
@section('content')

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:20px; font-weight:500; color:var(--text); margin:0;">Órdenes</h1>
        <p style="font-size:12px; color:var(--muted); margin:2px 0 0;">Historial de pedidos</p>
    </div>
    <form action="{{ route('admin.orders.index') }}" method="GET" style="display:flex; gap:8px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar orden..."
            class="admin-input" style="width:200px; padding:6px 12px;">
        <button type="submit" class="btn-gold" style="padding:6px 14px;">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

<div class="stat-card" style="padding:0; overflow:hidden;">
    <table class="admin-table">
        <thead>
            <tr><th>#</th><th>Cliente</th><th>Teléfono</th><th>Total</th><th>Estado</th><th>Fecha</th></tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->phone }}</td>
                <td>${{ number_format($order->total, 2) }}</td>
                <td><span class="badge-status {{ $order->status === 'completed' ? 'badge-done' : 'badge-pending' }}">
                    {{ $order->status === 'completed' ? 'Completada' : 'Pendiente' }}
                </span></td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center; color:var(--muted); padding:2rem;">Sin órdenes</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:1rem 1.2rem;">{{ $orders->links() }}</div>
</div>

@endsection
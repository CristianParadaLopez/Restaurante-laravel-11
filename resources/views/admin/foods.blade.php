@extends('admin.layouts.admin')
@section('title', 'Menús')
@section('content')

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:20px; font-weight:500; color:var(--text); margin:0;">Menús</h1>
        <p style="font-size:12px; color:var(--muted); margin:2px 0 0;">Gestiona los platillos del restaurante</p>
    </div>
    <button class="btn-gold" data-bs-toggle="modal" data-bs-target="#createFoodModal">
        <i class="fas fa-plus" style="margin-right:6px;"></i>Nuevo Platillo
    </button>
</div>

<div class="stat-card" style="padding:0; overflow:hidden;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Imagen</th><th>Nombre</th><th>Precio</th>
                <th>Categoría</th><th>Tamaño</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($foods as $food)
            <tr>
                <td><img src="{{ asset('foodimage/'.$food->image) }}" style="width:50px;height:50px;object-fit:cover;border-radius:6px;"></td>
                <td>{{ $food->title }}</td>
                <td>${{ number_format($food->price,2) }}</td>
                <td>{{ $food->category->name ?? '—' }}</td>
                <td>{{ $food->size ?? '—' }}</td>
                <td style="display:flex; gap:8px;">
                    <button class="btn-outline" style="padding:4px 10px;font-size:11px;"
                        onclick="openEditModal(@json($food))">
                        <i class="fas fa-pen"></i> Editar
                    </button>
                    <form action="{{ route('admin.foods.destroy', $food->id) }}" method="POST" style="margin:0;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-outline" style="padding:4px 10px;font-size:11px;color:#fca5a5;border-color:rgba(239,68,68,0.3);"
                            onclick="return confirm('¿Eliminar platillo?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding:1rem 1.2rem;">{{ $foods->links() }}</div>
</div>

{{-- Modal Crear --}}
<div class="modal fade" id="createFoodModal" tabindex="-1">
    <div class="modal-dialog modal-lg"><div class="modal-content admin-modal">
        <div class="modal-header">
            <h5 class="modal-title">Nuevo Platillo</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form action="{{ route('admin.foods.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:0 1rem;">
                <div class="admin-field"><label>Título</label><input type="text" name="title" class="admin-input" required></div>
                <div class="admin-field"><label>Precio</label><input type="number" name="price" step="0.01" class="admin-input" required></div>
                <div class="admin-field" style="grid-column:1/-1"><label>Descripción</label><input type="text" name="description" class="admin-input" required></div>
                <div class="admin-field"><label>Ingredientes</label><input type="text" name="ingredients" class="admin-input"></div>
                <div class="admin-field"><label>Proteínas</label><input type="text" name="proteins" class="admin-input"></div>
                <div class="admin-field"><label>Calorías</label><input type="number" name="calories" class="admin-input"></div>
                <div class="admin-field"><label>Tamaño</label>
                    <select name="size" class="admin-input">
                        <option value="Pequeño">Pequeño</option>
                        <option value="Mediano">Mediano</option>
                        <option value="Grande">Grande</option>
                    </select></div>
                <div class="admin-field"><label>Categoría</label>
                    <select name="category_id" class="admin-input">
                        @foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option>@endforeach
                    </select></div>
                <div class="admin-field" style="grid-column:1/-1"><label>Imagen</label>
                    <input type="file" name="image" class="admin-input" required></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn-gold">Guardar</button>
            </div>
        </form>
    </div></div>
</div>

{{-- Modal Editar --}}
<div class="modal fade" id="editFoodModal" tabindex="-1">
    <div class="modal-dialog modal-lg"><div class="modal-content admin-modal">
        <div class="modal-header">
            <h5 class="modal-title">Editar Platillo</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form id="editFoodForm" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="modal-body" style="display:grid;grid-template-columns:1fr 1fr;gap:0 1rem;">
                <div class="admin-field"><label>Título</label><input type="text" name="title" id="edit_title" class="admin-input" required></div>
                <div class="admin-field"><label>Precio</label><input type="number" name="price" id="edit_price" step="0.01" class="admin-input" required></div>
                <div class="admin-field" style="grid-column:1/-1"><label>Descripción</label><input type="text" name="description" id="edit_description" class="admin-input"></div>
                <div class="admin-field"><label>Ingredientes</label><input type="text" name="ingredients" id="edit_ingredients" class="admin-input"></div>
                <div class="admin-field"><label>Proteínas</label><input type="text" name="proteins" id="edit_proteins" class="admin-input"></div>
                <div class="admin-field"><label>Calorías</label><input type="number" name="calories" id="edit_calories" class="admin-input"></div>
                <div class="admin-field"><label>Tamaño</label>
                    <select name="size" id="edit_size" class="admin-input">
                        <option value="Pequeño">Pequeño</option>
                        <option value="Mediano">Mediano</option>
                        <option value="Grande">Grande</option>
                    </select></div>
                <div class="admin-field"><label>Categoría</label>
                    <select name="category_id" id="edit_category" class="admin-input">
                        @foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option>@endforeach
                    </select></div>
                <div class="admin-field" style="grid-column:1/-1">
                    <label>Imagen actual</label>
                    <img id="edit_img" src="" style="width:80px;height:80px;object-fit:cover;border-radius:6px;display:block;margin-bottom:8px;">
                    <label>Nueva imagen <span style="color:var(--muted)">(opcional)</span></label>
                    <input type="file" name="image" class="admin-input">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn-gold">Guardar Cambios</button>
            </div>
        </form>
    </div></div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openEditModal(food) {
    document.getElementById('editFoodForm').action = '/admin/foods/' + food.id;
    document.getElementById('edit_title').value = food.title;
    document.getElementById('edit_price').value = food.price;
    document.getElementById('edit_description').value = food.description;
    document.getElementById('edit_ingredients').value = food.ingredients;
    document.getElementById('edit_proteins').value = food.proteins;
    document.getElementById('edit_calories').value = food.calories;
    document.getElementById('edit_size').value = food.size;
    document.getElementById('edit_category').value = food.category_id;
    document.getElementById('edit_img').src = '/foodimage/' + food.image;
    new bootstrap.Modal(document.getElementById('editFoodModal')).show();
}
</script>
@endpush
@endsection
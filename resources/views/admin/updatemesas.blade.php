<x-app-layout></x-app-layout>

<!DOCTYPE html>
<html lang="es">
<head>
    @include("admin.admincss")
</head>
<body>
    <div class="container-scroller">
        @include("admin.navbar")

        <div class="container mt-5">
            <h1 class="mb-4">Editar Mesa</h1>

            <!-- Formulario de edición de mesa -->
            <form action="{{ route('adminmesasupdate', $table->id) }}" method="POST" class="mb-5">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="name" class="form-control" value="{{ $table->name }}" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="number" class="form-control" value="{{ $table->number }}" required>
                    </div>
                    <div class="col-md-3">
                        <select name="type" class="form-control" required>
                            <option value="terraza" {{ $table->type == 'terraza' ? 'selected' : '' }}>Terraza</option>
                            <option value="interior" {{ $table->type == 'interior' ? 'selected' : '' }}>Interior</option>
                            <option value="exterior" {{ $table->type == 'exterior' ? 'selected' : '' }}>Exterior</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="seats" class="form-control" value="{{ $table->seats }}" required>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-control" required>
                            <option value="available" {{ $table->status == 'available' ? 'selected' : '' }}>Disponible</option>
                            <option value="occupied" {{ $table->status == 'occupied' ? 'selected' : '' }}>Ocupada</option>
                            <option value="reserved" {{ $table->status == 'reserved' ? 'selected' : '' }}>Reservada</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-3">Actualizar Mesa</button>
            </form>
        </div>
    </div>

    </div>

    @include("admin.adminscript")
</body>
</html>

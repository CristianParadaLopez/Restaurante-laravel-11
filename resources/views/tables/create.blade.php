@extends('layouts.app')

@section('content')
    <h1>Agregar Mesa</h1>
    <form action="{{ route('tables.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="number">Número de Mesa</label>
            <input type="number" name="number" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="capacity">Capacidad</label>
            <input type="number" name="capacity" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="status">Estado</label>
            <select name="status" class="form-control">
                <option value="Disponible">Disponible</option>
                <option value="Ocupada">Ocupada</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@endsection

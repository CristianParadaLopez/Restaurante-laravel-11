<x-app-layout></x-app-layout>

<!DOCTYPE html>
<html lang="es">
<head>
  <base href="/public">
  @include("chef.chefcss")
  <style>
    .form-container {
      padding: 20px;
      border-radius: 8px;
      border: 2px solid #9c49fb;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      background-color: #9c49fb;
      margin: 30px auto;
      color: black;
    }

    .form-container label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
    }

    .form-container input[type="text"],
    .form-container input[type="number"],
    .form-container input[type="file"],
    .form-container select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    .form-container input[type="submit"] {
      padding: 10px;
      background-color: #9c49fb;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }

    .form-container input[type="submit"]:hover {
      background-color: #7a37d0;
    }

    .form-container img {
      max-width: 100%;
      border-radius: 5px;
      margin-bottom: 15px;
    }

    .form-row {
      margin-bottom: 15px;
    }

    .form-row .col-md-4 {
      margin-bottom: 15px;
    }

    /* Horizontal Layout Adjustments */
    .form-row {
      display: flex;
      justify-content: space-between;
    }

    .form-row .col-md-4 {
      flex: 1;
      margin-right: 15px;
    }

    .form-row .col-md-4:last-child {
      margin-right: 0;
    }

    /* Adjusting the submit button */
    .form-container input[type="submit"] {
      width: 100%;
    }
  </style>
</head>
<body>
  <div class="container-scroller">
    @include("chef.chefnavbar")

    <div class="form-container">
      <form action="{{ isset($data) ? url('/updatechef', $data->id) : url('/uploadfoodchef') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
          <!-- Título y Precio en la misma fila -->
          <div class="col-md-4">
            <label for="title">Título</label>
            <input type="text" name="title" id="title" value="{{ $data->title ?? '' }}" required>
          </div>
          <div class="col-md-4">
            <label for="price">Precio</label>
            <input type="number" name="price" id="price" value="{{ $data->price ?? '' }}" required>
          </div>
        </div>

        <div class="form-row">
          <!-- Descripción y Ingredientes -->
          <div class="col-md-4">
            <label for="description">Descripción</label>
            <input type="text" name="description" id="description" value="{{ $data->description ?? '' }}" required>
          </div>
          <div class="col-md-4">
            <label for="ingredients">Ingredientes</label>
            <input type="text" name="ingredients" id="ingredients" value="{{ $data->ingredients ?? '' }}">
          </div>
        </div>

        <div class="form-row">
          <!-- Proteínas, Calorías, Tamaño en la misma fila -->
          <div class="col-md-4">
            <label for="proteins">Proteínas</label>
            <input type="text" name="proteins" id="proteins" value="{{ $data->proteins ?? '' }}">
          </div>
          <div class="col-md-4">
            <label for="calories">Calorías</label>
            <input type="number" name="calories" id="calories" value="{{ $data->calories ?? '' }}">
          </div>
          <div class="col-md-4">
            <label for="size">Tamaño</label>
            <input type="text" name="size" id="size" value="{{ $data->size ?? '' }}">
          </div>
        </div>

        <div class="form-row">
          <!-- Categoría -->
          <div class="col-md-4">
            <label for="category_id">Categoría</label>
            <select name="category_id" id="category_id">
              <option value="">Selecciona una categoría</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ isset($data) && $data->category_id == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        @isset($data)
          <div class="form-group">
            <label>Imagen actual</label>
            <img src="/foodimage/{{ $data->image }}" alt="Imagen actual">
          </div>
        @endisset

        <div class="form-group">
          <label for="image">Nueva Imagen</label>
          <input type="file" name="image" id="image">
        </div>

        <div>
          <input type="submit" value="{{ isset($data) ? 'Guardar cambios' : 'Agregar comida' }}">
        </div>
      </form>
    </div>
  </div>

  @include("chef.chefscript")
</body>
</html>

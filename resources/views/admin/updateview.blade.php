<x-app-layout>
</x-app-layout>

<!DOCTYPE html>
<html lang="es">
<head>
  <base href="/public">
  @include("admin.admincss")
  <style>
    .form-container {
      flex: 1;
      max-width: 800px; /* Aumentamos el ancho para más espacio horizontal */
      padding: 20px;
      border-radius: 8px;
      border: 2px solid #9c49fb;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      margin: 30px auto;
      color: rgb(255, 255, 255);
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    .form-container label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
      width: 30%; /* Etiquetas ocupan el 30% */
    }

    .form-container input[type="text"],
    .form-container input[type="number"],
    .form-container input[type="file"],
    .form-container select {
      width: 65%; /* Campos de entrada ocupan el 65% */
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    .form-container input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #9c49fb;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      margin-top: 20px;
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
      display: flex;
      width: 100%;
      margin-bottom: 20px;
      align-items: center;
    }

    .form-row > div {
      margin-right: 10px;
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    @include("admin.navbar")
    <div class="form-container">
      <form action="{{ url('/update', $data->id) }}" method="post" enctype="multipart/form-data">
        @csrf

        <!-- Título -->
        <div class="form-row">
          <label>Título</label>
          <input style="background: #9c49fb; color: white" type="text" name="title" value="{{ $data->title }}" required>
        </div>

        <!-- Precio -->
        <div class="form-row">
          <label>Precio</label>
          <input style="background: #9c49fb; color: white" type="number" name="price" value="{{ $data->price }}" step="0.01" required>
        </div>

        <!-- Descripción -->
        <div class="form-row">
          <label>Descripción</label>
          <input style="background: #9c49fb; color: white" type="text" name="description" value="{{ $data->description }}" required>
        </div>

        <!-- Ingredientes -->
        <div class="form-row">
          <label>Ingredientes</label>
          <input style="background: #9c49fb; color: white" type="text" name="ingredients" value="{{ $data->ingredients }}">
        </div>

        <!-- Proteínas -->
        <div class="form-row">
          <label>Proteínas</label>
          <input style="background: #9c49fb; color: white" type="text" name="proteins" value="{{ $data->proteins }}">
        </div>

        <!-- Calorías -->
        <div class="form-row">
          <label>Calorías</label>
          <input style="background: #9c49fb; color: white" type="number" name="calories" value="{{ $data->calories }}">
        </div>

        <!-- Tamaño -->
        <div class="form-row">
          <label>Tamaño</label>
          <input style="background: #9c49fb; color: white" type="text" name="size" value="{{ $data->size }}">
        </div>

        <!-- Categoría -->
        <div class="form-row">
          <label>Categoría</label>
          <select name="category_id" style="background: #9c49fb; color: white">
            <option value="">Seleccione una categoría</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}" {{ $data->category_id == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Imagen actual -->
        <div class="form-row">
          <label>Imagen actual</label>
          <img src="/foodimage/{{ $data->image }}" alt="Imagen actual">
        </div>

        <!-- Nueva imagen -->
        <div class="form-row">
          <label>Nueva imagen</label>
          <input style="background: #9c49fb; color: white" type="file" name="image">
        </div>

        <!-- Botón de guardar -->
        <div>
          <input type="submit" value="Guardar">
        </div>
      </form>
    </div>
  </div>

  @include("admin.adminscript")
</body>
</html>

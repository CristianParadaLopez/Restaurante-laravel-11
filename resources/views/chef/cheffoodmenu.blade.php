<x-app-layout></x-app-layout>

<!DOCTYPE html>
<html lang="es">
<head>
    @include("chef.chefcss")
    <style>
        .form-container {
            margin: 20px;
            padding: 15px;
            border: 2px solid #9c49fb;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-container input,
        .form-container select,
        .form-container button {
            background: #9c49fb;
            color: white;
        }

        .form-container button {
            background-color: #28a745;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        .tabla-container {
            border: 2px solid #9c49fb;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #9c49fb;
            color: white;
        }

        .btn {
            display: inline-block;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-edit {
            background-color: #28a745;
        }

        .btn-edit:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        input::placeholder {
            color: rgb(255, 255, 255) !important;  
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        @include("chef.chefnavbar")

        <div class="contenedor">
            <!-- Formulario para agregar un nuevo platillo (horizontal) -->
            <div class="form-container">
                <h3>Agregar Nueva Comida</h3>
                <form action="{{ url('/uploadfood') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="title" class="form-control" placeholder="Título" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="price" class="form-control" placeholder="Precio..." required>
                        </div>
                        <div class="col-md-3">
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="description" class="form-control" placeholder="Descripción..." required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="ingredients" class="form-control" placeholder="Ingredientes..." required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <input type="text" name="proteins" class="form-control" placeholder="Proteínas..." required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="calories" class="form-control" placeholder="Calorías..." required>
                        </div>
                        <div class="col-md-2">
                            <select name="size" class="form-control" required>
                                <option value="Pequeño">Pequeño</option>
                                <option value="Mediano">Mediano</option>
                                <option value="Grande">Grande</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="category_id" class="form-control" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabla de menús existentes -->
            <div class="tabla-container">
                <h3>Menú Existente</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre de la Comida</th>
                            <th>Precio</th>
                            <th>Descripción</th>
                            <th>Imagen</th>
                            <th>Ingredientes</th>
                            <th>Proteínas</th>
                            <th>Calorías</th>
                            <th>Tamaño</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $food)
                        <tr>
                            <td>{{ $food->title }}</td>
                            <td>${{ $food->price }}</td>
                            <td>{{ $food->description }}</td>
                            <td>
                                <img src="/foodimage/{{ $food->image }}" alt="{{ $food->title }}" style="width: 100px; height: auto;">
                            </td>
                            <td>{{ $food->ingredients }}</td>
                            <td>{{ $food->proteins }}</td>
                            <td>{{ $food->calories }}</td>
                            <td>{{ $food->size }}</td>
                            <td>{{ $food->category->name }}</td> <!-- Mostrar categoría -->
                            <td>
                                <a href="{{ url('/chefupdateview', $food->id) }}" class="btn btn-edit">Editar</a>
                                <a href="{{ url('/chefdeletemenu', $food->id) }}" class="btn btn-delete" onclick="return confirm('¿Estás seguro de eliminar este ítem?')">Eliminar</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include("chef.chefscript")
</body>
</html>

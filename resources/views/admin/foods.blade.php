<!-- <x-app-layout></x-app-layout> -->

<!DOCTYPE html>
<html lang="es">
<head>
    @include("admin.admincss")
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
            background-color: #9c49fb;
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

        /* Modal único */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
            border-radius: 8px;
            background-color: #fff;
            color: #000;
        }

        .modal-content input,
        .modal-content select,
        .modal-content button {
            background: #9c49fb;
            color: white;
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 5px;
            border: none;
            width: 100%;
        }

        .modal-content button:hover {
            background-color: #218838;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        @include("admin.navbar")

        <div class="contenedor">
            <!-- Formulario para agregar nueva comida -->
            <div class="form-container">
                <h3>Agregar Nueva Comida</h3>
                <form action="{{ route('admin.foods.store') }}" method="POST" enctype="multipart/form-data">
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
                            <th>Nombre</th>
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
                        @foreach ($foods as $food)
                        <tr>
                            <td>{{ $food->title }}</td>
                            <td>${{ $food->price }}</td>
                            <td>{{ $food->description }}</td>
                            <td><img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->title }}" style="width:100px;"></td>
                            <td>{{ $food->ingredients }}</td>
                            <td>{{ $food->proteins }}</td>
                            <td>{{ $food->calories }}</td>
                            <td>{{ $food->size }}</td>
                            <td>{{ $food->category->name }}</td>
                            <td>
                                <button class="btn btn-edit" onclick='openModal(@json($food))'>Editar</button>
                                <form action="{{ route('admin.foods.destroy', $food->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('¿Estás seguro de eliminar este ítem?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $foods->links() }} <!-- Paginación -->
            </div>
        </div>
    </div>

    <!-- Modal único para editar -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3 id="modalTitle"></h3>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="text" name="title" id="title" placeholder="Título" required>
                <input type="number" name="price" id="price" placeholder="Precio" step="0.01" required>
                <input type="text" name="description" id="description" placeholder="Descripción" required>
                <input type="text" name="ingredients" id="ingredients" placeholder="Ingredientes">
                <input type="text" name="proteins" id="proteins" placeholder="Proteínas">
                <input type="number" name="calories" id="calories" placeholder="Calorías">
                <select name="size" id="size">
                    <option value="Pequeño">Pequeño</option>
                    <option value="Mediano">Mediano</option>
                    <option value="Grande">Grande</option>
                </select>
                <select name="category_id" id="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <p>Imagen actual:</p>
                <img id="currentImage" src="" style="width:100px;">
                <p>Nueva imagen:</p>
                <input type="file" name="image">
                <button type="submit">Guardar cambios</button>
            </form>
        </div>
    </div>

    @include("admin.adminscript")
    <script>
        function openModal(food) {
            document.getElementById('editModal').style.display = 'block';
            document.getElementById('modalTitle').innerText = 'Editar ' + food.title;
            document.getElementById('editForm').action = '/admin/foods/' + food.id;
            document.getElementById('title').value = food.title;
            document.getElementById('price').value = food.price;
            document.getElementById('description').value = food.description;
            document.getElementById('ingredients').value = food.ingredients;
            document.getElementById('proteins').value = food.proteins;
            document.getElementById('calories').value = food.calories;
            document.getElementById('size').value = food.size;
            document.getElementById('category_id').value = food.category_id;
            document.getElementById('currentImage').src = '/storage//' + food.image; 
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Click fuera del modal para cerrarlo
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) modal.style.display = 'none';
        }
    </script>
</body>
</html>

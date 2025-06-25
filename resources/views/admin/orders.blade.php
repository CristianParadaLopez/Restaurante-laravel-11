<x-app-layout></x-app-layout>

<!DOCTYPE html>
<html lang="es">
<head>
    @include("admin.admincss")
    <style>
        /* General */
        body {
            font-family: Arial, sans-serif;
           
            color: #333;
        }

        h1 {
            text-align: center;
            color: #6c63ff;
            margin-bottom: 20px;
        }

        .container {
            margin-top: 60px;
        }

        /* Input y botón de búsqueda */
        input[type="text"] {
            border: 2px solid #6c63ff;
            border-radius: 5px;
            padding: 10px;
            color: #333;
            width: 300px;
        }

        input[type="text"]::placeholder {
            color: #aaa;
        }

        .btn-success {
            background-color: #6c63ff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-success:hover {
            background-color: #574bdb;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        table th, table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #6c63ff;
            color: #fff;
            text-transform: uppercase;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        table a {
            color: #6c63ff;
            text-decoration: none;
            font-weight: bold;
        }

        table a:hover {
            text-decoration: underline;
        }

        /* Estilo de botones de acciones */
        .btn-action {
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-delete {
            background-color: #ff4c4c;
        }

        .btn-delete:hover {
            background-color: #e03c3c;
        }

        .btn-update {
            background-color: #00c853;
        }

        .btn-update:hover {
            background-color: #00a73d;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        @include("admin.navbar")

        <div class="container">
            <h1>Gestión de Órdenes</h1>

            <!-- Formulario de búsqueda -->
            <form action="{{url('/search')}}" method="get" class="mb-4">
                @csrf
                <input type="text" name="search" placeholder="Buscar orden...">
                <input type="submit" value="Buscar" class="btn btn-success">
            </form>

            <!-- Tabla de órdenes -->
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Nombre de la Comida</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Acción</th>
                        <th>Actualizar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $data)
                    <tr>
                        <td>{{$data->name}}</td>
                        <td>{{$data->phone}}</td>
                        <td>{{$data->address}}</td>
                        <td>{{$data->foodname}}</td>
                        <td>${{$data->price}}</td>
                        <td>{{$data->quantity}}</td>
                        <td>${{$data->price * $data->quantity}}</td>
                        <td>
                            <a href="{{url('/deleteorder', $data->id)}}" class="btn-action btn-delete">Borrar</a>
                        </td>
                        <td>
                            <a href="{{url('/updateview', $data->id)}}" class="btn-action btn-update">Actualizar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include("admin.adminscript")
</body>
</html>

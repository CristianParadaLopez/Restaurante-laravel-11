<x-app-layout>
</x-app-layout>

<!DOCTYPE html>
<html lang="es">
<head>
    @include("chef.chefcss")
    <style>
        .food-card {
            border: 2px solid #9c49fb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .food-card:hover {
            transform: translateY(-5px);
        }

        .food-image {
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        @include("chef.chefnavbar")

        <div class="container mt-5">
            <h1 class="mb-4">Menú de Comidas</h1>

            <div class="row">
                @foreach ($data as $food)
                <div class="col-md-4">
                    <div class="food-card">
                        @if($food->image)
                        <img src="{{ url('foodimage/' . $food->image) }}" alt="{{ $food->title }}">
                        
                        @endif

                        <h5 class="card-title">{{ $food->title }}</h5>
                        <p class="card-text"><strong>Precio:</strong> ${{ $food->price }}</p>
                        <p class="card-text"><strong>Descripción:</strong> {{ $food->description }}</p>
                        <p class="card-text"><strong>Calorías:</strong> {{ $food->calories }} kcal</p>
                        <p class="card-text"><strong>Proteínas:</strong> {{ $food->proteins }}</p>
                        <p class="card-text"><strong>Tamaño:</strong> {{ $food->size }}</p>

                        
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    @include("chef.chefscript")
</body>
</html>

<!DOCTYPE html>


  <head>
    <base href="/public">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">

    <title>Dalezius</title>
<!--
    
TemplateMo 558 Klassy Cafe

https://templatemo.com/tm-558-klassy-cafe

-->
    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

    <link rel="stylesheet" href="assets/css/templatemo-klassy-cafe.css">

    <link rel="stylesheet" href="assets/css/owl-carousel.css">

    <link rel="stylesheet" href="assets/css/theme.css">
    <link rel="stylesheet" href="asset/css/app.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .food-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            overflow: hidden;
        }
        .food-card:hover {
            transform: translateY(-5px);
        }
        .food-card .card-body {
            padding: 10px;
        }
        .food-card img {
            border-bottom: 1px solid #ddd;
        }
        .food-card h5 {
            font-size: 1rem;
            margin-bottom: 5px;
        }
        .food-card p {
            font-size: 0.85rem;
            margin-bottom: 5px;
        }
        .card-body {
            border: solid 4px #9c49fb;
            border-radius: solid;
        }
        .food-detail {
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    .food-detail img {
        max-width: 100%;
        border-radius: 8px;
    }
    </style>
</head>
<body>
    
    
    
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-12">
                    <nav class="main-nav d-flex justify-content-between align-items-center">
                        <!-- ***** Logo Start ***** -->
                        <a href="@auth {{ url('/redirects') }} @else {{ url('/') }} @endauth" class="logo">
                            <img src="assets/images/logo.png" height="100" width="100" alt="Logo">
                        </a>
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li  class="scroll-to-section" ">
                                <button id="theme-toggle" class="theme-button">
                                    <i id="theme-icon" class="fas fa-moon"></i> <!-- Ícono inicial de luna -->
                                </button>
                            </li>
                            <li class="scroll-to-section"><a href="#top" class="active">Hogar</a></li>
                            <li class="scroll-to-section"><a href="#about">Nosotros</a></li>
                            <li class="scroll-to-section"><a href="#menu">Menús</a></li>
                            <li class="scroll-to-section"><a href="#chefs">Chefs</a></li>
                            <li class="scroll-to-section"><a href="#reservation">Contáctanos</a></li>
                            <li class="scroll-to-section">
                                @auth
                                    <a href="{{url('/showcart',Auth::user()->id)}}">Carrito {{$count}}</a>
                                @else
                                    Carrito [0]
                                @endauth
                            </li>
                            <li>
                                @if (Route::has('login'))
                                    <div class="sm:fixed sm:top-0 sm:right-0 text-right">
                                        @auth
                                            <li><x-app-layout></x-app-layout></li>
                                        @else
                                            <li><a href="{{ route('login') }}" class="font-semibold">Iniciar Sesión</a></li>
                                            @if (Route::has('register'))
                                                <li><a href="{{ route('register') }}" class="ml-4 font-semibold">Registrarse</a></li>
                                            @endif
                                        @endauth
                                    </div>
                                @endif
                            </li>
                            
                        </ul>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>

<div class="container mt-5">
    <div class="food-detail">
        <h3>{{ $food->title }}</h3>
        <img src="{{ url('foodimage/' . $food->image) }}" alt="{{ $food->title }}">
        <p><strong>Precio:</strong> €{{ number_format($food->price, 2) }}</p>
        <p><strong>Descripción:</strong> {{ $food->description }}</p>
        <p><strong>Ingredientes:</strong> {{ $food->ingredients }}</p>
        <p><strong>Proteínas:</strong> {{ $food->proteins }}</p>
        <p><strong>Calorías:</strong> {{ $food->calories }} kcal</p>
        <p><strong>Tamaño:</strong> {{ $food->size }}</p>
    </div>
</div>

<footer>
    <!-- Pie de página -->
</footer>

<!-- Scripts -->
<script src="assets/js/jquery-2.1.0.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/custom.js"></script>

  
 

  <!-- jQuery -->
  <script src="assets/js/jquery-2.1.0.min.js"></script>

  <!-- Bootstrap -->
  <script src="assets/js/popper.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>

  <!-- Plugins -->
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/accordions.js"></script>
  <script src="assets/js/datepicker.js"></script>
  <script src="assets/js/scrollreveal.min.js"></script>
  <script src="assets/js/waypoints.min.js"></script>
  <script src="assets/js/jquery.counterup.min.js"></script>
  <script src="assets/js/imgfix.min.js"></script> 
  <script src="assets/js/slick.js"></script> 
  <script src="assets/js/lightbox.js"></script> 
  <script src="assets/js/isotope.js"></script> 
  
  <!-- Global Init -->
  <script src="assets/js/custom.js"></script>
  <script>

      $(function() {
          var selectedClass = "";
          $("p").click(function(){
          selectedClass = $(this).attr("data-rel");
          $("#portfolio").fadeTo(50, 0.1);
              $("#portfolio div").not("."+selectedClass).fadeOut();
          setTimeout(function() {
            $("."+selectedClass).fadeIn();
            $("#portfolio").fadeTo(50, 1);
          }, 500);
              
          });
      });

  </script>
  <script>
      const themeIcon = document.getElementById('theme-icon');
      let isDarkMode = false;
      themeIcon.addEventListener('click', () => {
          isDarkMode = !isDarkMode;
          document.body.classList.toggle('dark-mode', isDarkMode); // Cambia la clase del cuerpo para el modo oscuro
  
          // Alterna el icono entre sol y luna
          if (isDarkMode) {
              themeIcon.classList.replace('fa-moon', 'fa-sun');
          } else {
              themeIcon.classList.replace('fa-sun', 'fa-moon');
          }
      });
  </script>
</body>

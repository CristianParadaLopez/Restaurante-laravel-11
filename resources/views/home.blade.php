<!DOCTYPE html>
<html lang="es">

  <head>

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
    <!-- <link rel="stylesheet" href="asset/css/app.css"> -->
    <link rel="stylesheet" href="assets/css/lightbox.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    </head>
    
    <body>
    
    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->
    
    
    <!-- ***** Header Area Start ***** -->
<header class="luxury-header fixed-top">
  <nav class="navbar navbar-expand-lg navbar-dark px-4 py-3">
    <div class="container-fluid">

      <!-- Logo -->
      <a href="@auth {{ url('/redirects') }} @else {{ url('/') }} @endauth" class="navbar-brand d-flex align-items-center">
        <img src="assets/images/logo.png" alt="Dalezius" class="logo-img me-2">
        <span class="brand-name">Dalezius</span>
      </a>

      <!-- Botón toggle (modo móvil) -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menú -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
        <ul class="navbar-nav align-items-center mb-2 mb-lg-0">

          <!-- Secciones -->
          <li class="nav-item"><a class="nav-link active" href="#top">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">Nosotros</a></li>
          <li class="nav-item"><a class="nav-link" href="#menu">Menú</a></li>
          <li class="nav-item"><a class="nav-link" href="#chefs">Chefs</a></li>
          <li class="nav-item"><a class="nav-link" href="#reservation">Contáctanos</a></li>

          <!-- Carrito -->
          @auth
          <li class="nav-item">
            <a href="{{url('/showcart',Auth::user()->id)}}" class="nav-link">
              <i class="fas fa-shopping-cart"></i> Carrito ({{$count}})
            </a>
          </li>
          @else
          <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link">
              <i class="fas fa-shopping-cart"></i> Carrito
            </a>
          </li>
          @endauth

          <!-- Login / Register -->
          @if (Route::has('login'))
          <li class="nav-item dropdown ms-lg-3">
            @auth
              <x-app-layout></x-app-layout>
            @else
              <a href="{{ route('login') }}" class="nav-link">Iniciar Sesión</a>
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="nav-link">Registrarse</a>
              @endif
            @endauth
          </li>
          @endif

          <!-- Botón de tema -->
          <li class="nav-item ms-lg-4">
            <button id="theme-toggle" class="btn btn-outline-light rounded-circle">
              <i id="theme-icon" class="fas fa-moon"></i>
            </button>
          </li>

        </ul>
      </div>

    </div>
  </nav>
</header>
<!-- ***** Header Area End ***** -->


    <!-- ***** Main Banner Area Start ***** -->
    <div id="top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="left-content">
                        <div class="inner-content">
                            <h4>Dalezius </h4>
                            <h6>LA MEJOR EXPERIENCIA</h6>
                            <div class="main-white-button scroll-to-section">
                                <a href="#reservation">Haz Tu Reservación</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="main-banner header-text">
                        <div class="Modern-Slider">
                          <!-- Item -->
                          <div class="item">
                            <div class="img-fill">
                                <img src="assets/images/slide-01.jpg" alt="">
                            </div>
                          </div>
                          <!-- // Item -->
                          <!-- Item -->
                          <div class="item">
                            <div class="img-fill">
                                <img src="assets/images/slide-02.jpg" alt="">
                            </div>
                          </div>
                          <!-- // Item -->
                          <!-- Item -->
                          <div class="item">
                            <div class="img-fill">
                                <img src="assets/images/slide-03.jpg" alt="">
                            </div>
                          </div>
                          <!-- // Item -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- ***** About Area Starts ***** -->
    <section class="section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="left-text-content">
                        <div class="section-heading">
                            <h6>Sobre nosotros</h6>
                            <h2>Te dejamos un delicioso recuerdo</h2>
                        </div>
                        <div>
                        <h6>En nuestro restaurante, te invitamos a disfrutar de una experiencia culinaria excepcional, donde nuestros talentosos chefs se dedican a crear los mejores platillos, combinando ingredientes frescos y técnicas innovadoras para ofrecerte sabores únicos que deleitarán tu paladar y te dejarán con ganas de regresar por más.</h6>
                         </div>
                        <div class="row">
                            <div class="col-4">
                                <img src="assets/images/about-thumb-01.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img src="assets/images/about-thumb-02.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img src="assets/images/about-thumb-03.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="right-content">
                        <div class="thumb">
                            <a rel="nofollow" href="http://youtube.com"><i class="fa fa-play"></i></a>
                            <img src="assets/images/about-video-bg.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** About Area Ends ***** -->
<hr>
        <!-- INCLUIMOS LA AREA DE COMIDA -->
        @include("food")
        <hr>
        <!-- INCLUIMOS LA AREA DE CHEFS -->
        @include("foodchef")
 
        <!-- INCLUIMOS LA AREA DE RESERVACIONES -->
         @include("reservation")
   
    

    <!-- ***** Comida de la semana ***** -->
    @include("comidasemana")

    <!-- ***** Chefs Area Ends ***** --> 
    
    <footer>
    <div class="container">
        <!-- Social Icons -->
        <div class="right-text-content">
            <ul class="social-icons">
                <li><a href="https://www.facebook.com/"><i class="fab fa-facebook"></i></a></li>
                <li><a href="https://x.com/home"><i class="fab fa-twitter"></i></a></li>
                <li><a href="https://linkedin.com"><i class="fab fa-linkedin"></i></a></li>
                <li><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>

        <!-- Logo -->
        <div class="logo">
            <a href="/"><img src="assets/images/logohorizontal.png" alt="Logo"></a>
        </div>

        <!-- Texto -->
        <div class="left-text-content">
            <p>© Copyright Dalezius. All rights reserved.</p>
        </div>
    </div>
</footer>


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
    
    <script>
$(document).ready(function(){
  $(".menu-carousel").owlCarousel({
    items: 3,
    margin: 25,
    loop: true,
    autoplay: true,
    autoplayTimeout: 4000,
    autoplayHoverPause: true,
    smartSpeed: 600,
    nav: true,
    responsive:{
      0:{ items:1 },
      768:{ items:2 },
      1200:{ items:3 }
    }
  });
});
</script>

  </body>
</html>
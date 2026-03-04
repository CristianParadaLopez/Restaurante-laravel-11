<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Dalezius - La mejor experiencia culinaria">
  <meta name="author" content="Dalezius">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:wght@300;400;500;600&display=swap" rel="stylesheet">

  <title>Dalezius</title>

  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-klassy-cafe.css">
  <link rel="stylesheet" href="assets/css/owl-carousel.css">
  <link rel="stylesheet" href="assets/css/theme.css">
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
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
          aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
          <ul class="navbar-nav align-items-center gap-1 mb-2 mb-lg-0">

            <li class="nav-item"><a class="nav-link active" href="#top">Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="#about">Nosotros</a></li>
            <li class="nav-item"><a class="nav-link" href="#menu">Menú</a></li>
            <li class="nav-item"><a class="nav-link" href="#chefs">Chefs</a></li>
            <li class="nav-item"><a class="nav-link" href="#reservation">Contáctanos</a></li>

            <!-- Carrito -->
            @auth
            <li class="nav-item">
              <a href="{{ url('/showcart', Auth::user()->id) }}" class="nav-link cart-link">
                <i class="fas fa-shopping-cart me-1"></i>
                <span class="cart-badge">{{ $count }}</span>
              </a>
            </li>
            @else
            <li class="nav-item">
              <a href="{{ route('login') }}" class="nav-link">
                <i class="fas fa-shopping-cart"></i>
              </a>
            </li>
            @endauth

            <!-- Login / Register -->
            @if (Route::has('login'))
            <li class="nav-item d-flex align-items-center ms-lg-2">
              @auth
              <x-app-layout></x-app-layout>
              @else
              <a href="{{ route('login') }}" class="btn-nav-outline me-2">Iniciar Sesión</a>
              @if (Route::has('register'))
              <a href="{{ route('register') }}" class="btn-nav-gold">Registrarse</a>
              @endif
              @endauth
            </li>
            @endif

            <!-- Botón de tema -->
            <li class="nav-item ms-lg-2">
              <button id="theme-toggle" class="btn btn-theme-toggle rounded-circle" aria-label="Cambiar tema">
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
  <section id="top">
    <div class="hero-wrapper">

      <!-- Panel izquierdo -->
      <div class="hero-left">
        <div class="hero-left-overlay"></div>
        <div class="hero-left-content">
          <p class="hero-label">Bienvenido a</p>
          <h1 class="hero-title">Dalezius</h1>
          <p class="hero-subtitle">LA MEJOR EXPERIENCIA</p>
          <a href="#reservation" class="hero-cta scroll-to-section">Haz Tu Reservación</a>
        </div>
      </div>

      <!-- Panel derecho: slider -->
      <div class="hero-right">
        <div class="hero-slider owl-carousel">
          <div class="hero-slide" style="background-image: url('assets/images/slide-01.jpg')"></div>
          <div class="hero-slide" style="background-image: url('assets/images/slide-02.jpg')"></div>
          <div class="hero-slide" style="background-image: url('assets/images/slide-03.jpg')"></div>
        </div>
      </div>

    </div>
  </section>
  <!-- ***** Main Banner Area End ***** -->

  <!-- ***** About Area Starts ***** -->
  <section class="section" id="about">
    <div class="container">
      <div class="row align-items-center gy-5">
        <div class="col-lg-6 col-md-6 col-12">
          <div class="left-text-content">
            <div class="section-heading">
              <h6>Sobre nosotros</h6>
              <h2>Te dejamos un delicioso recuerdo</h2>
            </div>
            <p class="about-description">
              En nuestro restaurante, te invitamos a disfrutar de una experiencia culinaria excepcional,
              donde nuestros talentosos chefs se dedican a crear los mejores platillos, combinando
              ingredientes frescos y técnicas innovadoras para ofrecerte sabores únicos que deleitarán
              tu paladar y te dejarán con ganas de regresar por más.
            </p>
            <div class="about-thumbs">
              <div class="about-thumb-item">
                <img src="assets/images/about-thumb-01.jpg" alt="Dalezius cocina 1">
              </div>
              <div class="about-thumb-item">
                <img src="assets/images/about-thumb-02.jpg" alt="Dalezius cocina 2">
              </div>
              <div class="about-thumb-item">
                <img src="assets/images/about-thumb-03.jpg" alt="Dalezius cocina 3">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
          <div class="right-content">
            <div class="thumb">
              <a rel="nofollow" href="http://youtube.com" aria-label="Ver video">
                <i class="fa fa-play"></i>
              </a>
              <img src="assets/images/about-video-bg.jpg" alt="Dalezius video">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ***** About Area Ends ***** -->

  <hr class="section-divider">

  @include("food")

  <hr class="section-divider">

  @include("foodchef")

  @include("reservation")

  @include("comidasemana")

  <!-- ***** Footer ***** -->
  <footer>
    <div class="container">
      <div class="footer-inner">

        <div class="footer-social">
          <ul class="social-icons">
            <li><a href="https://www.facebook.com/" aria-label="Facebook"><i class="fab fa-facebook"></i></a></li>
            <li><a href="https://x.com/home" aria-label="Twitter"><i class="fab fa-twitter"></i></a></li>
            <li><a href="https://linkedin.com" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a></li>
            <li><a href="https://www.instagram.com/" aria-label="Instagram"><i class="fab fa-instagram"></i></a></li>
          </ul>
        </div>

        <div class="footer-logo">
          <a href="/"><img src="assets/images/logohorizontal.png" alt="Dalezius Logo"></a>
        </div>

        <div class="footer-copy">
          <p>&copy; 2025 Dalezius. Todos los derechos reservados.</p>
        </div>

      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="assets/js/jquery-2.1.0.min.js"></script>
  <script src="assets/js/popper.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
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
  <script src="assets/js/custom.js"></script>

  <script>
    // ===== Isotope portfolio filter =====
    $(function () {
      var selectedClass = "";
      $("p").click(function () {
        selectedClass = $(this).attr("data-rel");
        $("#portfolio").fadeTo(50, 0.1);
        $("#portfolio div").not("." + selectedClass).fadeOut();
        setTimeout(function () {
          $("." + selectedClass).fadeIn();
          $("#portfolio").fadeTo(50, 1);
        }, 500);
      });
    });

    // ===== Dark Mode Toggle =====
    (function () {
      const toggle = document.getElementById('theme-toggle');
      const icon = document.getElementById('theme-icon');
      let isDark = localStorage.getItem('dalezius-theme') === 'dark';

      function applyTheme() {
        document.body.classList.toggle('dark-mode', isDark);
        document.body.classList.toggle('light-mode', !isDark);
        icon.classList.toggle('fa-moon', !isDark);
        icon.classList.toggle('fa-sun', isDark);
      }

      applyTheme();

      toggle.addEventListener('click', () => {
        isDark = !isDark;
        localStorage.setItem('dalezius-theme', isDark ? 'dark' : 'light');
        applyTheme();
      });
    })();

    // ===== Owl Carousel Menu =====
    $(document).ready(function () {
      $(".menu-carousel").owlCarousel({
        items: 3,
        margin: 25,
        loop: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        smartSpeed: 600,
        nav: true,
        responsive: {
          0: { items: 1 },
          768: { items: 2 },
          1200: { items: 3 }
        }
      });
    });

    // ===== Owl Carousel: Hero Slider =====
    $(document).ready(function () {
      $(".hero-slider").owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: false,
        smartSpeed: 900,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        nav: true,
        dots: false,
        navText: [
          '<i class="fa fa-chevron-left"></i>',
          '<i class="fa fa-chevron-right"></i>'
        ]
      });
    });

    // ===== Navbar scroll effect =====
    $(window).on('scroll', function () {
      if ($(this).scrollTop() > 80) {
        $('.luxury-header').addClass('scrolled');
      } else {
        $('.luxury-header').removeClass('scrolled');
      }
    });
  </script>

</body>
</html>
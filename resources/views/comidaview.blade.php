<!DOCTYPE html>
<html lang="es">
<head>
  <!-- ======= META ======= -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Restaurante Dalezius — alta cocina con estilo y elegancia.">
  <meta name="author" content="Dalezius">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- ======= TÍTULO ======= -->
  <title>Dalezius </title>

  <!-- ======= FUENTES ======= -->
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- ======= CSS PRINCIPALES ======= -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-klassy-cafe.css">

  <!-- <link rel="stylesheet" href="assets/css/owl-carousel.css">
  <link rel="stylesheet" href="assets/css/lightbox.css"> -->
  <link rel="stylesheet" href="assets/css/theme.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/comida.css">

  <!-- ======= ESTILO INLINE MÍNIMO ======= -->
  <style>
    #top { padding-top: 120px; }
    .logo-img { width: 42px; height: auto; }
  </style>
</head>

<body>
  <!-- ======= PRELOADER ======= -->
  <div id="preloader">
    <div class="jumper"><div></div><div></div><div></div></div>
  </div>

  <!-- ======= NAVBAR ======= -->
  <header class="luxury-header fixed-top">
    <nav class="navbar navbar-expand-lg navbar-dark px-4 py-3">
      <div class="container-fluid">

        <!-- Logo -->
        <a href="@auth {{ url('/redirects') }} @else {{ url('/') }} @endauth" class="navbar-brand d-flex align-items-center">
          <img src="assets/images/logo.png" alt="Dalezius" class="logo-img me-2">
          <span class="brand-name">Dalezius</span>
        </a>

        <!-- Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
          <ul class="navbar-nav align-items-center mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link active" href="#top">Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="#about">Nosotros</a></li>
            <li class="nav-item"><a class="nav-link" href="#menu">Menú</a></li>
            <li class="nav-item"><a class="nav-link" href="#chefs">Chefs</a></li>
            <li class="nav-item"><a class="nav-link" href="#reservation">Contáctanos</a></li>

            <!-- Carrito -->
            @auth
            <li class="nav-item">
              <a href="{{ url('/showcart', Auth::user()->id) }}" class="nav-link">
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

  <!-- ======= SECCIÓN DE MENÚ ======= -->
  <main class="container" id="top">
    <h3 class="text-center mb-5">Menú de Comidas</h3>
    <div class="row justify-content-center">

      @foreach ($foods as $food)
      <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
        <div class="food-card shadow-lg">
          <img src="{{ url('foodimage/' . $food->image) }}" alt="{{ $food->title }}" class="card-img-top">
          <div class="card-body text-center">
            <h5 class="card-title">{{ $food->title }}</h5>
            <p class="card-text">${{ number_format($food->price, 2) }}</p>

            <a href="{{ route('infocomida', $food->id) }}" class="btn btn-outline-dark mb-3 w-100">Más información</a>

            <div class="d-flex justify-content-center align-items-center gap-2">
              <button class="btn btn-outline-secondary qty-btn minus" type="button">−</button>
              <input type="number" class="form-control text-center qty-input" value="1" min="1">
              <button class="btn btn-outline-secondary qty-btn plus" type="button">+</button>
            </div>

            <button class="btn add-to-cart mt-3 w-100" data-id="{{ $food->id }}">
              <i class="fa fa-shopping-cart"></i> Añadir
            </button>
          </div>
        </div>
      </div>
      @endforeach

    </div>
  </main>

  <!-- ======= FOOTER ======= -->
  <footer>
    <div class="container text-center">
      <div class="social-icons mb-3">
        <a href="https://www.facebook.com/"><i class="fab fa-facebook"></i></a>
        <a href="https://x.com/home"><i class="fab fa-x-twitter"></i></a>
        <a href="https://linkedin.com"><i class="fab fa-linkedin"></i></a>
        <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
      </div>

      <div class="logo mb-2">
        <a href="/"><img src="assets/images/logohorizontal.png" alt="Logo Dalezius"></a>
      </div>

      <p>© {{ date('Y') }} Dalezius. Todos los derechos reservados.</p>
    </div>
  </footer>

  <!-- ======= SCRIPTS ======= -->
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

  <!-- ======= MODO OSCURO ======= -->
  <script>
    const themeIcon = document.getElementById('theme-icon');
    const toggleBtn = document.getElementById('theme-toggle');
    let isDarkMode = false;

    toggleBtn.addEventListener('click', () => {
      isDarkMode = !isDarkMode;
      document.body.classList.toggle('dark-mode', isDarkMode);
      themeIcon.classList.replace(isDarkMode ? 'fa-moon' : 'fa-sun', isDarkMode ? 'fa-sun' : 'fa-moon');
    });
  </script>

  <!-- ======= CARRITO AJAX ======= -->
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const token = document.querySelector('meta[name="csrf-token"]').content;

    document.body.addEventListener('click', e => {
      if (e.target.classList.contains('qty-btn')) {
        const parent = e.target.closest('.card-body');
        const input = parent.querySelector('.qty-input');
        let val = parseInt(input.value) || 1;
        val += e.target.classList.contains('plus') ? 1 : -1;
        input.value = Math.max(1, val);
      }
    });

    document.body.addEventListener('click', async e => {
      const btn = e.target.closest('.add-to-cart');
      if (!btn) return;

      const card = btn.closest('.card-body');
      const input = card.querySelector('.qty-input');
      const qty = parseInt(input.value) || 1;
      const id = btn.dataset.id;

      btn.disabled = true;
      const oldHTML = btn.innerHTML;
      btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Añadiendo...';

      try {
        const resp = await fetch(`/addcart/${id}`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
          },
          body: new URLSearchParams({ quantity: qty })
        });

        if (resp.ok) showToast('🍽️ Añadido al carrito');
        else showToast('❌ Error al añadir', true);
      } catch {
        showToast('⚠️ Error de red', true);
      } finally {
        btn.disabled = false;
        btn.innerHTML = oldHTML;
      }
    });

    function showToast(message, error = false) {
      const toast = document.createElement('div');
      toast.className = 'toast-msg';
      toast.textContent = message;
      if (error) toast.style.background = '#dc3545';
      document.body.appendChild(toast);
      setTimeout(() => toast.classList.add('show'), 50);
      setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 400);
      }, 3000);
    }
  });
  </script>
</body>
</html>

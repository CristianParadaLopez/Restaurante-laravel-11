<div class="container-scroller">
  <link rel="stylesheet" href="assets/css/theme.css">
    <div class="row p-0 m-0 proBanner" id="proBanner">
      <div class="col-md-12 p-0 m-0">
        <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
          <div class="ps-lg-1">
            <div class="d-flex align-items-center justify-content-between">
              <p class="mb-0 font-weight-medium me-3 buy-now-text"></p>
              <a  class="btn me-2 buy-now-btn border-0"></a>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <a ><i class="mdi mdi-home me-3 text-white"></i></a>
            <button id="bannerClose" class="btn border-0 p-0">
              <i class="mdi mdi-close text-white me-0"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    
    

  
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <div style="height: 140px; width:140px; margin-left: 30px;" >
        <a class="sidebar-brand brand-logo"  href="/redirects"><img src="assets/images/logo.png" alt="logo" /></a>
      </div>
      
      <ul class="nav">
        
        
        
        <li class="nav-item menu-items">
          <a class="nav-link" href="{{url('meseromesas')}}">
            <span class="menu-icon">
              <i class="fas fa-chair"></i>
            </span>
            <span class="menu-title">MESAS</span>
          </a>
        </li>
        <li class="nav-item menu-items">
          <a class="nav-link" href="{{url('meseroreservation')}}">
            <span class="menu-icon">
              <i class="fas fa-calendar-check"></i>
            </span>
            <span class="menu-title">Reservaciones</span>
          </a>
        </li>   
      </ul>
    </nav>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(function() {
      var selectedClass = "";
      $("p").click(function() {
        selectedClass = $(this).attr("data-rel");
        $("#portfolio").fadeTo(50, 0.1);
        $("#portfolio div").not("." + selectedClass).fadeOut();
        setTimeout(function() {
          $("." + selectedClass).fadeIn();
          $("#portfolio").fadeTo(50, 1);
        }, 500);
      });
    });

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
    <!-- partial -->
    
    <!-- page-body-wrapper ends -->
  </div>
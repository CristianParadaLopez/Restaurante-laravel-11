<!-- container-scroller -->

<!-- plugins:js -->
<script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->

<!-- Plugin js for this page -->
<script src="{{ asset('admin/assets/vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('admin/assets/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
<!-- End plugin js for this page -->

<!-- inject:js -->
<script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('admin/assets/js/misc.js') }}"></script>
<script src="{{ asset('admin/assets/js/settings.js') }}"></script>
<script src="{{ asset('admin/assets/js/todolist.js') }}"></script>
<!-- endinject -->

<!-- Custom js for this page -->
<script src="{{ asset('admin/assets/js/dashboard.js') }}"></script>
<!-- End custom js for this page -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- ✅ Script de interacción y modo oscuro -->
<script>
  $(function() {
    // Animación del portafolio (por si existe el contenedor)
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

  // 🌓 Modo oscuro
  document.addEventListener('DOMContentLoaded', function() {
    const themeIcon = document.getElementById('theme-icon');
    if (!themeIcon) return; // Evita error si el icono no existe en esta vista

    let isDarkMode = false;

    themeIcon.addEventListener('click', () => {
      isDarkMode = !isDarkMode;
      document.body.classList.toggle('dark-mode', isDarkMode);

      // Cambiar el icono
      if (isDarkMode) {
        themeIcon.classList.replace('fa-moon', 'fa-sun');
      } else {
        themeIcon.classList.replace('fa-sun', 'fa-moon');
      }
    });
  });
</script>

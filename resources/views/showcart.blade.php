<!DOCTYPE html>
<html lang="es">

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
    
    <header class="header-area header-sticky">
        
        <div class="container">
            <div class="row">
                <div class="col-14">
                    <nav class="main-nav d-flex justify-content-between " style="margin-right: -10px;">
                        <!-- ***** Logo Start ***** -->
                        <a href="@auth {{ url('/redirects') }} @else {{ url('/') }} @endauth" class="logo">
                            <img src="assets/images/logo.png"  height="100" width="100" style="margin-left: 0;">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav d-flex align-items-center">
                            
                            <li class="scroll-to-section"><a href="#top" class="active">Hogar</a></li>
                            <li class="scroll-to-section"><a href="#about">nosotros</a></li>
                           	
                        <!-- 
                            <li class="submenu">
                                <a href="javascript:;">Drop Down</a>
                                <ul>
                                    <li><a href="#">Drop Down Page 1</a></li>
                                    <li><a href="#">Drop Down Page 2</a></li>
                                    <li><a href="#">Drop Down Page 3</a></li>
                                </ul>
                            </li>
                        -->
                            <li class="scroll-to-section"><a href="#menu">Menus</a></li>
                            <li class="scroll-to-section"><a href="#chefs">Chefs</a></li> 
                            <li class="submenu">
                                <a href="javascript:;">Características</a>
                                <ul>
                                    <li><a href="#">Features Page 1</a></li>
                                    <li><a href="#">Features Page 2</a></li>
                                    <li><a href="#">Features Page 3</a></li>
                                    <li><a href="#">Features Page 4</a></li>
                                </ul>
                            </li>
                            
                            <!-- <li class=""><a rel="sponsored" href="https://templatemo.com" target="_blank">External URL</a></li> -->
                            <li class="scroll-to-section"><a href="#reservation">Contactanos</a></li> 
                            @auth
                            <li class="scroll-to-section">
                                    
                                <a href="{{url('/showcart',Auth::user()->id)}}">
                                Carrito[{{$count}}]
                                </a>

                            </a></li>
                            @endauth
                            <li>
                                @if (Route::has('login'))
                                <div class="sm:fixed sm:top-0 sm:right-0  text-right ">
                                    @auth
                                        <li><x-app-layout></x-app-layout></li>
                                    @else
                                        <li><a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900">Iniciar Sesión</a></li>
                                        @if (Route::has('register'))
                                            <li><a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900">Registrarse</a></li>
                                        @endif
                                    @endauth
                                </div>
                                
                            @endif

                            </li>
                            <li  class="scroll-to-section" style="margin-left: 20px; margin-top: 40px;">
                                <button id="theme-toggle" class="theme-button">
                                    <i id="theme-icon" class="fas fa-moon"></i> <!-- Ícono inicial de luna -->
                                </button>
                            </li>
                            
                            
                            
                        </ul>        
                        <a class='menu-trigger'>
                            <span></span>
                        </a>
                        
                        <!-- ***** Menu End ***** -->
                        
                    </nav>
                </div>
            </div>
            
        </div>
    </header>
    <!-- ***** Header Area End ***** -->
    <div id="top" class="container mt-5">
        <div class="table-responsive">
            <form action="{{ url('orderconfirm') }}" method="POST">
                @csrf
                <table class="table table-bordered table-striped table-hover text-center">
                    <thead class="thead-dark" style="background-color: #f4d03f;">
                        <tr>
                            <th style="padding: 15px">Nombre de la comida</th>
                            <th style="padding: 15px">Precio</th>
                            <th style="padding: 15px">Cantidad</th>
                            <th style="padding: 15px">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>
                                    <input type="text" name="foodname[]" value="{{ $item->title }}" hidden>
                                    {{ $item->title }}
                                </td>
                                <td>
                                    <input type="text" name="price[]" value="{{ $item->price }}" hidden>
                                    {{ $item->price }}
                                </td>
                                <td>
                                    <input type="text" name="quantity[]" value="{{ $item->quantity }}" hidden>
                                    {{ $item->quantity }}
                                </td>
                                <td>
                                    <a class="btn btn-danger btn-sm" href="{{ url('/remove', $item->id) }}">Borrar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    
                <!-- Formulario de confirmación de orden -->
                <div id="appear" class="mt-4" style="display: none;">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white text-center">
                            <h4>Detalles de la Orden</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" class="form-control" placeholder="Nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone">Teléfono</label>
                                <input type="number" name="phone" class="form-control" placeholder="Número de teléfono" required>
                            </div>
                            <div class="mb-3">
                                <label for="address">Dirección</label>
                                <input type="text" name="address" class="form-control" placeholder="Dirección" required>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-success" type="submit">Confirmar Orden</button>
                                <button id="close" class="btn btn-danger" type="button">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    
        
    </div>
    
    
    <!-- Agregar interactividad con JavaScript -->
    
    
</form>

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
    document.getElementById('order').addEventListener('click', function() {
        document.getElementById('appear').style.display = 'block';
    });

    document.getElementById('close').addEventListener('click', function() {
        document.getElementById('appear').style.display = 'none';
    });
</script>
<script type="text/javascript">
    $("#order").click(
        function(){
            $("#appear").show();

        }
    );

    $("#close").click(
        function(){
            $("#appear").hide();

        }
    );
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
</body>
</html>
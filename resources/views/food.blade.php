<!-- ***** Menu Area Starts ***** -->
<section class="section" id="menu">
  <div class="container-fluid px-4">

    <!-- Encabezado -->
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8 text-center mx-auto">
        <div class="section-heading">
          <h6>Nuestro Menú</h6>
          <h2>Nuestra selección de platillos con sabor y calidad.</h2>
        </div>
      </div>
    </div>

    <!-- Carrusel de platillos -->
    <div class="menu-carousel owl-carousel owl-theme mt-5">
      @foreach ($foods as $item)
      <div class="menu-card" style="background-image:url('/foodimage/{{$item->image}}')">
        <div class="overlay"></div>
        <div class="price">
          <span>$ {{ $item->price }}</span>
        </div>
        <div class="info">
          <h3 class="title">{{ $item->title }}</h3>
          <p class="description">{{ $item->description }}</p>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Ver todas las comidas -->
    <div class="text-center mt-5">
      <a href="{{ route('comidaview') }}" class="btn-link big">Ver todas las comidas <i class="fa fa-angle-right"></i></a>
    </div>

  </div>
  
</section>
<!-- ***** Menu Area Ends ***** -->

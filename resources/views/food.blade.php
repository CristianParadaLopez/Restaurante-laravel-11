<!-- ***** Menu Area Starts ***** -->
<section class="section" id="menu">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="section-heading">
                    <h6>Nuestro Menu</h6>
                    <h2>Nuestra selección de platillos con sabor de calidad.</h2>
                </div>
            </div>
        </div>
    </div>


    
    <div class="menu-item-carousel">
        <div class="col-lg-12">
            <div class="owl-menu-item owl-carousel">
                @foreach ($data as $item)
                <form action="{{ url('/addcart', $item->id) }}" method="post">
                    @csrf
                    <div class="item">
                        <div style="background-image: url('/foodimage/{{$item->image}}')" class="card">
                            <div class="price">
                                <h6>$ {{$item->price}}</h6>
                            </div>
                            <div class="info">
                                <h1 class="title">{{$item->title}}</h1>
                                <p class="description">{{$item->description}}</p>
                                <div class="main-text-button">
                                    <div class="scroll-to-section">
                                        <a href="{{ route('comidaview') }}">Ver Todas las Comidas <i class="fa fa-angle-right"></i></a>
                                        <a href="#reservation">Haz tu Reservación <i class="fa fa-angle-down"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <!-- Contenedor flex para alinear cantidad y botón -->
                        <div class="d-flex align-items-center" style="padding-top: 4px">
                            <!-- Campo para cantidad -->
                            <input type="number" name="quantity" min="1" value="1" class="form-control" style="width: 80px; margin-right: 10px;">
            
                            <!-- Botón con ícono de carrito y color personalizado -->
                            <button type="submit" class="btn" style="background-color: #9c49fb; color: white;">
                                <i class="fa fa-shopping-cart"></i> Añadir
                            </button>
                        </div>
                    </div>
                </form>
                @endforeach 
            </div>
            
            
        </div>
    </div>
   
</div>

</section>
<!-- ***** Menu Area Ends ***** -->
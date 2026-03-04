<!-- ***** Chefs Area Starts ***** -->
<section class="section" id="chefs">
  <div class="container">

    <!-- Encabezado -->
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-8">
        <div class="section-heading">
          <h6>Nuestros Chefs</h6>
          <h2>Ellos ofrecen los mejores ingredientes para ti</h2>
        </div>
      </div>
    </div>

    <!-- Grid de chefs -->
    <div class="row g-4">
      @foreach ($foods as $chef)
      <div class="col-md-6 col-lg-4">
        <div class="chef-card">
          <div class="thumb">
            <img src="chefs/{{$chef->image}}" alt="{{ $chef->first_name }}">
            <div class="overlay">
              <ul class="social-icons">
                <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
              </ul>
            </div>
          </div>
          <div class="info">
            <h4>{{ $chef->first_name }}</h4>
            <span>{{ $chef->specialty }}</span>
          </div>
        </div>
      </div>
      @endforeach
    </div>

  </div>
</section>
<!-- ***** Chefs Area Ends ***** -->
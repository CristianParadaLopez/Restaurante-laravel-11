<section class="section" id="offers">
    <div class="container">
        <!-- Título de la sección -->
        <div class="row">
            <div class="col-lg-4 offset-lg-4 text-center">
                <div class="section-heading">
                    <h6>Semana elegante</h6>
                    <h2>Ofertas especiales de comidas de esta semana</h2>
                </div>
            </div>
        </div>

        <!-- Tabs horizontales -->
        <div class="row">
            <div class="col-lg-12">
                <div class="heading-tabs">
                    <ul class="horizontal-tabs">
                        @foreach($categories as $index => $category)
                            <li>
                                <a href="#tabs-{{ $index + 1 }}">
                                    <img src="assets/images/tab-icon-0{{ $index + 1 }}.png" alt="">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Contenido de tabs -->
        <div class="col-lg-12">
            <section class="tabs-content">
                @foreach($categories as $index => $category)
                    <article id="tabs-{{ $index + 1 }}">
                        <div class="row">
                            @foreach($category->foods as $food)
                                <div class="col-lg-6 col-md-12">
                                    <div class="tab-item">
                                        <img src="/foodimage/{{ $food->image }}" alt="{{ $food->title }}">
                                        <h4>{{ $food->title }}</h4>
                                        <p>{{ $food->description }}</p>
                                        <div class="price">
                                            <h6>${{ number_format($food->price, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </section>
        </div>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
  const tabs = document.querySelectorAll('.horizontal-tabs li a');
  const contents = document.querySelectorAll('.tabs-content article');

  function activateTab(tab) {
    tabs.forEach(t => t.classList.remove('active'));
    contents.forEach(c => c.style.display = 'none');

    tab.classList.add('active');
    const target = document.querySelector(tab.getAttribute('href'));
    if (target) target.style.display = 'block';
  }

  tabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      activateTab(tab);
    });
  });

  // Activar primer tab al cargar
  if (tabs.length > 0) activateTab(tabs[0]);
});

</script>
</section>

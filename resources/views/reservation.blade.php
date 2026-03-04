<!-- ***** Reservation Section Starts ***** -->
<section id="reservation" class="section">
  <div class="container">
    <div class="row align-items-center g-5">

      <!-- Lado izquierdo -->
      <div class="col-lg-6">
        <div class="reservation-info">
          <div class="section-heading">
            <h6>Contáctanos</h6>
            <h2>Haz tu reservación o visítanos para disfrutar de una experiencia inolvidable</h2>
          </div>
          <p>
            Puedes llamarnos o escribirnos por correo. Nuestro equipo estará encantado de ayudarte a reservar tu mesa o resolver cualquier consulta.
          </p>

          <div class="contact-cards">
            <div class="contact-box">
              <i class="fa fa-phone"></i>
              <div>
                <h4>Teléfonos</h4>
                <span><a href="#">080-090-0990</a><br><a href="#">080-090-0880</a></span>
              </div>
            </div>

            <div class="contact-box">
              <i class="fa fa-envelope"></i>
              <div>
                <h4>Correos</h4>
                <span><a href="#">hola@compañia.com</a><br><a href="#">info@compañia.com</a></span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Lado derecho -->
      <div class="col-lg-6">
        <div class="reservation-form">
          <form id="contact" action="{{ url('reservation') }}" method="POST">
            @csrf
            <h4>Reserva de Mesa</h4>

            <div class="row">
              <div class="col-md-6">
                <input type="text" name="name" id="name" placeholder="Tu Nombre *" required>
              </div>
              <div class="col-md-6">
                <input type="email" name="email" id="email" placeholder="Tu Correo *" required>
              </div>

              <div class="col-md-6">
                <input type="text" name="phone" id="phone" placeholder="Teléfono *" required>
              </div>
              <div class="col-md-6">
                <input type="number" name="guest" placeholder="Número de invitados *" required>
              </div>

              <div class="col-md-6">
                <input type="date" name="date" id="date" required>
              </div>
              <div class="col-md-6">
                <input type="time" name="time" id="time" required>
              </div>

              <div class="col-12">
                <textarea name="message" id="message" rows="5" placeholder="Mensaje (opcional)"></textarea>
              </div>

              <div class="col-12">
                <button type="submit" class="main-btn">Reservar Mesa</button>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

  <!-- Toast dinámico -->
  <div id="toast" class="toast"></div>
</section>
<!-- ***** Reservation Section Ends ***** -->

<!-- Script de envío y toast -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('contact');
  const toast = document.getElementById('toast');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    const btn = form.querySelector('button');
    const prevText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Enviando...';

    try {
      const resp = await fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });

      let data = {};
      try { data = await resp.json(); } catch {}

      if (resp.ok && (data.success || resp.status === 200)) {
        showToast('✅ ¡Reserva enviada con éxito!', 'success');
        form.reset();
      } else {
        const msg = data.message || 'Ocurrió un error al enviar tu reserva.';
        showToast('⚠️ ' + msg, 'error');
      }

    } catch (error) {
      console.error(error);
      showToast('🚫 Error de conexión. Intenta nuevamente.', 'error');
    } finally {
      btn.disabled = false;
      btn.textContent = prevText;
    }
  });

  function showToast(message, type = 'success') {
    toast.textContent = message;
    toast.className = 'toast ' + type + ' show';
    setTimeout(() => toast.classList.remove('show'), 4000);
  }
});
</script>

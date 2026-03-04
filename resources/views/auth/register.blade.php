<x-guest-layout>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrarse — Dalezius</title>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Poppins:wght@300;400;500;600&family=Cormorant+Garamond:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
</head>
<body>

<div class="auth-wrapper">

  <div class="auth-form-panel">
    <div class="form-header">
      <h2>Crear una cuenta</h2>
      <p>Únete y disfruta la experiencia Dalezius</p>
    </div>

    <x-validation-errors class="alert-error" />

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="fields-grid">

        <div class="field-group">
          <label class="field-label" for="name">Nombre</label>
          <div class="field-wrapper">
            <i class="fas fa-user field-icon"></i>
            <input id="name" class="field-input" type="text" name="name"
              value="{{ old('name') }}" placeholder="Tu nombre"
              required autofocus autocomplete="name">
          </div>
        </div>

        <div class="field-group">
          <label class="field-label" for="email">Correo</label>
          <div class="field-wrapper">
            <i class="fas fa-envelope field-icon"></i>
            <input id="email" class="field-input" type="email" name="email"
              value="{{ old('email') }}" placeholder="correo@ejemplo.com"
              required autocomplete="username">
          </div>
        </div>

        <div class="field-group">
          <label class="field-label" for="password">Contraseña</label>
          <div class="field-wrapper">
            <i class="fas fa-lock field-icon"></i>
            <input id="password" class="field-input" type="password" name="password"
              placeholder="Mínimo 8 caracteres"
              required autocomplete="new-password">
          </div>
        </div>

        <div class="field-group">
          <label class="field-label" for="password_confirmation">Confirmar contraseña</label>
          <div class="field-wrapper">
            <i class="fas fa-lock field-icon"></i>
            <input id="password_confirmation" class="field-input" type="password"
              name="password_confirmation" placeholder="Repite tu contraseña"
              required autocomplete="new-password">
          </div>
        </div>

      </div>

      @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
        <div class="terms-row">
          <input type="checkbox" name="terms" id="terms" required>
          <label for="terms">
            {!! __('Acepto los :terms_of_service y la :privacy_policy', [
              'terms_of_service' => '<a href="'.route('terms.show').'" target="_blank">Términos de Servicio</a>',
              'privacy_policy'   => '<a href="'.route('policy.show').'" target="_blank">Política de Privacidad</a>',
            ]) !!}
          </label>
        </div>
      @endif

      <button type="submit" class="btn-auth">Registrarse</button>
    </form>

    <p class="form-footer">
      ¿Ya tienes cuenta?&nbsp;<a href="{{ route('login') }}">Inicia sesión</a>
    </p>
  </div>

  <div class="auth-banner">
    <img src="{{ asset('assets/images/logo.png') }}" alt="Dalezius" class="banner-logo">
    <h1 class="banner-title">Dalezius</h1>
    <div class="banner-divider"></div>
    <p class="banner-subtitle">La mejor experiencia</p>
    <p class="banner-tagline">Únete a nuestra familia<br>y disfruta sabores<br>que no olvidarás.</p>
  </div>

</div>
</body>
</html>
</x-guest-layout>
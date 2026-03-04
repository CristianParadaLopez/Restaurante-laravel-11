<x-guest-layout>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar Sesión — Dalezius</title>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Poppins:wght@300;400;500;600&family=Cormorant+Garamond:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<body>

<div class="auth-wrapper">

  <div class="auth-banner">
    <img src="{{ asset('assets/images/logo.png') }}" alt="Dalezius" class="banner-logo">
    <h1 class="banner-title">Dalezius</h1>
    <div class="banner-divider"></div>
    <p class="banner-subtitle">La mejor experiencia</p>
    <p class="banner-tagline">Ingredientes frescos,<br>sabores únicos,<br>momentos inolvidables.</p>
  </div>

  <div class="auth-form-panel">
    <div class="form-header">
      <h2>Bienvenido de nuevo</h2>
      <p>Ingresa tus credenciales para continuar</p>
    </div>

    <x-validation-errors class="alert-error" />

    @if (session('status'))
      <div class="alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="field-group">
        <label class="field-label" for="email">Correo Gmail</label>
        <div class="field-wrapper">
          <i class="fas fa-envelope field-icon"></i>
          <input id="email" class="field-input" type="email" name="email"
            value="{{ old('email') }}" placeholder="ejemplo@gmail.com"
            required autofocus autocomplete="username">
        </div>
      </div>

      <div class="field-group">
        <label class="field-label" for="password">Contraseña</label>
        <div class="field-wrapper">
          <i class="fas fa-lock field-icon"></i>
          <input id="password" class="field-input" type="password" name="password"
            placeholder="••••••••" required autocomplete="current-password">
        </div>
      </div>

      <div class="form-meta">
        <label class="remember-label">
          <input type="checkbox" class="recordame" id="remember_me" name="remember">
          Recordarme
        </label>
        @if (Route::has('password.request'))
          <a class="forgot-link" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
        @endif
      </div>

      <button type="submit" class="btn-auth">Acceder</button>
    </form>

    <p class="form-footer">
      ¿Aún no tienes cuenta?&nbsp;
      @if (Route::has('register'))
        <a href="{{ route('register') }}">Regístrate gratis</a>
      @endif
    </p>
  </div>

</div>
</body>
</html>
</x-guest-layout>
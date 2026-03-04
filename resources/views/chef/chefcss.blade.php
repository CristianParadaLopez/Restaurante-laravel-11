<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Perfil del Chef | Corona Admin</title>

<!-- plugins:css -->
<link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">
<!-- endinject -->

<!-- Plugin css for this page -->
<link rel="stylesheet" href="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/vendors/owl-carousel-2/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/vendors/owl-carousel-2/owl.theme.default.min.css') }}">
<!-- End plugin css for this page -->

<!-- Layout styles -->
<link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
<!-- End layout styles -->

<link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.png') }}" />

<!-- Tema general -->
<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">

<!-- ✅ Estilos personalizados del perfil del chef -->
<style>
  body {
    background-color: #121212;
    color: #fff;
    font-family: 'Poppins', sans-serif;
  }

  .profile-container {
    max-width: 800px;
    margin: 60px auto;
    background: #1f1f1f;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.05);
    padding: 40px;
    text-align: center;
    transition: all 0.3s ease;
  }

  .profile-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 25px rgba(255, 255, 255, 0.1);
  }

  .profile-image {
    width: 160px;
    height: 160px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
    border: 4px solid #ffcc00;
  }

  .card-title {
    font-size: 24px;
    font-weight: bold;
    color: #ffcc00;
    margin-bottom: 10px;
  }

  .card-text {
    font-size: 16px;
    color: #ccc;
    margin-bottom: 8px;
  }

  .edit-btn {
    margin-top: 25px;
    background-color: #ffcc00;
    color: #000;
    border: none;
    padding: 10px 25px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
  }

  .edit-btn:hover {
    background-color: #e6b800;
    transform: scale(1.05);
  }

  .dark-mode {
    background-color: #0d0d0d;
    color: #f1f1f1;
  }

  .dark-mode .profile-container {
    background-color: #181818;
  }
</style>

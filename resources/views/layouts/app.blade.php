<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Dashboard' }} - Absenin</title>

  <!-- Bootstrap & Stisla CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/stisla/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/stisla/css/components.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/stisla@2.3.0/assets/modules/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/stisla@2.3.0/assets/modules/fontawesome/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/stisla@2.3.0/assets/css/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/stisla@2.3.0/assets/css/components.css">
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      @include('layouts.navbar')
      @include('layouts.sidebar')

      <button id="toggleSidebar" class="btn btn-primary d-md-none">
        <i class="fas fa-bars"></i>
    </button>

      <div class="main-content">
        @yield('content')
      </div>

      @include('layouts.footer')
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/stisla/js/stisla.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/stisla/js/scripts.js"></script>
  <script>
    document.getElementById('toggleSidebar').addEventListener('click', function () {
        document.querySelector('.main-sidebar').classList.toggle('active');
    });
</script>

</body>
</html>

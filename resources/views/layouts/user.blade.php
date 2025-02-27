<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Scan STO</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Favicons -->
  <link href="{{ asset('assets/img/icon-kbi.png') }}" rel="icon">
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/form.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <style>
    .loader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: #282828;
      /* Solid background color */
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
  </style>
</head>

<body>
  {{-- loader --}}
  <div class="loader" id="loader">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
  {{-- loader --}}
  <section class="section">
    <nav class="navbar navbar-form shadow-sm">
      <div class="container container-fluid">
        <div class="d-flex flex-column align-items-start">
          <div class="d-flex align-items-center">
            <a href="{{ route('sto.index') }}" class="text-white">
              <i class="fas fa-warehouse me-2"></i> Scan STO
            </a>
          </div>
          @if (isset($inventory))
            <p class="colom mt-1" style="font-size: 17px; margin-bottom: -1px; color:rgb(255, 255, 255);">
              <i class="fas fa-file-invoice"></i>&nbsp;&nbsp;Inventory ID&nbsp;:&nbsp;
              <strong
                style="width: 5px; font-size: 20px; color:rgb(255, 225, 0); padding: 1px; text-transform: uppercase;">
                {{ $inventory->inventory_id ?? 'Not Available' }}
              </strong>
            </p>
            <p class="colom mt-1" style="font-size: 17px; margin-bottom: -1px; color:rgb(255, 255, 255);">
              <i class="fas fa-building"></i>&nbsp;&nbsp;Customer&nbsp;:&nbsp;
              <strong
                style="width: 5px; font-size: 20px; color:rgb(255, 213, 0); padding: 1px; text-transform: uppercase;">
                {{ $inventory->customer ?? 'Not Available' }}
              </strong>
            </p>
          @endif
        </div>
        <div class="d-flex flex-column align-items-end">
          <div class="dropdown">
            <div class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown"
              data-bs-toggle="dropdown" aria-expanded="false" role="button">
              <small class="d-block">
                <i class="fas fa-user me-1" style="color:#1abc9c;"></i>
                {{ Auth::user()->username ?? 'Guest' }}
              </small>
            </div>
            <ul class="dropdown-menu dropdown-menu-end bg-dark text-white" aria-labelledby="userDropdown">
              <li>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="dropdown-item text-white bg-dark">Log Out</button>
                </form>
              </li>
            </ul>
          </div>

          @if (isset(Auth::user()->last_login))
            <small>
              {{ \Carbon\Carbon::parse(Auth::user()->last_login)->format('d-m-Y H:i:s') }}
            </small>
          @endif
        </div>

      </div>
    </nav>
    @if (session('success'))
      <div class="container mt-3">
        <div id="alertSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @endif
    @if (session('notfound'))
      <div class="container mt-3">
        <div id="alertWarning" class="alert alert-warning alert-dismissible fade show" role="alert">
          {{ session('notfound') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @endif
    @if (session('error'))
      <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @endif
    @if ($errors->any())
      <div class="container mt-3">
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    @endif


    @yield('contents')

  </section>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  {{-- jsload --}}
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

  <script>
    window.addEventListener('load', function() {
      // Sembunyikan loader setelah halaman selesai dimuat
      document.getElementById('loader').style.display = 'none';
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  @yield('script')
  {{-- reload with ajax  --}}

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ASOM</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/orange.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <script src="{{ url('assets/js/jquery-3.3.1.min.js') }}"></script>

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Orange</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/inconnu.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">Admin</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Admin</h6>
              <span>Administrateur ASOM</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="deconnexion">
                <i class="bi bi-box-arrow-right"></i>
                <span>Deconnexion</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed{{ Request::is('Tournoi')}} ? 'active' : 'collapsed' }}" href="{{url('Tournoi');}}">
          <i class="bi bi-grid"></i>
          <span>Tournoi</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item ">
        <a class="nav-link  collapsed{{ Request::is('TypeTournoi')}} ? 'active' : 'collapsed' }}" href="{{url('TypeTournoi');}}">
          <i class="bi bi-grid"></i>
          <span>Type de tournoi</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item ">
        <a class="nav-link collapsed{{ Request::is('Equipe')}} ? 'active' : 'collapsed' }}" href="{{url('Equipe');}}">
          <i class="bi bi-grid"></i>
          <span>Equipe</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item ">
        <a class="nav-link collapsed{{ Request::is('PeriodePronostic')}} ? 'active' : 'collapsed' }}" href="{{url('PeriodePronostic');}}">
          <i class="bi bi-grid"></i>
          <span>Periode de pronostic</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item ">
        <a class="nav-link collapsed{{ Request::is('PhaseJeu')}} ? 'active' : 'collapsed' }}" href="{{url('PhaseJeu');}}">
          <i class="bi bi-grid"></i>
          <span>Phase de jeu</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item ">
        <a class="nav-link collapsed{{ Request::is('TypeMatch')}} ? 'active' : 'collapsed' }}" href="{{url('TypeMatch');}}">
          <i class="bi bi-grid"></i>
          <span>Type de match</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item ">
        <a class="nav-link collapsed{{ Request::is('AdminStatistique')}} ? 'active' : 'collapsed' }}" href="{{url('AdminStatistique');}}">
          <i class="bi bi-grid"></i>
          <span>Statistique</span>
        </a>
      </li><!-- End Dashboard Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">
    @yield('contenu')
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
<script>
  $(document).ready(function(){
    $(".toggle-sidebar-btn").click(function(){
      var sidebar=$(".sidebar");
      if(sidebar.is(":visible")){
        sidebar.hide();
      }
      else{
        sidebar.show();
      }
    });
  });
</script>

</body>

</html>
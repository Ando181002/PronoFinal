<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
    <!-- Favicons -->
    <link href="assets/img/orange.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  
    <!-- Vendor CSS Files -->
    <link href="{{ url('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ url('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ url('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ url('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ url('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  
    <!-- Template Main CSS File -->
    <link href="{{ url('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>
@extends('Personnel.Entete')
@section('content')
<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">

        </div>
        @if(session('erreur'))
          <div class="alert alert-danger">
              {{ session('erreur') }}
          </div>
        @endif
        <div class="pagetitle">
            <h1>Bonjour {{$perso->nom}}</h1>
            <nav>
                <p class="breadcrumb-item">Veuillez remplir le formulaire pour participer aux pronostics.</p>
            </nav>
        </div><!-- End Page Title -->
         <!-- Recent Sales -->
         <div class="col-12">
            <div class="card recent-sales overflow-auto">
              <div class="card-body">
                <h5 class="card-title">{{$tournoi->nomtournoi}}</h5>
                <h6>Frais de participation <span style="color: orange">{{$tournoi->frais}}Ar</span></h6>
                <p> </p>
                <form class="row g-3" action="{{url('participer')}}" method="post">
                  @csrf
                  <input type="hidden" value="{{$tournoi->idtournoi}}" name="idtournoi">
                    <div class="col-md-6">
                        <label for="inputEmail5" class="form-label">Equipe1</label>
                        <select name="idequipe1g" id="" class="form-control">
                          @foreach ($equipes as $equipe)
                            <option value="{{$equipe->idequipe}}">{{$equipe->nomequipe}}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="inputPassword5" class="form-label">Equipe2</label>
                        <select name="idequipe2g" id="" class="form-control">
                          @foreach ($equipes as $equipe)
                            <option value="{{$equipe->idequipe}}">{{$equipe->nomequipe}}</option>
                            @endforeach
                        </select>                     
                       </div>
                    <div class="col-12">
                      <label for="inputPassword4" class="form-label"> Quel sera le total des points du vainqueur du concours de pronostics ?</label>
                      <input type="text" class="form-control" name="reponsequestion">
                    </div>
                    <div class="col-12">
                      <label for="inputAddress" class="form-label">Numero</label>
                      <input type="text" class="form-control" placeholder="Entrez votre numero" name="numero">
                    </div>
                    <div class="col-12">
                      <label for="inputAddress" class="form-label">Code secret</label>
                      <input type="password" class="form-control" placeholder="Entrez votre code secret" name="codesecret">
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                  </form><!-- Vertical Form -->
                
              </div>

            </div>
          </div><!-- End Recent Sales -->
    </div>
  </section>
  @endsection
  <!-- Vendor JS Files -->
 <script src="{{ url('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
 <script src="{{ url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ url('assets/vendor/chart.js/chart.min.js') }}"></script>
 <script src="{{ url('assets/vendor/echarts/echarts.min.js') }}"></script>
 <script src="{{ url('assets/vendor/quill/quill.min.js') }}"></script>
 <script src="{{ url('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
 <script src="{{ url('assets/vendor/tinymce/tinymce.min.js') }}"></script>
 <script src="{{ url('assets/vendor/php-email-form/validate.js') }}"></script>

 <!-- Template Main JS File -->
 <script src="{{ url('assets/js/main.js') }}"></script>
 <script src="{{ url('assets/js/jquery-3.3.1.min.js') }}"></script>
 <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
 <script src="{{ url('assets/js/jquery.magnific-popup.min.js') }}"></script>
 <script src="{{ url('assets/js/jquery.slicknav.js') }}"></script>
 <script src="{{ url('assets/js/owl.carousel.min.js') }}"></script>
</body>
</html>
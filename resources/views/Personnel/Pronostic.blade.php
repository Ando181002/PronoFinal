<!DOCTYPE html>
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

<<<<<<< Updated upstream
 <!-- Hero Section Begin -->
 <section class="hero-section set-bg" data-setbg="{{ url('assets/img/hero-1.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hs-item">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="hs-text">
                                    <h4>30 september 2019 / 9:00 GMT+0000</h4>
                                    <h2>Airrosten VS Lerenort in London</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End --> 
=======
 
>>>>>>> Stashed changes
<p> </p>
<section class="schedule-section spad">
    <div class="container">
        <div class="schedule-text">
            <h4 class="st-title">{{$tournoi->nomtournoi}}</h4>
            <div class="card">
            <div class="card-body">
            <div class="st-table">
                <table>
                    <tbody>
                        @foreach($matchs as $match)
                        <tr>
                            <td class="left-team">
                                <img src="data:image/JPEG;base64,{{ $match->imageequipe1 }}" alt="">
                                <h4>{{$match->nomequipe1}}</h4>
                            </td>
                            <td class="st-option">
                                <div class="so-text">{{ $match->stade }}</div>
                                <?php if($match->avecresultat==0) { 
                                if(now()>$match->datelimite) { ?>
                                    <a href="#" disabled></a><h4 style="color: black">VS</h4>
                                <?php } else { 
                                    if($match->etat==0) { ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#resultat{{ $match->idmatch }}"><h4>VS</h4></a>
                                    <div class="modal fade" id="resultat{{ $match->idmatch }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Saisir pronostic</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="breadcrumb-item">Points à gagner: <span class="card-title">{{$match->ptresultat}} + {{$match->ptscore}}</span></p>
                                            <form class="row g-3" method="POST" action="/{{$match->idinscription}}/{{$match->idtournoi}}/addUPronostic">
                                                @csrf
                                                <input type="hidden" name="idmatch" value="{{$match->idmatch}}">
                                                <div class="col-md-6">
                                                    <label for="inputEmail5" class="form-label">{{ $match->nomequipe1 }}</label>
                                                    <input type="text" class="form-control" name="prono1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputPassword5" class="form-label">{{ $match->nomequipe2 }}</label>
                                                    <input type="text" class="form-control" name="prono2">
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">Valider</button>
                                                </div>
                                                </form><!-- End Multi Columns Form -->
                                            </div><!-- End Vertically centered Modal-->
                                        </div>
                                        </div>
                                        </div>
                                <?php } else { ?>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#resultat{{ $match->idmatch }}"><h4>VS</h4></a>
                                <div class="modal fade" id="resultat{{ $match->idmatch }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title">Votre pronostic</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <p class="breadcrumb-item">Points à gagner: <span class="card-title">{{$match->ptresultat}} + {{$match->ptscore}}</span></p>
                                            <form class="row g-3" method="POST" action="/{{$match->idinscription}}/{{$match->idtournoi}}/addPronostic">
                                            @csrf
                                                <div class="col-md-6">
                                                <label for="inputEmail5" class="form-label">{{ $match->nomequipe1 }}</label>
                                                <input type="text" class="form-control" value="{{$match->prono1}}" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                <label for="inputPassword5" class="form-label">{{ $match->nomequipe2 }}</label>
                                                <input type="text" class="form-control" value="{{$match->prono2}}" disabled>
                                                </div>
                                            </form><!-- End Multi Columns Form -->
                                            </div><!-- End Vertically centered Modal-->
                                        </div>
                                        </div>
                                    </div>                                        
                                    <?php } } } else { ?>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#classement{{ $match->idmatch }}"><h4>{{$match->score1}} : {{$match->score2}}</h4></a>
                                <div class="modal fade" id="classement{{ $match->idmatch }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title">Classement</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <p class="breadcrumb-item">Vous avez gagné <span class="card-title">{{$match->pointresultat}}+{{$match->pointscore}} points</span></p>
                                            <form class="row g-3">
                                                <div class="col-md-6">
                                                <label for="inputEmail5" class="form-label">{{ $match->nomequipe1 }}</label>
                                                <input type="equipe1" class="form-control" id="inputEmail5" value="{{ $match->prono1 }}" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                <label for="inputPassword5" class="form-label">{{ $match->nomequipe2 }}</label>
                                                <input type="equipe2" class="form-control" id="inputPassword5" value="{{ $match->prono2 }}" disabled>
                                                </div>
                                            </form><!-- End Multi Columns Form -->
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Rang</th>
                                                    <th scope="col">Trigramme</th>
                                                    <th scope="col">Pronostics</th>
                                                    <th scope="col">Points</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($classements[$match->idmatch] as $classementItem)
                                                <tr>
                                                    <th scope="row">{{ $classementItem->numligne }}</th>
                                                    <td>{{ $classementItem->trigramme }}</td>
                                                    <td>{{ $classementItem->prono1 }} - {{ $classementItem->prono2 }}</td>
                                                    <td>{{ $classementItem->total }}</td>
                                                </tr>
                                                @endforeach
                                            
                                                
                                                </tbody>
                                            </table>
                                            </div><!-- End Vertically centered Modal-->
                                        </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="so-text">{{$match->datematch}}</div>
                            </td>
                            <td class="right-team">
                                <img src="data:image/JPEG;base64,{{ $match->imageequipe2 }}" alt="">
                                <h4>{{$match->nomequipe2}}</h4>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Recompense</h5>
                            <?php 
                            $montantCagnote=count($montantCagnote)*$tournoi->frais;
                            ?>
                            <nav>
                                <p class="breadcrumb-item">Montant de la cagnote <span class="card-title">{{$montantCagnote}}Ar</span></p>
                            </nav>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Rang</th>
                                        <th scope="col">Taux</th>
                                        <th scope="col">Montant(Ar)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i=1; $i <=5 ; $i++) { 
                                        $rang="rang".$i;
                                        $pourcentage=$tournoi->$rang;
                                        $montant=$montantCagnote*($tournoi->$rang/100);
                                        ?>
                                    <tr>
                                        <th scope="row">{{$i}}</th>
                                        <td>{{$pourcentage}}%</td>
                                        <td>{{$montant}}Ar</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Classement</h5>
                            <nav>
                                <p class="breadcrumb-item"> <span class="card-title"> </span></p>
                            </nav>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Rang</th>
                                        <th scope="col">Trigramme</th>
                                        <th scope="col">Points</th>
                                        <th scope="col">Récompense(Ar)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($classementGlobal as $classement) 
                                    <tr>
                                        <th scope="row">{{$classement->rang}}</th>
                                        <td>{{$classement->trigramme}}</td>
                                        <td>{{$classement->pointfinal()}}</td>
                                        <td>{{$classement->montant}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                         </div> 
                    </div>
                </div>                      
            </div>
        </section>
    </div>
</section>
<!-- Schedule Section End -->
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

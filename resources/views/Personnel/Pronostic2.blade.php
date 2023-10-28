<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ASOM</title>
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
<div style="height: 100px"></div>
<!-- Schedule Section Begin -->
<section class="schedule-section spad">
    <div class="container">
        <div class="pagetitle">
            <h1>Bonjour {{$inscription->Compte->nom}}</h1>
            <nav>
                <p class="breadcrumb-item">Vous avez actuellement <span class="card-title">{{$inscription->pointParPhase(0)}} points</span></p>
            </nav>
            <a href="#" data-bs-toggle="modal" data-bs-target="#historique{{ $inscription->idinscription }}"><h4>Historique</h4></a>
            <div class="modal fade" id="historique{{ $inscription->idinscription }}" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Historique</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="row g-3" method="get" action="#">
                                <div class="col-md-4">    
                                    <select name="idphase" class="form-select">
                                        <option value="0">Globale</option>
                                        @foreach($phasejeu as $phase)
                                            <option value="{{$phase->idphase}}">{{$phase->nomphase}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Rechercher</button>
                                </div>
                            </form><!-- End No Labels Form -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Type de match</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Equipe1</th>
                                        <th></th>
                                        <th scope="col">Equipe2</th>
                                        <th scope="col">Point résultat</th>
                                        <th scope="col">Point score</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inscription->pronostics as $pronostic)
                                    <?php $match=$pronostic->Match;?>
                                    <tr>
                                        <td>{{$match->typeMatch->nomtypematch}}</td>
                                        <td>{{$pronostic->datepronostic}}</td>
                                        <td>{{$match->Equipe1->nomequipe}}</td>
                                        <td>{{$pronostic->prono1}} - {{$pronostic->prono2}}</td>
                                        <td> {{$match->Equipe2->nomequipe}}</td>
                                        <td>{{$pronostic->points()[0]}}</td>
                                        <td>{{$pronostic->points()[1]}}</td>
                                        <td>{{$pronostic->totalpoint()}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>  
                        </div><!-- End Vertically centered Modal-->
                    </div>
                </div>
            </div>
        </div><!-- End Page Title --> 
        <div class="row">
            <div class="schedule-text">
                <h4 class="st-title">{{$tournoi->nomtournoi}}</h4>
                <div class="st-table">
                    <table>
                        <tbody>
                            @foreach($matchs as $match)
                            <tr>
                                <td class="left-team">
                                    <img src="data:image/JPEG;base64,{{ $match->Equipe1->imageequipe }}" alt="">
                                    <h4>{{$match->Equipe1->nomequipe}}</h4>
                                </td>
                                <td class="st-option">
                                    <div class="so-text">{{$match->stade}}</div>
                                    @if($match->avecresultat==0)
                                        @if(now()>$match->limitePronostic())
                                            <a href="#" disabled></a><h4 style="color: black">VS</h4>
                                        @else
                                            @if($inscription->pronosticParMatch($match->idmatch)!=null)
                                                <?php $pronostic=$inscription->pronosticParMatch($match->idmatch); ?>
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
                                                                        <label for="inputEmail5" class="form-label">{{ $match->Equipe1->nomequipe }}</label>
                                                                        <input type="text" class="form-control" value="{{$pronostic->prono1}}" disabled>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="inputPassword5" class="form-label">{{ $match->Equipe2->nomequipe }}</label>
                                                                        <input type="text" class="form-control" value="{{$pronostic->prono2}}" disabled>
                                                                    </div>
                                                                </form><!-- End Multi Columns Form -->
                                                            </div><!-- End Vertically centered Modal-->
                                                        </div>
                                                    </div>
                                                </div> 
                                            @else
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
                                                                        <label for="inputEmail5" class="form-label">{{ $match->Equipe1->nomequipe }}</label>
                                                                        <input type="text" class="form-control" name="prono1">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="inputPassword5" class="form-label">{{ $match->Equipe2->nomequipe }}</label>
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
                                            @endif
                                        @endif
                                    @else
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#classement{{ $match->idmatch }}"><h4>{{$match->resultat->score1}} : {{$match->resultat->score2}}</h4></a>
                                        <div class="modal fade" id="classement{{ $match->idmatch }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Classement</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="breadcrumb-item">Vous avez gagné <span class="card-title">{{$inscription->pointParMatch($match->idmatch)[0]}}+{{$inscription->pointParMatch($match->idmatch)[1]}} points</span></p>
                                                        <form class="row g-3">
                                                            <?php $pronostic=$inscription->pronosticParMatch($match->idmatch); ?>
                                                            <div class="col-md-6">
                                                                <label for="inputEmail5" class="form-label">{{ $match->Equipe1->nomequipe }}</label>
                                                                <input type="equipe1" class="form-control" id="inputEmail5" value="{{ $pronostic->prono1 }}" disabled>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="inputPassword5" class="form-label">{{ $match->Equipe2->nomequipe }}</label>
                                                                <input type="equipe2" class="form-control" id="inputPassword5" value="{{ $pronostic->prono2 }}" disabled>
                                                            </div>
                                                        </form><!-- End Multi Columns Form -->
                                                    </div><!-- End Vertically centered Modal-->
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="so-text">{{$match->datematch}}</div>
                                </td>
                                <td class="right-team">
                                    <img src="data:image/JPEG;base64,{{ $match->Equipe2->imageequipe }}" alt="">
                                    <h4>{{$match->Equipe2->nomequipe}}</h4>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Schedule Section End -->

@section('content')

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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ url('assets/img/orange.png') }}" rel="icon">
  <link href="{{ url('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

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

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<body>
@extends('Admin.AccueilAdmin')

@section('contenu')  
    <section class="section profile">
        <div class="row"> 
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-bordered"> 
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Détails</button>
                            </li> 
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifier</button>
                            </li> 
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Matchs</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#participant">Participants</button>
                              </li>              
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Classements</button>
                            </li>  
                        </ul>
                        <div class="tab-content pt-2">  
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">A propos</h5>
                                <p class="small fst-italic">{{$fichetournoi->description}}</p>  
                                <h5 class="card-title">Details du tournoi</h5>  
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Titre</div>
                                    <div class="col-lg-9 col-md-8">{{$fichetournoi->nomtournoi}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Debut</div>
                                    <div class="col-lg-9 col-md-8">{{$fichetournoi->debuttournoi}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Fin</div>
                                    <div class="col-lg-9 col-md-8">{{$fichetournoi->fintournoi}}</div>
                                </div>            
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Participation</div>
                                    <div class="col-lg-9 col-md-8">{{$fichetournoi->frais}}Ar</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Question subisidaire</div>
                                    <div class="col-lg-9 col-md-8">{{$fichetournoi->question}}</div>
                                </div>
                                     <!-- Reports -->
            <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Evolution de la cagnote</h5>
  
                    <!-- Line Chart -->
                    <div id="reportsChart"></div>
  
                    <script>
                      document.addEventListener("DOMContentLoaded", () => {
                        var dateTournoi=<?php echo $dateTournoi ?>;
                        var datee=[];
                        var frais=[];
                        for (i = 0; i < dateTournoi.length; i++) {
                            datee.push(dateTournoi[i].date);
                            frais.push(parseFloat(dateTournoi[i].frais));
                        }
                        new ApexCharts(document.querySelector("#reportsChart"), {
                          series: [{
                            name: 'Frais',
                            data: frais
                          }],
                          chart: {
                            height: 350,
                            type: 'area',
                            toolbar: {
                              show: false
                            },
                          },
                          markers: {
                            size: 4
                          },
                          colors: ['#ff771d'],
                          fill: {
                            type: "gradient",
                            gradient: {
                              shadeIntensity: 1,
                              opacityFrom: 0.3,
                              opacityTo: 0.4,
                              stops: [0, 90, 100]
                            }
                          },
                          dataLabels: {
                            enabled: false
                          },
                          stroke: {
                            curve: 'smooth',
                            width: 2
                          },
                          xaxis: {
                            type: 'datetime',
                            categories: datee
                          },
                          tooltip: {
                            x: {
                              format: 'text'
                            },
                          }
                        }).render();
                      });
                    </script>
                    <!-- End Line Chart -->
  
                  </div>
  
                </div>
              </div><!-- End Reports --> 
                            </div>
  
                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <form action="/FicheTournoi/updateTournoi" class="row g-3" method="POST">
                                    @csrf
                                    <input type="hidden" name="idtournoi" value="{{$fichetournoi->idtournoi}}">
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Type</label>
                                        <select name="idtypetournoi" class="form-control" >
                                            @foreach ($typetournoi as $type)
                                            <option value="{{$type->idtypetournoi}}">{{$type->nomtypetournoi}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputEmail4" class="form-label">Titre</label>
                                        <input type="text" class="form-control" name="nomtournoi" id="titre" value="{{$fichetournoi->nomtournoi}}" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputPassword4" class="form-label">Debut</label>
                                        <input type="date" class="form-control" name="debuttournoi" id="debut" value="{{$fichetournoi->debuttournoi}}" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Fin</label>
                                        <input type="date" class="form-control" name="fintournoi" id="fin" value="{{$fichetournoi->fintournoi}}" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Frais de participation</label>
                                        <input type="text" class="form-control" name="frais" id="frais" value="{{$fichetournoi->frais}}" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Question sibisidaire</label>
                                        <input type="text" name="question" class="form-control" id="question" style="height: 100px" value="{{$fichetournoi->question}}">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Description</label>
                                        <input type="text" name="description" class="form-control" id="description" style="height: 100px" value="{{$fichetournoi->descri}}">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Répartition cagnote</label>
                                        <div class="row">
                                          <div class="col-md-2">
                                            <input type="text" class="form-control"  placeholder="1er" name="rang1" value="{{$fichetournoi->rang1}}">
                                          </div>
                                          <div class="col-md-2">
                                            <input type="text" class="form-control"  placeholder="2eme" name="rang2" value="{{$fichetournoi->rang2}}">
                                          </div>
                                          <div class="col-md-2">
                                            <input type="text" class="form-control"  placeholder="3eme" name="rang3" value="{{$fichetournoi->rang3}}">
                                          </div>
                                          <div class="col-md-2">
                                            <input type="text" class="form-control"  placeholder="4eme" name="rang4" value="{{$fichetournoi->rang4}}">
                                          </div>
                                          <div class="col-md-2">
                                            <input type="text" class="form-control"  placeholder="5eme" name="rang5" value="{{$fichetournoi->rang5}}">
                                          </div>
                                        </div>            
                                      </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                    </div>
                                </form><!-- Vertical Form -->
                            </div>
                            <div class="tab-pane fade pt-3" id="profile-settings">  
                                <table class="table" style="margin-top: 20px;">
                                    <thead>
                                        <tr>
                                            <th scope="col">Type</th>
                                            <th scope="col">Equipes</th>
                                            <th scope="col">Dates</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($match as $matchs)
                                        <tr>
                                            <td>{{$matchs->typeMatch->nomtypematch}}</td>
                                            <td>{{$matchs->Equipe1->nomequipe}} VS {{$matchs->Equipe2->nomequipe}}</td>
                                            <td>{{$matchs->datematch}} </td>
                                            <td>              
                                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#basicModal{{$matchs->idmatch}}">
                                                    <i class="ri-edit-box-fill"></i>
                                                </button>
                                                <div class="modal fade" id="basicModal{{$matchs->idmatch}}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Modifier match</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="row g-3" method="post" action="/{{$fichetournoi->idtournoi}}/updateMatch">
                                                                    @csrf
                                                                    <input type="hidden" name="idmatch" value="{{$matchs->idmatch}}">
                                                                    <div class="col-md-12">
                                                                        <label for="inputName5" class="form-label">Type</label>
                                                                        <select name="idtypematch" id="idtypematch" class="form-control">
                                                                            @foreach ($typematch as $type)
                                                                            <option value="{{$type->idtypematch}}">{{$type->nomtypematch}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label for="inputName5" class="form-label">Date</label>
                                                                        <input type="datetime-local" class="form-control"  name="datematch" value="{{$matchs->datematch}}">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="inputEmail5" class="form-label">Equipe1</label>
                                                                        <select name="idequipe1" class="form-control">
                                                                            @foreach($equipe as $equipe1)
                                                                            <option value="{{$equipe1->Equipe->idequipe}}">{{$equipe1->Equipe->nomequipe}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="inputPassword5" class="form-label">Equipe2</label>
                                                                        <select name="idequipe2"  class="form-control">
                                                                            @foreach($equipe as $equipe2)
                                                                            <option value="{{$equipe2->Equipe->idequipe}}">{{$equipe2->Equipe->nomequipe}}</option>
                                                                            @endforeach
                                                                        </select>                                    
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label for="inputName5" class="form-label">Stade</label>
                                                                        <input type="text" class="form-control" id="inputName5" name="stade" value="{{$matchs->stade}}">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label for="inputName5" class="form-label">Resultat</label>
                                                                        <input type="text" class="form-control" id="inputName5" name="ptresultat" value="{{$matchs->ptresultat}}">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label for="inputName5" class="form-label">Score</label>
                                                                        <input type="text" class="form-control" id="inputName5" name="ptscore" value="{{$matchs->ptscore}}">
                                                                    </div>
                                                                    <div class="text-center">
                                                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                                                    </div>
                                                                </form><!-- End Multi Columns Form -->                         
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- End Basic Modal--> 
                                            </td>
                                            <td>                
                                                <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#verticalycentered{{$matchs->idmatch}}">
                                                    <i class="ri-delete-bin-5-fill"></i>
                                                </a>
                                                <div class="modal fade" id="verticalycentered{{$matchs->idmatch}}" tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form methodd="get" action="#">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="idequipe" value="">
                                                                    Etes-vous sûre de vouloir supprimer cette ligne?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                                    <button type="submit" class="btn btn-primary">Supprimer</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div><!-- End Vertically centered Modal-->
                                            </td> 
                                            <td>
                                                @if(now()>$matchs->finmatch && $matchs->statut==0)
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#resultat{{$matchs->idmatch}}">
                                                        Resultat
                                                    </button>
                                                    <div class="modal fade" id="resultat{{$matchs->idmatch}}" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Saisir résultat</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="row g-3" method="post" action="/{{$fichetournoi->idtournoi}}/addResultatMatch">
                                                                        @csrf
                                                                        <input type="hidden" name="idmatch" value="{{$matchs->idmatch}}">
                                                                        <div class="col-md-6">
                                                                            <label for="inputEmail5" class="form-label">{{$matchs->Equipe1->nomequipe}}</label>
                                                                            <input type="equipe1" class="form-control" name="score1">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="inputPassword5" class="form-label">{{$matchs->Equipe2->nomequipe}}</label>
                                                                            <input type="equipe2" class="form-control" name="score2">
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
                                                @if(now()>$matchs->finmatch && $matchs->statut==1)
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Classement{{$matchs->idmatch}}">
                                                    Classement
                                                </button>
                                                <div class="modal fade" id="Classement{{$matchs->idmatch}}" tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Classement</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="row g-3">
                                                                    <div class="col-md-6">
                                                                      <label for="inputEmail5" class="form-label">{{$matchs->Equipe1->nomequipe}}</label>
                                                                      <input type="equipe1" class="form-control" id="inputEmail5" value="5" disabled>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                      <label for="inputPassword5" class="form-label">{{$matchs->Equipe2->nomequipe}}</label>
                                                                      <input type="equipe2" class="form-control" id="inputPassword5" value="2" disabled>
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
                                                                        <?php for ($i=0; $i <count($classements[$matchs->idmatch]) ; $i++) { ?>
                                                                        <tr>
                                                                            <th scope="row">{{$i+1}}</th>
                                                                            <td>{{ $classements[$matchs->idmatch][$i]->trigramme }}</td>
                                                                            <td>{{ $classements[$matchs->idmatch][$i]->prono1 }} - {{ $classements[$matchs->idmatch][$i]->prono2 }}</td>
                                                                            <td>{{ $classements[$matchs->idmatch][$i]->total }}</td>
                                                                        </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                  </table>
                                                            </div><!-- End Vertically centered Modal-->
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                <p></p>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verticalycentered">
                                    Ajouter
                                </button>
                                <div class="modal fade" id="verticalycentered" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ajouter match</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="row g-3" method="post" action="/{{$fichetournoi->idtournoi}}/addMatch">
                                                    @csrf
                                                    <div class="col-md-12">
                                                        <label for="inputName5" class="form-label">Type</label>
                                                        <select name="idtypematch" id="idtypematch" class="form-control">
                                                            @foreach ($typematch as $type)
                                                            <option value="{{$type->idtypematch}}">{{$type->nomtypematch}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="inputName5" class="form-label">Stade</label>
                                                        <input type="text" class="form-control"  name="stade">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="inputName5" class="form-label">Date</label>
                                                        <input type="datetime-local" class="form-control"  name="datematch">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEmail5" class="form-label">Equipe1</label>
                                                        <select name="idequipe1" class="form-control">
                                                            @foreach($equipe as $equipe1)
                                                            <option value="{{$equipe1->Equipe->idequipe}}">{{$equipe1->Equipe->nomequipe}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputPassword5" class="form-label">Equipe2</label>
                                                        <select name="idequipe2"  class="form-control">
                                                            @foreach($equipe as $equipe2)
                                                            <option value="{{$equipe2->Equipe->idequipe}}">{{$equipe2->Equipe->nomequipe}}</option>
                                                            @endforeach
                                                        </select>                                    
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="inputName5" class="form-label">Resultat</label>
                                                        <input type="text" class="form-control" id="inputName5" name="ptresultat">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="inputName5" class="form-label">Score</label>
                                                        <input type="text" class="form-control" id="inputName5" name="ptscore">
                                                    </div>
                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-primary">Ajouter</button>
                                                    </div>
                                                </form><!-- End Multi Columns Form -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Importer un fichier csv</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <form enctype="multipart/form-data" action="/{{$fichetournoi->idtournoi}}/addMatchCsv" method="post">
                                                        @csrf
                                                        <div class="col-md-12">
                                                            <input class="form-control" type="file" id="file" accept=".csv" name="csv">
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Ajouter</button>
                                                        </div> 
                                                    </form>
                                                </div>
                                            </div><!-- End Vertically centered Modal-->
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Bordered Tabs -->
                            <div class="tab-pane fade pt-3" id="participant">
                                <!-- Sales Card -->
                                <section class="section dashboard">
                                <div class="row">
                                    <div class="col-xxl-4 col-md-6">
                                        <div class="card info-card sales-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Participants</h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-people"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <h6>{{count($participant)}}</h6>
                                                        <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End Sales Card -->
                        
                                    <!-- Revenue Card -->
                                    <div class="col-xxl-4 col-md-6">
                                        <div class="card info-card revenue-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Cagnote</h5>
                                                <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-currency-dollar"></i>
                                                </div>
                                                <div class="ps-3">
                                                    <?php $cagnote=count($participant)*$fichetournoi->frais; ?>
                                                    <h6>{{$cagnote}}</h6>
                                                    <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End Revenue Card -->
                                </div>
                                </section>
                                <table class="table">
                                    <thead>
                                      <tr>
                                        <th scope="col">Trigramme</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Paiement</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($participant as $part)
                                      <tr>
                                        <th scope="row">{{$part->trigramme}}</th>
                                        <td>{{$part->nom}}</td>
                                        <td>OK</td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                            </div>              
                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <form class="row g-3" method="get" action="#">
                                    <div class="col-md-2">    
                                    <select name="idtypedepense" class="form-select">
                                        <option value="">Globale</option>
                                        <option value="">Eliminatoire</option>
                                        <option value="">Qualification</option>
                                    </select>
                                    </div>
                                    <div class="col-md-2">
                                      <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                  </form><!-- End No Labels Form -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Rang</th>
                                            <th scope="col">Trigramme</th>
                                            <th scope="col">Points</th>
                                            <th scope="col">Lot</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>ANY</td>
                                            <td>950</td>
                                            <td>100000Ar</td>
                                        </tr>
                                    </tbody>
                                </table>          
                            </div>
                        </div>
                    </div>
                </div> 
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

</body>

</html>
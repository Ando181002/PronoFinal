<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ASOM</title>
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
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Activités</button>
                            </li> 
                        </ul>
                        <div class="tab-content pt-2">  
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">A propos</h5>
                                <p class="small fst-italic">Description kely</p>  
                                <h5 class="card-title">Details de l'évènement</h5>  
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Titre</div>
                                    <div class="col-lg-9 col-md-8">{{$evenement->nomevenement}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Debut</div>
                                    <div class="col-lg-9 col-md-8">{{$evenement->dateevenement}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Fin de l'inscription</div>
                                    <div class="col-lg-9 col-md-8">{{$evenement->fininscription}}</div>
                                </div>            
                            </div>
                                     <!-- Reports -->
                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <form action="/evenement/updateEvenement/{{$evenement->idevenement}}" class="row g-3" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Lieu</label>
                                        <select name="idlieu" class="form-control" >
                                            @foreach ($lieux as $lieu)
                                            <option value="{{$lieu->idlieu}}">{{$lieu->nomlieu}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputEmail4" class="form-label">Titre</label>
                                        <input type="text" class="form-control" name="nomevenement" id="titre" value="{{$evenement->nomevenement}}" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputEmail4" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="subject" name="image" placeholder="image" >
                                      </div>
                                    <div class="col-12">
                                        <label for="inputPassword4" class="form-label">Date</label>
                                        <input type="date" class="form-control" name="dateevenement" id="debut" value="{{$evenement->dateevenement}}" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Fin inscription</label>
                                        <input type="datetime-local" class="form-control" name="fininscription" id="fin" value="{{$evenement->fininscription}}" required>
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
                                            <th scope="col">Activite</th>
                                            <th scope="col">Duree</th>
                                            <th scope="col">Nombre de joueur</th>
                                            <th scope="col">Genre</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activites as $activite)
                                        <tr>
                                            <td>{{$activite->nomactivite}}</td>
                                            <td>{{$activite->pivot->dureeactivite}}</td>
                                            <td>{{$activite->pivot->nombrejoueur}} </td>
                                            <td>{{$activite->pivot->idgenre}}</td>
                                            <td>
                                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#basicModal{{$activite->pivot->idevenement_activite}}">
                                                    <i class="ri-edit-box-fill"></i>
                                                </button>
                                                <div class="modal fade" id="basicModal{{$activite->pivot->idevenement_activite}}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Modifier activité</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="row g-3" method="post" action="/{{$evenement->idevenement}}/{{$activite->pivot->idevenement_activite}}/updateActiviteEvenement">
                                                                    @csrf
                                                                    <div class="col-md-12">
                                                                        <label for="inputEmail5" class="form-label">Activite</label>
                                                                        <select name="idactivite" class="form-control">
                                                                            @foreach($listeActivite as $act)
                                                                            <option value="{{$act->idactivite}}">{{$act->nomactivite}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label for="inputName5" class="form-label">Duree</label>
                                                                        <input type="text" class="form-control" id="inputName5" name="dureeactivite" value="{{$activite->pivot->dureeactivite}}">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label for="inputName5" class="form-label">Nombre de joueur</label>
                                                                        <input type="text" class="form-control" id="inputName5" name="nombrejoueur" value="{{$activite->pivot->nombrejoueur}}">
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="inputNanme4" class="form-label">Genre</label>
                                                                        @foreach ($genres as $genre)
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="idgenre" id="gridRadios{{$genre->idgenre}}" value="{{$genre->idgenre}}">
                                                                            <label class="form-check-label" for="gridRadios{{$genre->idgenre}}">
                                                                                {{$genre->nomgenre}}
                                                                            </label>
                                                                          </div>
                                                                        @endforeach
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
                                                <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#verticalycentered1{{$activite->pivot->idevenement_activite}}">
                                                    <i class="ri-delete-bin-5-fill"></i>
                                                </a>
                                                <div class="modal fade" id="verticalycentered1{{$activite->pivot->idevenement_activite}}" tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form methodd="get" action="/{{$evenement->idevenement}}/{{$activite->pivot->idevenement_activite}}/deleteActiviteEvenement">
                                                                @csrf">
                                                                <div class="modal-body">
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
                                                <h5 class="modal-title">Ajouter activité</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="row g-3" method="post" action="/{{$evenement->idevenement}}/addActiviteEvenement">
                                                    @csrf
                                                    <div class="col-md-12">
                                                        <label for="inputEmail5" class="form-label">Activite</label>
                                                        <select name="idactivite" class="form-control">
                                                            @foreach($listeActivite as $act)
                                                            <option value="{{$act->idactivite}}">{{$act->nomactivite}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="inputName5" class="form-label">Duree</label>
                                                        <input type="text" class="form-control" id="inputName5" name="dureeactivite">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="inputName5" class="form-label">Nombre de joueur</label>
                                                        <input type="text" class="form-control" id="inputName5" name="nombrejoueur">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="inputNanme4" class="form-label">Genre</label>
                                                        @foreach ($genres as $genre)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="idgenre" id="gridRadios{{$genre->idgenre}}" value="{{$genre->idgenre}}">
                                                            <label class="form-check-label" for="gridRadios{{$genre->idgenre}}">
                                                                {{$genre->nomgenre}}
                                                            </label>
                                                          </div>
                                                        @endforeach
                                                      </div>
                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-primary">Ajouter</button>
                                                    </div>
                                                </form><!-- End Multi Columns Form -->
                                            </div><!-- End Vertically centered Modal-->
                                        </div>
                                    </div>
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
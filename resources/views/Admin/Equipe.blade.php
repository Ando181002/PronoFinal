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
    @extends('Admin.AccueilAdmin')

    @section('contenu')
          <div class="card">
            <div class="card-body">
              @if ($errors->any())
                  <div class="alert alert-danger bg-danger">
                    <ul>
                      @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                      @endforeach
                    </ul>
                  </div>
              @endif
              <h5 class="card-title">Equipe</h5>
              <!-- Default Table -->
              <div>
              <table class="table" style="margin-top: 20px;">
                <thead>
                  <tr>
                    <th scope="col">Equipe</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($equipes as $row)
                  <tr>
                    <td><img src="data:image/JPEG;base64,{{ $row->imageequipe }}" alt="Profile">
                      <span >{{$row->nomequipe}}</span></td>
                    <td>        
                        <!-- Basic Modal -->
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#basicModal{{$row->idequipe}}">
                        <i class="ri-edit-box-fill"></i>
                        </button>
                        <div class="modal fade" id="basicModal{{$row->idequipe}}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modifier equipe</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="row g-3" method="post" action="updateEquipe/{{$row->idequipe}}">
                                          @csrf
                                            <div class="col-12">
                                              <label for="inputNanme4" class="form-label">Equipe</label>
                                              <input type="text" class="form-control"  name="nomequipe" value="{{$row->nomequipe}}">
                                            </div>
                                            <div class="text-center">
                                              <button type="submit" class="btn btn-primary">Modifier</button>
                                            </div>
                                          </form><!-- Vertical Form -->                                 
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Basic Modal--> 
                        </td>
                    <td>                
                                  <!-- Vertically centered Modal -->
              <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#verticalycentered1">
              <i class="ri-delete-bin-5-fill"></i>
                  </a>
              <div class="modal fade" id="verticalycentered1" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <form methodd="get" action="deleteEquipe/{{$row->idequipe}}">
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
                  </tr>
                  @endforeach
                </tbody>
              </table>
              {{$equipes->links('custom-pagination')}}
                <!-- Vertically centered Modal -->
               <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verticalycentered">
                Ajouter
              </button>
              <div class="modal fade" id="verticalycentered" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Ajouter equipe</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
               <!-- General Form Elements -->
               <form class="row g-3" method="POST" action="addEquipe" enctype="multipart/form-data">
                @csrf
                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Equipe</label>
                  <input type="text" class="form-control" id="inputNanme4" name="nomequipe">
                </div>
                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Type</label>
                  @foreach ($typetournois as $type)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck{{$type->idtypetournoi}}" value="{{$type->idtypetournoi}}" name="idtypetournoi[]">
                    <label class="form-check-label" for="gridCheck{{$type->idtypetournoi}}">
                      {{$type->nomtypetournoi}}
                    </label>
                  </div>
                  @endforeach
                </div>
                  <div class="col-12">
                    <label for="inputNanme4" class="form-label">Image</label>
                    <input type="file" class="form-control" id="subject" name="image" placeholder="image" >
                  </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
              </form><!-- Vertical Form -->   
              <!-- End General Form Elements -->                   
              </div><!-- End Vertically centered Modal-->
            </div>
            </div>
          </div>
          @endsection

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

</body>

</html>
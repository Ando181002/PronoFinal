@extends('Admin.AccueilAdmin')

@section('contenu')
<section class="section profile">
    <div class="row">

        <div class="card">
          <div class="card-body ">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Liste</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Nouveau</button>
              </li>

            </ul>
            <div class="tab-content pt-2">
              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">Liste des tournois</h5>
                <table class="table" style="margin-top: 20px;">
                    <thead>
                      <tr>
                        <th scope="col">Type</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Debut</th>
                        <th scope="col">Fin</th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($tournois as $row)
                      <tr>
                        <td>{{$row->typeTournoi->nomtypetournoi}}</td>
                        <td><a href="FicheTournoi/{{$row->idtournoi}}">{{$row->nomtournoi}}</a></td>
                        <td>{{$row->debuttournoi}}</td>
                        <td>{{$row->fintournoi}}</td>
                        <td>           
                                      <!-- Vertically centered Modal -->
                  <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#verticalycentered1">
                  <i class="ri-delete-bin-5-fill"></i>
                      </a>
                  <div class="modal fade" id="verticalycentered1" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <form methodd="get" action="deleteTournoi/{{$row->idtournoi}}">
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

              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                @if ($errors->any())
                <div class="alert alert-danger bg-danger">
                  <ul>
                    @foreach($errors->all() as $error)
                      <li>{{$error}}</li>
                    @endforeach
                  </ul>
                </div>
            @endif
            {{$tournois->links('custom-pagination')}}
                <!-- Profile Edit Form -->
<h5 class="card-title">Ajouter tournoi</h5>

        <!-- Vertical Form -->
        <form class="row g-3" method="post" action="addTournoi" enctype="multipart/form-data">
          @csrf
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
            <input type="text" class="form-control" name="nomtournoi" id="titre" value="" required>
          </div>
          <div class="col-12">
            <label for="inputEmail4" class="form-label">Image</label>
            <input type="file" class="form-control" id="subject" name="image" placeholder="image" >
          </div>
          <div class="col-12">
            <label for="inputPassword4" class="form-label">Debut</label>
            <input type="date" class="form-control" name="debuttournoi" id="debut" value="" required>
          </div>
          <div class="col-12">
            <label for="inputAddress" class="form-label">Fin</label>
            <input type="date" class="form-control" name="fintournoi" id="fin" value="" required>
          </div>
          <div class="col-12">
            <label for="inputAddress" class="form-label">Frais de participation</label>
            <input type="text" class="form-control" name="frais" id="frais" value="" required>
          </div>
          <div class="col-12">
            <label for="inputAddress" class="form-label">Question subsidaire</label>
            <textarea name="question" class="form-control" id="question" style="height: 100px"></textarea>
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Description</label>
                <textarea class="form-control" name="description" style="height: 100px"></textarea>
          </div>
          <div class="col-12">
            <label for="inputAddress" class="form-label">Répartition cagnote</label>
            <div class="row">
              <div class="col-md-2">
                <input type="text" class="form-control"  placeholder="1er" name="rang1">
              </div>
              <div class="col-md-2">
                <input type="text" class="form-control"  placeholder="2eme" name="rang2">
              </div>
              <div class="col-md-2">
                <input type="text" class="form-control"  placeholder="3eme" name="rang3">
              </div>
              <div class="col-md-2">
                <input type="text" class="form-control"  placeholder="4eme" name="rang4">
              </div>
              <div class="col-md-2">
                <input type="text" class="form-control"  placeholder="5eme" name="rang5">
              </div>
            </div>            
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Ajouter</button>
          </div>
        </form><!-- Vertical Form -->

              </div>
          </div>
        </div>
    </div>
  </section>
@endsection









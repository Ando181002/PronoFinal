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
                <h5 class="card-title">Liste des evenements</h5>
                <table class="table" style="margin-top: 20px;">
                    <thead>
                      <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Date</th>
                        <th scope="col">Lieu</th>
                        <th scope="col">Fin inscription</th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($evenements as $row)
                      <tr>
                        <td><a href="ficheEvenement/{{$row->idevenement}}">{{$row->nomevenement}}</a></td>
                        <td>{{$row->dateevenement}}</a></td>
                        <td>{{$row->Lieu->nomlieu}}</td>
                        <td>{{$row->fininscription}}</td>
                        <td>           
                                      <!-- Vertically centered Modal -->
                  <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#verticalycentered1">
                  <i class="ri-delete-bin-5-fill"></i>
                      </a>
                  <div class="modal fade" id="verticalycentered1" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <form methodd="get" action="#">
                        <div class="modal-body">
                          <input type="hidden" name="idtypetournoi" value="">
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
                <!-- Profile Edit Form -->
      <h5 class="card-title">Ajouter evenement</h5>

        <!-- Vertical Form -->
        <form class="row g-3" method="post" action="addEvenement" >
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
            <input type="text" class="form-control" name="nomevenement"  required>
          </div>
          <div class="col-12">
            <label for="inputPassword4" class="form-label">Date</label>
            <input type="date" class="form-control" name="dateevenement" id="debut" value="" required>
          </div>
          <div class="col-12">
            <label for="inputAddress" class="form-label">Fin d'inscription</label>
            <input type="datetime-local" class="form-control" name="fininscription" required>
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









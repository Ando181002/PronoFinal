@extends('Admin.AccueilAdmin')
@section('contenu')
<div class="row">
  <p><a href="pdf">PDF</a></p>
<div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Nombre de participant par type de tournoi</h5>
        <div class="card-body">
            <p> </p>
        </div>
        <!-- Pie Chart -->
        <div id="pieChart1"></div>

        <script>
          document.addEventListener("DOMContentLoaded", () => {
            var donnees=<?php echo $nbInscri_typetournoi ?>;
            var typetournoi=[];
            var nombre=[];
            for (i = 0; i < donnees.length; i++) {
                typetournoi.push(donnees[i].nomtypetournoi);
                nombre.push(parseFloat(donnees[i].nbinscription));
            }
            new ApexCharts(document.querySelector("#pieChart1"), {
              series: nombre,
              chart: {
                height: 350,
                type: 'pie',
                toolbar: {
                  show: true
                }
              },
              labels: typetournoi
            }).render();
          });
        </script>
        <!-- End Pie Chart -->

      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Statistique département</h5>
        <div class="card-body">
        <form class="row g-3" method="get" action="AdminStatistique">
            @csrf
            <div class="col-md-4">
                <select name="idtypetournoi" class="form-control" >
                  @foreach($typetournoi as $type)
                    <option value="{{$type->idtypetournoi}}">{{$type->nomtypetournoi}}</option>
                  @endforeach
                </select>
              </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
          </form><!-- End No Labels Form -->
        </div>
        <!-- Pie Chart -->
        <div id="pieChart"></div>

        <script>
          document.addEventListener("DOMContentLoaded", () => {
            var data=<?php echo $nbInscri_departement ?>;
            var departement=[];
            var nombre=[];
            for (i = 0; i < data.length; i++) {
                departement.push(data[i].iddepartement);
                nombre.push(parseFloat(data[i].nbinscription));
            }
            new ApexCharts(document.querySelector("#pieChart"), {
              series: nombre,
              chart: {
                height: 250,
                type: 'pie',
                toolbar: {
                  show: true
                }
              },
              labels: departement
            }).render();
          });
        </script>
        <!-- End Pie Chart -->

      </div>
    </div>
  </div>
</div>
@endsection
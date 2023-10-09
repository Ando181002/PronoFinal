@extends('Admin.AccueilAdmin')
@section('contenu')
<div class="row">
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
            new ApexCharts(document.querySelector("#pieChart1"), {
              series: [44, 55, 13, 43],
              chart: {
                height: 350,
                type: 'pie',
                toolbar: {
                  show: true
                }
              },
              labels: ['BasketBall', 'FootBall', 'Rugby', 'Tennis']
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
        <form class="row g-3" method="get" action="#">
            @csrf
            <div class="col-md-3">
                <select name="type" class="form-control" >
                    <option value="1">BasketBall</option>
                    <option value="2">FootBall</option>
                </select>
              </div>
              <div class="col-md-3">
                <select name="type" class="form-control" >
                    <option value="1">Tournoi1</option>
                    <option value="2">Tournoi2</option>
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
            new ApexCharts(document.querySelector("#pieChart"), {
              series: [44, 55, 13, 43,40],
              chart: {
                height: 350,
                type: 'pie',
                toolbar: {
                  show: true
                }
              },
              labels: ['DRH', 'DTI', 'DF', 'SG','DMCC']
            }).render();
          });
        </script>
        <!-- End Pie Chart -->

      </div>
    </div>
  </div>
</div>
@endsection
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
  
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
<div style="height: 100px"></div>
<div class="event">
  <h1>{{$evenement->nomevenement}}</h1>
  <img src="{{ url('assets/img/product-1.jpg')}}" alt="Image de l'événement">
  
  <div class="event-details">
      <p><strong>Date :</strong> {{$evenement->dateevenement}}</p>
      <p><strong>Heure :</strong> 10h00 - 17h00</p>
      <p><strong>Description :</strong> Cet événement sportif passionnant comprend diverses activités amusantes pour tous les âges.</p>
      <p><strong>Lieu :</strong> {{$evenement->Lieu->nomlieu}}</p>
  </div>
  
  <div id="map" style="height: 350px;" >
      <!-- L'emplacement de la carte sera intégré ici avec JavaScript -->
  </div>
  
  <div class="activities">
      <h2>Activités Proposées :</h2>
      @foreach ($activites as $activite)
      <div class="activity">
          <h3>{{$activite->nomactivite}}</h3>
          <p><strong>Heure :</strong> 10h00 - 11h30</p>
          <p><strong>Description :</strong> Une course à pied sur la plage.</p>
          <a type="button" class="registration-button" href="detailActivite">Inscription</a>
      </div>
      @endforeach
      
      <!-- Ajoutez d'autres activités ici -->
  </div>
  </div>
<script>
    var map = L.map('map').setView([-18.8842, 47.5232], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var iconDepart = L.icon({
    iconUrl: '{{ asset("orange.png") }}',
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    });

    var iconArrivee = L.icon({
    iconUrl: '{{ asset("rouge.png") }}',
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    });

    var depart = L.latLng(-18.8842, 47.5232);
    var latitude=<?php echo json_encode($evenement->Lieu->latitude); ?>;
    var longitude=<?php echo json_encode($evenement->Lieu->longitude); ?>;
    var arrivee = L.latLng(latitude, longitude);

    // Ajouter le marqueur de départ personnalisé
    var departMarker = L.marker(depart, { icon: iconDepart }).addTo(map);

    // Ajouter le marqueur d'arrivée personnalisé
    var arriveeMarker = L.marker(arrivee, { icon: iconArrivee }).addTo(map);

    // Créer un contrôleur d'itinéraire, désactiver l'ajout automatique du marqueur de départ par défaut
    var control = L.Routing.control({
    waypoints: [
        depart,
        arrivee
    ],
    createMarker: function (i, wp, nWps) {
        if (i === 0) {
            // Marqueur personnalisé pour le départ
            return L.marker(wp.latLng, {
                icon: iconDepart
            });
        } else {
            // Marqueur personnalisé pour l'arrivée
            return L.marker(wp.latLng, {
                icon: iconArrivee
            });
        }
    }
    }).addTo(map);
    document.getElementById('event-map').innerHTML = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3161.5410363011594!2d[Longitude]!3d[Latitude]!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0:0x0!2z[Emplacement]"></iframe>';

    // Gestion des boutons d'inscription
    const registrationButtons = document.querySelectorAll('.registration-button');
    registrationButtons.forEach(button => {
        button.addEventListener('click', () => {
            alert('Inscription réussie à cette activité !'); // Simuler l'inscription
        });
    });

</script>  
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
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
 <!-- Hero Section Begin -->
 <section class="hero-section set-bg" data-setbg="assets/img/hero-1.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hs-item">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="hs-text">
                                    <h2>{{$tournoi->descri}}</h2>
                                    <?php
                                      date_default_timezone_set("Asia/Bangkok");
                                      $deb=date_create($tournoi->debuttournoi);
                                      $debut=date_format($deb,"D d M Y");
                                      $fin=date_create($tournoi->fintournoi);
                                      $finn=date_format($fin,"D d M Y");
                                    ?>
                                    <h4>{{$debut}}-{{$finn}}</h4>
                                    <H2><img src="data:image/JPEG;base64,{{ $matchs[0]->Equipe1->imageequipe }}" alt=""><img src="data:image/JPEG;base64,{{ $matchs[0]->Equipe2->imageequipe }}" alt=""></H2>
                                    <H4>Match d'ouverture</H4>
                                    <h2>{{ $matchs[0]->Equipe1->nomequipe }} vs {{ $matchs[0]->Equipe2->nomequipe }}</h2>
                                </div>
                            </div>>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End --> 
<p> </p>
<!-- Schedule Section Begin -->
<section class="schedule-section spad">
    <div class="container">
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
                                    <a href="#" disabled></a><h4>VS</h4>
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

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
@section('content')
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
                                        <h4>30 september 2019 / 9:00 GMT+0000</h4>
                                        <h2>Airrosten VS Lerenort in London</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End --> 

     <!-- Soccer Section Begin -->
     <section class="soccer-section">
        <div class="container">
            <div class="club-tab-list">
                <div class="row">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-tous" role="tab">Tous</a>
                            </li>
                            <?php for ($i=0; $i <count($typetournoi) ; $i++) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-{{$i}}" role="tab">{{$typetournoi[$i]->nomtypetournoi}}</a>
                                </li>
                            <?php } ?>
                        </ul><!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-tous" role="tabpanel">
                                <div class="row">
                                    @foreach($Tournois as $tournoi)
                                    <div class="col-lg-3 col-sm-6 p-0">
                                        <div class="soccer-item set-bg" data-setbg="data:image/JPEG;base64,{{ $tournoi->imagetournoi }}">
                                            <div class="si-tag">{{$tournoi->TypeTournoi->nomtypetournoi}}</div>
                                            <div class="si-text">
                                                <h5><a href="detailTournoi?id={{$tournoi->idtournoi}}" style="color: black; font:bold">{{$tournoi->nomtournoi}}</a></h5>
                                                <ul>
                                                    <li><i class="fa fa-calendar"></i> May 19, 2019</li>
                                                    <li><i class="fa fa-edit"></i> 3 Comment</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <?php for ($i=0; $i <count($typetournoi) ; $i++) { ?>
                            <div class="tab-pane" id="tabs-{{$i}}" role="tabpanel">
                                <div class="row">
                                    @foreach ($tournoisParType[$typetournoi[$i]->idtypetournoi] as $tournoiParType)
                                    <div class="col-lg-3 col-sm-6 p-0">
                                        <div class="soccer-item set-bg" data-setbg="data:image/JPEG;base64,{{ $tournoiParType->imagetournoi }}">
                                            <div class="si-tag" >{{$tournoiParType->TypeTournoi->nomtypetournoi}}</div>
                                            <div class="si-text">
                                                <h5><a href="detailTournoi?id={{$tournoiParType->idtournoi}}" style="color: black; font:bold">{{$tournoiParType->nomtournoi}}</a></h5>
                                                <ul>
                                                    <li><i class="fa fa-calendar"></i> May 19, 2019</li>
                                                    <li><i class="fa fa-edit"></i> 3 Comment</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Soccer Section End -->
  
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
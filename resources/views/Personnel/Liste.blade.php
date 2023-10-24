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
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Non participé</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">En cours</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">Gagné</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-5" role="tab">Perdu</a>
                            </li>
                        </ul><!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <div class="row">
                                    @foreach($nonParticipe as $nonPart)
                                    <div class="col-lg-3 col-sm-6 p-0">
                                        <div class="soccer-item set-bg" data-setbg="data:image/JPEG;base64,{{ $nonPart->imagetournoi }}">
                                            <div class="si-tag">{{$nonPart->nomtypetournoi}}</div>
                                            <div class="si-text">
                                                <h5><a href="detailTournoi?id={{$nonPart->idtournoi}}&status=participant" style="color: black; font:bold">{{$nonPart->nomtournoi}}</a></h5>
                                                <ul>
                                                    <?php $erreur=" "; ?>
                                                    <a href="participerPronostic/{{$nonPart->idtournoi}}/{{$erreur}}/" type="button" class="btn btn-primary" style="background-color: orange">
                                                    participer
                                                    </a><!-- End Messages Icon -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <div class="row">
                                    @foreach($encours as $encour)
                                    <div class="col-lg-3 col-sm-6 p-0">
                                        <div class="soccer-item set-bg" data-setbg="data:image/JPEG;base64,{{ $encour->imagetournoi }}">
                                            <div class="si-tag">{{$encour->nomtypetournoi}}</div>
                                            <div class="si-text">
                                                <h5><a href="Pronostiquer/{{$encour->idtournoi}}" style="color: black; font:bold">{{$encour->nomtournoi}}</a></h5>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div> 
                            </div>
                            <div class="tab-pane" id="tabs-4" role="tabpanel">
                                <div class="row">
                                    @foreach($gagnes as $gagne)
                                    <div class="col-lg-3 col-sm-6 p-0">
                                        <div class="soccer-item set-bg" data-setbg="assets/img/product-1.jpg">
                                            <div class="si-tag">{{$gagne->idtournoi}}</div>
                                            <div class="si-text">
                                                <h5><a href="#">{{$gagne->Tournoi->nomtournoi}}</a></h5>
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
                            <div class="tab-pane" id="tabs-5" role="tabpanel">
                                <div class="row">
                                    <?php for ($i=0; $i <10 ; $i++) { ?>
                                    <div class="col-lg-3 col-sm-6 p-0">
                                        <div class="soccer-item set-bg" data-setbg="assets/img/product-1.jpg">
                                            <div class="si-tag">Tennis</div>
                                            <div class="si-text">
                                                <h5><a href="#">Counting Your Chicken Before They Hatch</a></h5>
                                                <ul>
                                                    <li><i class="fa fa-calendar"></i> May 19, 2019</li>
                                                    <li><i class="fa fa-edit"></i> 3 Comment</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
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
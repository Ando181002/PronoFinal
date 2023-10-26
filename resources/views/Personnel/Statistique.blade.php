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


<div class="pagetitle">
    <h1>ApexCharts</h1>
</div><!-- End Page Title -->
<section class="section">
    <div class="row">
    <div class="col-lg-6">
        <div class="card">
        <div class="card-body">
            <h5 class="card-title">Bar Chart</h5>

            <!-- Bar Chart -->
            <div id="barChart"></div>

            <script>
                
            document.addEventListener("DOMContentLoaded", () => {
                var mise = <?php echo $mise; ?>;
                var gagne = <?php echo $gagne; ?>;
                var benefice=gagne-mise;
                new ApexCharts(document.querySelector("#barChart"), {
                series: [{
                    data: [mise, gagne, benefice]
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                    borderRadius: 4,
                    horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: ['Misé', 'Gagné', 'Bénéfice'],
                },
                colors: ['#ff5733', '#007bff', '#28a745'],
                }).render();
            });
            </script>
            <!-- End Bar Chart -->

        </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
        <div class="card-body">
            <h5 class="card-title">Pie Chart</h5>

            <!-- Pie Chart -->
            <div id="pieChart"></div>

            <script>
            document.addEventListener("DOMContentLoaded", () => {
                var gagne = <?php echo $compte->nombreGagne(); ?>;
                var perdu = <?php echo $compte->nombrePerdu(); ?>;
                new ApexCharts(document.querySelector("#pieChart"), {
                series: [perdu, gagne],
                chart: {
                    height: 350,
                    type: 'pie',
                    toolbar: {
                    show: true
                    }
                },
                labels: ['Perdu', 'Gagné'],
                colors: ['#ff5733', '#007bff', '#28a745'],
                }).render();
            });
            </script>
            <!-- End Pie Chart -->

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
 <script src="{{ url('assets/js/jquery-3.3.1.min.js') }}"></script>
 <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
 <script src="{{ url('assets/js/jquery.magnific-popup.min.js') }}"></script>
 <script src="{{ url('assets/js/jquery.slicknav.js') }}"></script>
 <script src="{{ url('assets/js/owl.carousel.min.js') }}"></script>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Classement des Résultats</title>
    <style>
        /* Styles CSS pour le classement */
        body {
            background-color: #fff; /* Noir */
            color: white;
            font-family: Arial, sans-serif;
            position: relative;
        }
        .logo {
            position: relative;
            top: 20px;
            left: 20px;
        }
        .logo img {
            max-width: 50px; /* Ajustez la largeur en fonction de la taille de votre logo */
        }
        h1 {
            color: #fc7609; /* Orange */
            text-align: center;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        th, td {
            border: 2px solid #000; /* Orange */
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #fc7609; /* Orange */
            color: black;
        }
        td {
            background-color: #FFF; /* Blanc */
            color: black;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="assets/img/orange.png" alt="ASOM">
    </div>
    <h1>Classement des Résultats</h1>
    <table>
        <thead>
            <tr>
                <th>Position</th>
                <th>Participant</th>
                <th>Score</th>
            </tr>
        </thead>
        @php
            $rang=1;
            $classements=$classements->sortByDesc(function($classement){
                return $classement->pointfinal();
            });
        @endphp
        <tbody>
            @foreach($classements as $classement)
            <tr>
                <td>{{$rang}}</td>
                <td>{{$classement->trigramme}}</td>
                @if($idphase==0)
                    <td>{{$classement->pointfinal()}}</td>
                @else
                    <td>{{$classement->pointParPhase($idphase)}}</td>
                @endif
            </tr>
            @php
                $rang++;
            @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>

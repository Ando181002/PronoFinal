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
            color: #FFA500; /* Orange */
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
            background-color: #FFA500; /* Orange */
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
                <th>Montant(Ar)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vainqueurs as $vainqueur)
            <tr>
                <td>{{$vainqueur->rang}}</td>
                <td>{{$vainqueur->trigramme}}</td>
                <td>{{$vainqueur->points}}</td>
                <td>{{$vainqueur->montant}}</td>
            </tr>
            @endforeach
            <!-- Ajoutez plus de lignes pour d'autres participants -->
        </tbody>
    </table>
</body>
</html>

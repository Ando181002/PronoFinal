<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Classement des Résultats</title>
    <style>
        /* Styles CSS pour le classement */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #ccc;
        }
    </style>
</head>
<body>
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

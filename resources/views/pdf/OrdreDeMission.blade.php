<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ordre de Mission</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
        }
        h1, h2 {
            text-align: center;
        }
        .section {
            margin-bottom: 20px;
        }
        .info-table, .mission-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td, .mission-table td, .mission-table th {
            padding: 8px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>
<h1>Ordre de Mission</h1>
<h2>{{ 333 }}</h2>

<div class="section">
    <table class="info-table">
        <tr>
            <td><strong>Nom :</strong> {{ 'Yassine' }}</td>
            <td><strong>Matricule :</strong> {{ 'J4212' }}</td>
        </tr>
        <tr>
            <td><strong>Fonction :</strong> Ingénieur</td>
            <td><strong>Service :</strong> Service</td>
        </tr>
    </table>
</div>

<div class="section">
    <table class="mission-table">
        <tr>
            <th>Objet de la mission</th>
            <td>Objet</td>
        </tr>
        <tr>
            <th>Lieu</th>
            <td>Lieu</td>
        </tr>
        <tr>
            <th>Date de départ</th>
            <td>date_départ</td>
        </tr>
        <tr>
            <th>Date de retour</th>
            <td>Date de retour</</td>
        </tr>
        <tr>
            <th>Moyen de transport</th>
            <td>Moyen de transport</td>
        </tr>
    </table>
</div>

<div class="signature">
    <p>Fait à Massa, le date_de_creation</p>
    <p><strong>Le Directeur</strong></p>
    <br><br>
    <p></p>
</div>
</body>
</html>

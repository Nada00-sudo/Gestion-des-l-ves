<x-appProf>
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des étudiants</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            padding: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h2></h2>
<h2></h2>
<table>
    <thead>
        <tr>
            <th>Nom de l’étudiant</th>
            <th>Mathématiques</th>
            <th>Informatique</th>
            <th>Physique</th>
            <th>Électronique</th>
            <th>Anglais</th>
            <th>Moyenne</th>
            <th>Décision</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($listes as $student)
    @php
        $res = $student->resultats->first();
    @endphp

    <tr>
        <td>{{ $student->name }}</td>

        <td>{{ $res->note1 ?? '-' }}</td>
        <td>{{ $res->note2 ?? '-' }}</td>
        <td>{{ $res->note3 ?? '-' }}</td>
        <td>{{ $res->note4 ?? '-' }}</td>
        <td>{{ $res->note5 ?? '-' }}</td>

        <td><strong>{{ $res->moyenne ?? '-' }}</strong></td>
        <td>{{ $res->decision ?? '-' }}</td>
    </tr>
@empty
    <tr>
        <td colspan="8">Aucun étudiant trouvé</td>
    </tr>
@endforelse

    </tbody>
</table>

</body>
</html>

</x-appProf>
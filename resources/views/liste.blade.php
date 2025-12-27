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
            <th>Action</th>
            <th>Actions</th>

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
        <td>
    <form method="POST" action="{{ route('etudiant.delete', $student->id) }}"
          onsubmit="return confirm('Supprimer cet étudiant ?');">
        @csrf
        @method('DELETE')
        <button type="submit"
                style="background:#e74c3c; color:white; border:none; padding:5px 10px;">
            Supprimer
        </button>
    </form>
</td>
<td class="flex gap-2 justify-center">
    <a href="{{ route('resultats.edit', $student->id) }}"
       class="background:blue  text-blue  px-3 py-1 rounded">
        Modifier
    </a>

</td>


    </tr>
@empty
    <tr>
        <td colspan="8">Aucun étudiant trouvé</td>
    </tr>
@endforelse

    </tbody>
</table>
<h2></h2>
<h2></h2>
<h2>➕ Ajouter un étudiant</h2>

<div class="flex justify-center mb-6">
    <form method="POST" action="{{ route('etudiant.add') }}"
          class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-white p-6 rounded-xl shadow-md">
        @csrf

        <input type="text" name="name" placeholder="Nom complet" required class="border px-3 py-2 rounded">
        <input type="email" name="email" placeholder="Email" required class="border px-3 py-2 rounded">

        <input type="number" name="note1" placeholder="Mathématiques" step="0.01" required class="border px-3 py-2 rounded">
        <input type="number" name="note2" placeholder="Informatique" step="0.01" required class="border px-3 py-2 rounded">
        <input type="number" name="note3" placeholder="Physique" step="0.01" required class="border px-3 py-2 rounded">
        <input type="number" name="note4" placeholder="Électronique" step="0.01" required class="border px-3 py-2 rounded">
        <input type="number" name="note5" placeholder="Anglais" step="0.01" required class="border px-3 py-2 rounded">

        <button type="submit"
            style="padding:8px 15px; background:#2ecc71; color:white; border:none;">
    Ajouter étudiant
</button>


    </form>
</div>


</body>
</html>

</x-appProf>
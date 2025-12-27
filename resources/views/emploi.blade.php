<x-appStudent>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Titre -->
            <div class="mb-30">
                <h1 class="text-3xl font-extrabold text-gray-800">
                    Emploi du temps hebdomadaire
                </h1>
                
            </div>

            <!-- Tableau emploi -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Jour</th>
                            <th class="px-4 py-3 text-left">Début</th>
                            <th class="px-4 py-3 text-left">Fin</th>
                            <th class="px-4 py-3 text-left">Matière</th>
                            <th class="px-4 py-3 text-left">Salle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($emplois as $emploi)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $emploi->jour }}</td>
                                <td class="px-4 py-3">{{ $emploi->heure_debut }}</td>
                                <td class="px-4 py-3">{{ $emploi->heure_fin }}</td>
                                <td class="px-4 py-3 font-medium">{{ $emploi->matiere }}</td>
                                <td class="px-4 py-3">{{ $emploi->salle ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                    Aucun emploi du temps disponible.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            

        </div>
    </div>

</x-appStudent>

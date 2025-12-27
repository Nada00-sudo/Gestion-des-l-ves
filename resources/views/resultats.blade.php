<x-appStudent>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-10">

                <!-- Titre -->
                <div class="mb-8 flex justify-center">
                    <h2 class="text-3xl font-extrabold text-green-800 font-semibold">
                        Relevé de notes – {{ $resultat->semestre }}
                    </h2>
                    
                </div>

                <!-- Tableau -->
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-gray-700 font-semibold">
                                    Matière
                                </th>
                                <th class="px-6 py-4 text-center text-gray-700 font-semibold">
                                    Note / 20
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $resultat->matiere1 }}</td>
                                <td class="px-6 py-4 text-center font-medium">{{ $resultat->note1 }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $resultat->matiere2 }}</td>
                                <td class="px-6 py-4 text-center font-medium">{{ $resultat->note2 }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $resultat->matiere3 }}</td>
                                <td class="px-6 py-4 text-center font-medium">{{ $resultat->note3 }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $resultat->matiere4 }}</td>
                                <td class="px-6 py-4 text-center font-medium">{{ $resultat->note4 }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $resultat->matiere5 }}</td>
                                <td class="px-6 py-4 text-center font-medium">{{ $resultat->note5 }}</td>
                            </tr>
                        </tbody>

                        <!-- Résumé -->
                        <tfoot class="bg-gray-50 border-t-2">
                            <tr>
                                <th class="px-6 py-4 text-left font-bold text-gray-800">
                                    Moyenne générale
                                </th>
                                <th class="px-6 py-4 text-center text-lg font-bold text-blue-600">
                                    {{ $resultat->moyenne }}
                                </th>
                            </tr>
                            <tr>
                                <th class="px-6 py-4 text-left font-bold text-gray-800">
                                    Décision
                                </th>
                                <th class="px-6 py-4 text-center text-lg font-bold
                                    {{ $resultat->decision === 'Admis' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $resultat->decision }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-appStudent>

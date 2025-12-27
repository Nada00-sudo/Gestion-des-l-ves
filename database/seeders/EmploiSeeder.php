<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Emploi;

class EmploiSeeder extends Seeder
{
    public function run(): void
    {
        $student = User::where('role', 'student')->first();
        $prof = User::where('role', 'prof')->first();

        /* =======================
           EMPLOI ÉTUDIANT (Semaine)
        ======================== */

        $emploisStudent = [
            ['Lundi', '08:00', '10:00', 'Mathématiques', 'B12'],
            ['Mardi', '10:00', '12:00', 'Physique', 'A4'],
            ['Mercredi', '08:00', '10:00', 'Informatique', 'Lab 1'],
            ['Jeudi', '14:00', '16:00', 'Électronique', 'C2'],
            ['Vendredi', '09:00', '11:00', 'Anglais', 'D1'],
        ];

        foreach ($emploisStudent as $e) {
            Emploi::create([
                'user_id' => $student->id,
                'jour' => $e[0],
                'heure_debut' => $e[1],
                'heure_fin' => $e[2],
                'matiere' => $e[3],
                'salle' => $e[4],
            ]);
        }

        /* =======================
           EMPLOI PROF (Semaine)
        ======================== */

        $emploisProf = [
            ['Lundi', '10:00', '12:00', 'Algorithmique', 'A3'],
            ['Mardi', '14:00', '16:00', 'Programmation Web', 'Lab 2'],
            ['Mercredi', '09:00', '11:00', 'Base de données', 'B5'],
            ['Jeudi', '08:00', '10:00', 'Génie logiciel', 'C1'],
            ['Vendredi', '11:00', '13:00', 'Encadrement projet', 'Salle Prof'],
        ];

        foreach ($emploisProf as $e) {
            Emploi::create([
                'user_id' => $prof->id,
                'jour' => $e[0],
                'heure_debut' => $e[1],
                'heure_fin' => $e[2],
                'matiere' => $e[3],
                'salle' => $e[4],
            ]);
        }
    }
}

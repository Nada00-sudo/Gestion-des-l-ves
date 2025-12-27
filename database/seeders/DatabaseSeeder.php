<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Resultat;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== PROF =====
        $prof = User::create([
            'name' => 'Prof.Dehmani',
            'email' => 'prof@test.com',
            'password' => Hash::make('password'),
            'role' => 'prof',
        ]);

        // ===== ÉTUDIANTS =====
        $students = [
            ['name' => 'El Oukili Nada',   'email' => 'nada@test.com'],
            ['name' => 'Samah Najjar',     'email' => 'samah@test.com'],
            ['name' => 'Zakaria Ahmadi',   'email' => 'zakaria@test.com'],
            ['name' => 'Omar Bennani',     'email' => 'omar@test.com'],
            ['name' => 'Yassine El Idrissi','email' => 'yassine@test.com'],
            ['name' => 'Sara Alaoui',      'email' => 'sara@test.com'],
            ['name' => 'Amine Boulahcen',  'email' => 'amine@test.com'],
            ['name' => 'Hind Chraibi',     'email' => 'hind@test.com'],
            ['name' => 'Anas Lahlou',      'email' => 'anas@test.com'],
            ['name' => 'Meryem Ziani',     'email' => 'meryem@test.com'],
        ];

        foreach ($students as $index => $data) {

            $student = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'student',
                'prof_id' => $prof->id,
            ]);

            // ===== RÉSULTATS =====
            Resultat::create([
                'user_id' => $student->id,
                'semestre' => 'S1',

                'matiere1' => 'Mathématiques', 'note1' => rand(10, 18),
                'matiere2' => 'Informatique',  'note2' => rand(10, 18),
                'matiere3' => 'Physique',      'note3' => rand(10, 18),
                'matiere4' => 'Électronique',  'note4' => rand(10, 18),
                'matiere5' => 'Anglais',       'note5' => rand(10, 18),

                'moyenne' => rand(11, 16),
                'decision' => 'Admis',
            ]);
        }

        $this->call([
            EmploiSeeder::class,
        ]);
    }
}

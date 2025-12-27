<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Resultat;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboardStudent', function () {
    return view('dashboardStudent');
})->middleware(['auth', 'verified'])->name('dashboardStudent');

Route::middleware('auth')->get('/emploi', function () {
    $emplois = auth()->user()->emplois;
    if(auth()->user()->role=='student'){
       return view('emploi', compact('emplois'));
    }
   return view('emploiProf', compact('emplois'));
    
})->name('emploi');

use App\Models\User;

Route::middleware('auth')->get('/liste', function () {
    $listes = User::with('resultats')
        ->where('role', 'student')
        ->get();
//dd($listes);
    return view('liste', compact('listes'));
})->name('liste');


Route::middleware('auth')->get('/resultats', function () {
    $resultat = auth()->user()->resultats()->first();
    return view('resultats', compact('resultat'));
})->name('resultats');

Route::get('/dashboardProf', function () {
    return view('dashboardProf');
})->middleware(['auth', 'verified'])->name('dashboardProf');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->get('/resultats/{id}/edit', function ($id) {
    $student = \App\Models\User::with('resultats')->findOrFail($id);
    $resultat = $student->resultats->first();

    return view('editResultats', compact('student', 'resultat'));
})->name('resultats.edit');
Route::middleware('auth')->put('/resultats/{id}', function (Request $request, $id) {

    $request->validate([
        'note1' => 'required|numeric|min:0|max:20',
        'note2' => 'required|numeric|min:0|max:20',
        'note3' => 'required|numeric|min:0|max:20',
        'note4' => 'required|numeric|min:0|max:20',
        'note5' => 'required|numeric|min:0|max:20',
    ]);

    $resultat = Resultat::findOrFail($id);

    $moyenne = (
        $request->note1 +
        $request->note2 +
        $request->note3 +
        $request->note4 +
        $request->note5
    ) / 5;

    $decision = $moyenne >= 10 ? 'Admis' : 'Ajourné';

    $resultat->update([
        'note1' => $request->note1,
        'note2' => $request->note2,
        'note3' => $request->note3,
        'note4' => $request->note4,
        'note5' => $request->note5,
        'moyenne' => round($moyenne, 2),
        'decision' => $decision,
    ]);

    return redirect()->route('liste')->with('success', 'Notes mises à jour');
})->name('resultats.update');


Route::middleware('auth')->post('/etudiant/add', function (Request $request) {

    // 1️⃣ Créer l'étudiant
    $student = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make('password'),
        'role' => 'student',
        'prof_id' => auth()->id(),
    ]);

    // 2️⃣ Calcul de la moyenne
    $moyenne = (
        $request->note1 +
        $request->note2 +
        $request->note3 +
        $request->note4 +
        $request->note5
    ) / 5;

    // 3️⃣ Décision automatique
    $decision = $moyenne >= 10 ? 'Admis' : 'Ajourné';

    // 4️⃣ Créer les résultats
    Resultat::create([
        'user_id' => $student->id,
        'semestre' => 'S1',

        'matiere1' => 'Mathématiques', 'note1' => $request->note1,
        'matiere2' => 'Informatique',  'note2' => $request->note2,
        'matiere3' => 'Physique',      'note3' => $request->note3,
        'matiere4' => 'Électronique',  'note4' => $request->note4,
        'matiere5' => 'Anglais',       'note5' => $request->note5,

        'moyenne' => round($moyenne, 2),
        'decision' => $decision,
    ]);

    return redirect()->route('liste');
})->name('etudiant.add');


Route::middleware('auth')->delete('/etudiant/{id}', function ($id) {
    User::where('id', $id)->delete();
    return redirect()->route('liste');
})->name('etudiant.delete');

require __DIR__.'/auth.php';

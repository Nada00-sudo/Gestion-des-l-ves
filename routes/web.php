<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Resultat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;


Route::get('/', function () {
    return view('welcome');
});



Route::post('/firebase-login', function (Request $request) {

    $response = Http::get(
        'https://identitytoolkit.googleapis.com/v1/accounts:lookup?key=FIREBASE_API_KEY',
        ['idToken' => $request->token]
    );

    $firebaseUser = $response['users'][0];

    $user = User::firstOrCreate(
        ['email' => $firebaseUser['email']],
        [
            'name' => $firebaseUser['displayName'] ?? 'Utilisateur',
            'password' => bcrypt(str()->random(16)),
            'role' => 'student',
            'email_verified_at' => now()
        ]
    );

    Auth::login($user);

    return response()->json(['success' => true]);
});
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'prof') {
        return redirect()->route('dashboardProf');
    }
    return redirect()->route('dashboardStudent');
});

/* ================= GOOGLE LOGIN ================= */

/* REDIRECTION GOOGLE */
Route::get('/auth/google', function () {
     return Socialite::driver('google')
    ->stateless()
    ->redirect();

})->name('google.login');

/* CALLBACK GOOGLE */
Route::get('/auth/google/callback', function () {

    $googleUser = Socialite::driver('google')
    ->stateless()
    ->user();


    $user = User::where('email', $googleUser->email)->first();

    if (!$user) {
        $user = User::create([
            'name'     => $googleUser->name,
            'email'    => $googleUser->email,
            'password' => bcrypt(Str::random(16)),
            'role'     => 'student', // par défaut
            'email_verified_at' => now(), // IMPORTANT avec middleware verified
        ]);
    }

    Auth::login($user);

    /* 🔀 REDIRECTION SELON LE RÔLE */
    if ($user->role === 'student') {
        return redirect()->route('dashboardStudent');
    }

    if ($user->role === 'prof') {
        return redirect()->route('dashboardProf');
    }

    // sécurité
    return redirect('/');
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

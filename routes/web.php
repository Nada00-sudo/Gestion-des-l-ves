<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

require __DIR__.'/auth.php';

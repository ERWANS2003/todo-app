<?php

use App\Http\Controllers\TasksController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil simple
Route::get('/', function () {
    return view('welcome');
});

// Page de choix connexion/inscription
Route::get('/auth-choice', function () {
    return view('auth.choice');
})->name('auth.choice');

// Routes d'authentification
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// AJOUT DE LA ROUTE POST MANQUANTE POUR L'INSCRIPTION
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Routes pour les tâches (toutes protégées par l'authentification)
Route::middleware('auth')->group(function () {
    // Routes CRUD complètes pour les tâches
    Route::get('/tasks', [TasksController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TasksController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TasksController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TasksController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TasksController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TasksController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TasksController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('/tasks/{task}/toggle', [TasksController::class, 'toggleComplete'])
    ->name('tasks.toggle');
    Route::patch('/tasks/{task}', [TasksController::class, 'toggle'])->name('tasks.toggle');
    Route::get('/tasks', [TasksController::class, 'index'])->name('tasks.index');

    // Route supplémentaire pour basculer le statut d'une tâche
    Route::patch('/tasks/{task}/toggle', [TasksController::class, 'toggle'])->name('tasks.toggle');

    // Dashboard après connexion
    Route::get('/dashboard', function () {
        return redirect()->route('tasks.index');
    })->name('dashboard');
});

// Route de redirection pour les utilisateurs non connectés qui tentent d'accéder aux tâches
Route::get('/tasks-redirect', function () {
    return redirect()->route('auth.choice')->with('message', 'Vous devez vous connecter pour voir vos tâches');
})->name('tasks.redirect');

// Route de test pour vérifier que tout fonctionne
Route::get('/test', function () {
    return 'Laravel fonctionne correctement !';
});

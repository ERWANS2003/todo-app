<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /**
     * Afficher la liste des tâches
     */
    public function index()
{
    $user = auth::user();

    // Récupérer les tâches non terminées avec pagination
    $activeTasks = Task::where('user_id', $user->id)
        ->where('completed', false)
        ->orderBy('created_at', 'desc')
        ->paginate(5, ['*'], 'active_page');

    // Récupérer les tâches terminées avec pagination
    $completedTasks = Task::where('user_id', $user->id)
        ->where('completed', true)
        ->orderBy('completed_at', 'desc')
        ->paginate(5, ['*'], 'completed_page');

    return view('tasks.index', compact('activeTasks', 'completedTasks'));
}


    /**
     * Afficher le formulaire de création d'une tâche
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Enregistrer une nouvelle tâche
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable|max:1000',
    ]);

    Task::create([
    'title' =>  $request->title,
    'description' => $request->description,
    'user_id' => Auth::id(),
    'completed' => false,
]);

    return redirect()->route('tasks.index')
                    ->with('success', 'Tâche créée avec succès !');
}

    /**
     * Afficher une tâche spécifique
     */


    /**
     * Afficher le formulaire d'édition d'une tâche
     */
    public function edit(Task $task)
    {
        // Vérifier que la tâche appartient à l'utilisateur connecté
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * Mettre à jour une tâche
     */
    public function update(Request $request, Task $task)
    {
        // Vérifier que la tâche appartient à l'utilisateur connecté
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:1000',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('tasks.index')
                        ->with('success', 'Tâche mise à jour avec succès !');
    }

    /**
     * Supprimer une tâche
     */
    public function destroy(Task $task)
    {
        // Vérifier que la tâche appartient à l'utilisateur connecté
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        $task->delete();

        return redirect()->route('tasks.index')
                        ->with('success', 'Tâche supprimée avec succès !');
    }

    /**
     * Basculer le statut d'une tâche (terminée/non terminée)
     */
    public function toggle(Task $task)
    {
        // Vérifier que la tâche appartient à l'utilisateur connecté
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        $task->update([
            'completed' => !$task->completed
        ]);

        return redirect()->route('tasks.index')
                        ->with('success', 'Statut de la tâche mis à jour !');
    }




// Ou si vous préférez une approche plus simple :
public function toggleComplete(Task $task)
{
    if ($task->user_id !== auth::id()) {
        abort(403);
    }

    $task->update([
        'completed' => !$task->completed,
        'completed_at' => !$task->completed ? now() : null,
    ]);

    return back();
}
}

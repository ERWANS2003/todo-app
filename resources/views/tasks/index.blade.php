<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Tâches - Todo App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <div class="main-grid">

        <aside class="panel">
            <div class="panel-header user-info">
                <h2 class="panel-title">{{ Auth::user()->name }}</h2>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-logout" title="Se déconnecter">
                        Déconnexion
                    </button>
                </form>
            </div>

            <a href="{{ route('tasks.create') }}" class="btn btn-primary" style="width: 100%; margin-bottom: 1.5rem;">
                Ajouter une tâche
            </a>

            <div class="panel-header">
                <h3 class="panel-title">Rechercher</h3>
            </div>
            <form method="GET" action="{{ route('tasks.index') }}" class="search-bar">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Titre, description...">
                <button type="submit" class="btn btn-secondary" style="width: 100%; margin-top: 0.5rem;">
                    Rechercher
                </button>
                @if(request()->has('search') && request('search') != '')
                    <a href="{{ route('tasks.index') }}" class="btn-clear-search">
                        Annuler la recherche
                    </a>
                @endif
            </form>
        </aside>

        <main>
            @if(session('success'))
                <div class="alert alert-success">
                    Succès ! {{ session('success') }}
                </div>
            @endif

            @if(request('search'))
                <div class="alert alert-info">
                    Résultats pour : <strong>"{{ request('search') }}"</strong>
                </div>
            @endif

            <div class="panel">
                <div class="panel-header">
                    <h2 class="panel-title">Tâches en cours ({{ $activeTasks->total() }})</h2>
                </div>
                <ul class="task-list">
                    @forelse($activeTasks as $task)
                        <li class="task-item">
                            <div class="task-content">
                                <p class="task-title">{{ $task->title }}</p>
                                @if($task->description)
                                    <p class="task-description">{{ $task->description }}</p>
                                @endif
                                <div class="task-timestamps"> {{-- Nouveau conteneur pour les dates --}}
                                    <span class="timestamp-item">Créée le : {{ $task->created_at->format('d/m/Y H:i') }}</span>
                                    @if($task->updated_at && $task->updated_at != $task->created_at)
                                        <span class="timestamp-item">Modifiée le : {{ $task->updated_at->format('d/m/Y H:i') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="task-actions">
                                <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-success btn-sm" title="Marquer comme terminée">
                                        Terminer
                                    </button>
                                </form>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm" title="Modifier">
                                    Modifier
                                </a>
                                <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirmDelete(event)" data-task-title="{{ $task->title }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Supprimer">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="no-tasks">Aucune tâche en cours.</li>
                    @endforelse
                </ul>
                @if($activeTasks->hasPages())
                    <div class="pagination">
                        {{ $activeTasks->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>

            <div class="panel">
                <div class="panel-header">
                    <h2 class="panel-title">Tâches terminées ({{ $completedTasks->total() }})</h2>
                </div>
                <ul class="task-list">
                    @forelse($completedTasks as $task)
                        <li class="task-item completed">
                            <div class="task-content">
                                <p class="task-title">Terminée: {{ $task->title }}</p>
                                <div class="task-timestamps"> {{-- Nouveau conteneur pour les dates --}}
                                    <span class="timestamp-item">Créée le : {{ $task->created_at->format('d/m/Y H:i') }}</span>
                                    @if($task->updated_at && $task->updated_at != $task->created_at)
                                        <span class="timestamp-item">Modifiée le : {{ $task->updated_at->format('d/m/Y H:i') }}</span>
                                    @endif
                                    @if($task->completed_at)
                                        <span class="timestamp-item completed-timestamp">Terminée le : {{ $task->completed_at->format('d/m/Y H:i') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="task-actions">
                                <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-secondary btn-sm" title="Réactiver la tâche">
                                        Réactiver
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirmDelete(event)" data-task-title="{{ $task->title }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Supprimer définitivement">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="no-tasks">Aucune tâche terminée.</li>
                    @endforelse
                </ul>
                @if($completedTasks->hasPages())
                    <div class="pagination">
                        {{ $completedTasks->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>

        </main>
    </div>

    <div id="customConfirmModal" class="modal-overlay">
        <div class="modal-content">
            <h3>Confirmation</h3>
            <p id="confirmMessage"></p>
            <div class="modal-actions">
                <button id="confirmCancel" class="btn btn-secondary">Annuler</button>
                <button id="confirmProceed" class="btn btn-danger">Supprimer</button>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target;
            const taskTitle = form.dataset.taskTitle || 'cette tâche';
            const modal = document.getElementById('customConfirmModal');
            document.getElementById('confirmMessage').innerHTML = `Êtes-vous sûr de vouloir supprimer : <strong>"${taskTitle}"</strong> ? Cette action est irréversible.`;
            modal.style.display = 'flex';
            document.getElementById('confirmCancel').onclick = () => { modal.style.display = 'none'; };
            document.getElementById('confirmProceed').onclick = () => { form.submit(); };
            return false;
        }
    </script>

</body>
</html>

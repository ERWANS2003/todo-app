<!DOCTYPE html>
<html>
<head>
    <title>Mes Tâches - Todo App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }
        h1 {
            color: #333;
            margin: 0;
        }
        .section-title {
            color: #333;
            margin: 30px 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title.active {
            color: #007bff;
            border-bottom-color: #007bff;
        }
        .section-title.completed {
            color: #28a745;
            border-bottom-color: #28a745;
        }
        .task-count {
            background: #f8f9fa;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            color: #6c757d;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .task-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .task-item.completed {
            opacity: 0.8;
            background-color: #e9ecef;
            border-left: 4px solid #28a745;
        }
        .task-content {
            flex: 1;
        }
        .task-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .task-title.completed {
            text-decoration: line-through;
            color: #6c757d;
        }
        .task-description {
            color: #666;
            font-size: 14px;
        }
        .task-actions {
            display: flex;
            gap: 10px;
        }
        .no-tasks {
            text-align: center;
            color: #666;
            padding: 40px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin: 20px 0;
        }
        .logout-form {
            display: inline;
        }
        .task-dates {
            margin-top: 8px;
        }
        .task-date {
            font-size: 12px;
            color: #999;
            margin-right: 15px;
        }
        .completion-date {
            color: #28a745;
            font-weight: bold;
        }
        .completion-badge {
            background-color: #28a745;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            margin-left: 8px;
        }
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
            gap: 10px;
        }
        .pagination a, .pagination span {
            padding: 8px 12px;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #007bff;
        }
        .pagination a:hover {
            background-color: #f8f9fa;
        }
        .pagination .active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        .pagination .disabled {
            color: #6c757d;
            pointer-events: none;
        }
        .task-section {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Mes Tâches</h1>
            <div class="user-info">
                <span>Bonjour, {{ Auth::user()->name }} !</span>
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-sm">Se déconnecter</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <div style="margin-bottom: 30px;">
            <a href="{{ route('tasks.create') }}" class="btn btn-success">Ajouter une nouvelle tâche</a>
        </div>

        <!-- Section des tâches actives -->
        <div class="task-section">
            <h2 class="section-title active">
                 Tâches en cours
                <span class="task-count">{{ $activeTasks->total() }}</span>
            </h2>

            @if($activeTasks->count() > 0)
                @foreach($activeTasks as $task)
                    <div class="task-item">
                        <div class="task-content">
                            <div class="task-title">
                                {{ $task->title }}
                            </div>
                            @if($task->description)
                                <div class="task-description">
                                    {{ $task->description }}
                                </div>
                            @endif

                            <div class="task-dates">
                                <span class="task-date">
                                    Créée le {{ $task->created_at->format('d/m/Y à H:i') }}
                                </span>
                            </div>
                        </div>
                        <div class="task-actions">
                            <form method="POST" action="{{ route('tasks.toggle', $task) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success">
                                    Terminer
                                </button>
                            </form>

                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm">Modifier</a>

                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display: inline;"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination pour les tâches actives -->
                <div class="pagination">
                    {{ $activeTasks->appends(request()->query())->links() }}
                </div>
            @else
                <div class="no-tasks">
                    <h3>Aucune tâche en cours</h3>
                    <p>Toutes vos tâches sont terminées ! 🎉</p>
                </div>
            @endif
        </div>

        <!-- Section des tâches terminées -->
        <div class="task-section">
            <h2 class="section-title completed">
                 Tâches terminées
                <span class="task-count">{{ $completedTasks->total() }}</span>
            </h2>

            @if($completedTasks->count() > 0)
                @foreach($completedTasks as $task)
                    <div class="task-item completed">
                        <div class="task-content">
                            <div class="task-title completed">
                                {{ $task->title }}
                                <span class="completion-badge">✓ TERMINÉ</span>
                            </div>
                            @if($task->description)
                                <div class="task-description">
                                    {{ $task->description }}
                                </div>
                            @endif

                            <div class="task-dates">
                                <span class="task-date">
                                    Créée le {{ $task->created_at->format('d/m/Y à H:i') }}
                                </span>

                                @if($task->completed_at)
                                    <span class="task-date completion-date">
                                        ✓ Terminée le {{ $task->completed_at->format('d/m/Y à H:i') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="task-actions">
                            <form method="POST" action="{{ route('tasks.toggle', $task) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-warning">
                                    Réactiver
                                </button>
                            </form>

                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display: inline;"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination pour les tâches terminées -->
                <div class="pagination">
                    {{ $completedTasks->appends(request()->query())->links() }}
                </div>
            @else
                <div class="no-tasks">
                    <h3>Aucune tâche terminée</h3>
                    <p>Commencez par terminer quelques tâches !</p>
                </div>
            @endif
        </div>

        @if($activeTasks->total() == 0 && $completedTasks->total() == 0)
            <div class="no-tasks">
                <h3>Aucune tâche pour le moment</h3>
                <p>Commencez par créer votre première tâche !</p>
                <a href="{{ route('tasks.create') }}" class="btn btn-success">Créer ma première tâche</a>
            </div>
        @endif
    </div>
</body>
</html>

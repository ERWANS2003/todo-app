<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Modifier la Tâche - Todo App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="main-grid form-page"> {{-- Utilise main-grid pour le centrage, et form-page pour des ajustements spécifiques --}}

        <main> {{-- Le contenu principal sera dans le 'main' pour la cohérence du layout --}}

            <div class="panel form-panel"> {{-- Un panel pour encapsuler le formulaire --}}
                <div class="panel-header">
                    <h2 class="panel-title">Modifier la tâche</h2>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger"> {{-- Utilise alert-danger pour les erreurs --}}
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('tasks.update', $task) }}" class="task-form"> {{-- Ajout d'une classe pour le formulaire --}}
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">Titre de la tâche *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}"
                               placeholder="Ex: Faire les courses" required class="form-input"> {{-- Ajout de classe pour input --}}
                    </div>

                    <div class="form-group">
                        <label for="description">Description (optionnel)</label>
                        <textarea id="description" name="description"
                                  placeholder="Décrivez votre tâche en détail..." class="form-input">{{ old('description', $task->description) }}</textarea> {{-- Ajout de classe pour textarea --}}
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>

        </main>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Todo App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    {{-- Supprimé : <script src="https://unpkg.com/@phosphor-icons/web@2.1.1/dist/phosphor.js"></script> --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="main-grid welcome-page"> {{-- Utilise main-grid pour le centrage, et welcome-page pour des ajustements spécifiques --}}

        <main> {{-- Le contenu principal sera dans le 'main' --}}

            <div class="panel welcome-panel"> {{-- Un panel pour encapsuler le contenu d'accueil --}}
                <div class="panel-header" style="justify-content: center; border-bottom: none;"> {{-- Centrer le titre et pas de bordure --}}
                    <h1 class="panel-title" style="font-size: 2rem;">Bienvenue dans votre Todo App</h1>
                </div>

                <p class="welcome-text">Gérez vos tâches quotidiennes efficacement.</p>

                <div class="welcome-actions"> {{-- Nouvelle div pour centrer le bouton --}}
                    <a href="{{ Auth::check() ? route('tasks.index') : route('auth.choice') }}" class="btn btn-primary btn-lg">
                        Voir les tâches
                    </a>
                </div>
            </div>

        </main>
    </div>
</body>
</html>

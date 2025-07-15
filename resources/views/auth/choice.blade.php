<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Accès aux Tâches - Todo App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="main-grid welcome-page"> {{-- Utilise welcome-page pour centrer le contenu comme la page d'accueil --}}

        <main>
            <div class="panel choice-panel"> {{-- Un panel général pour encapsuler toute la page de choix --}}
                <div class="panel-header" style="justify-content: center; border-bottom: none; margin-bottom: var(--spacing-xl);">
                    <h1 class="panel-title" style="font-size: 1.8rem;">Accès aux tâches</h1>
                </div>

                @if(session('message'))
                    <div class="alert alert-info" style="margin-bottom: var(--spacing-xl);"> {{-- Utilise alert-info pour les messages --}}
                        {{ session('message') }}
                    </div>
                @endif

                <div class="choice-sections-wrapper"> {{-- Nouveau wrapper pour gérer l'alignement des sections de choix --}}

                    <div class="choice-section panel"> {{-- Chaque section de choix est maintenant un panel --}}
                        <div class="panel-header" style="justify-content: center; border-bottom: none;">
                            <h3 class="panel-title">Vous avez déjà un compte ?</h3>
                        </div>
                        <p class="choice-description">Connectez-vous pour accéder à vos tâches existantes.</p>
                        <div class="choice-button-wrapper">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Se connecter</a>
                        </div>
                    </div>

                    <div class="choice-section panel"> {{-- Chaque section de choix est maintenant un panel --}}
                        <div class="panel-header" style="justify-content: center; border-bottom: none;">
                            <h3 class="panel-title">Nouveau utilisateur ?</h3>
                        </div>
                        <p class="choice-description">Créez un compte pour commencer à gérer vos tâches.</p>
                        <div class="choice-button-wrapper">
                            <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">S'inscrire</a>
                        </div>
                    </div>

                </div> {{-- Fin de .choice-sections-wrapper --}}

                <div class="panel-footer" style="margin-top: var(--spacing-xxl);"> {{-- Utilise panel-footer pour le lien de retour --}}
                    <a href="{{ url('/') }}" class="link">Retour à l'accueil</a>
                </div>
            </div> {{-- Fin de .panel.choice-panel --}}

        </main>
    </div>
</body>
</html>

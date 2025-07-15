<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Connexion - Todo App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="main-grid form-page"> {{-- Utilise main-grid pour le centrage, et form-page pour des ajustements spécifiques --}}

        <main> {{-- Le contenu principal sera dans le 'main' --}}

            <div class="panel form-panel"> {{-- Un panel pour encapsuler le formulaire --}}
                <div class="panel-header">
                    <h2 class="panel-title">Connexion</h2>
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

                <form method="POST" action="{{ route('login') }}" class="auth-form"> {{-- Ajout d'une classe spécifique pour les formulaires d'auth --}}
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required class="form-input">
                    </div>

                    <div class="form-actions" style="justify-content: center;"> {{-- Centrer le bouton de connexion --}}
                        <button type="submit" class="btn btn-primary btn-lg">Se connecter</button>
                    </div>
                </form>

                <div class="panel-footer"> {{-- Nouveau bloc pour les liens bas de page du panel --}}
                    <p>Pas encore de compte ? <a href="{{ route('register') }}" class="link">S'inscrire</a></p>
                    <p><a href="{{ route('auth.choice') }}" class="link">Retour</a></p>
                </div>
            </div>

        </main>
    </div>

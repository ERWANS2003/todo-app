<!DOCTYPE html>
<html>
<head>
    <title>Connexion - Todo App</title>
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
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px;
            font-size: 16px;
            text-align: center;
            width: 200px;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .btn-back {
            background-color: #28a745;
        }
        .btn-back:hover {
            background-color: #218838;
        }
        .text-center {
            text-align: center;
        }
        .choice-section {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Accès aux tâches</h1>

        @if(session('message'))
            <div class="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="choice-section">
            <h3>Vous avez déjà un compte ?</h3>
            <p>Connectez-vous pour accéder à vos tâches existantes.</p>
            <div class="text-center">
                <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
            </div>
        </div>

        <div class="choice-section">
            <h3>Nouveau utilisateur ?</h3>
            <p>Créez un compte pour commencer à gérer vos tâches.</p>
            <div class="text-center">
                <a href="{{ route('register') }}" class="btn btn-secondary">S'inscrire</a>
            </div>
        </div>

        <div class="text-center" style="margin-top: 30px;">
            <a href="{{ url('/') }}" class="btn btn-back">Retour à l'accueil</a>
        </div>
    </div>
</body>
</html>

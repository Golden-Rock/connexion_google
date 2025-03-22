<?php
require_once 'database.php';
require_once 'google.php';
require_once 'GoogleAuth.php';
require_once '../auth/User.php';
require_once '../auth/Session.php';

// Initialiser la session
Session::start();

// Vérifier s'il y a un code d'autorisation dans l'URL
if (!isset($_GET['code'])) {
    // Rediriger vers la page d'accueil si aucun code n'est présent
    header('Location: ../index.php');
    exit;
}

// Récupérer le code d'autorisation
$authCode = $_GET['code'];

try {
    // Initialiser l'authentification Google
    $googleAuth = new GoogleAuth(GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_REDIRECT_URI);
    
    // Échanger le code d'autorisation contre un jeton d'accès
    $tokenData = $googleAuth->getAccessToken($authCode);
    
    if (!$tokenData || !isset($tokenData['access_token'])) {
        throw new Exception("Impossible d'obtenir le jeton d'accès");
    }
    
    // Récupérer les informations de l'utilisateur
    $userInfo = $googleAuth->getUserInfo($tokenData['access_token']);
    
    if (!$userInfo) {
        throw new Exception("Impossible d'obtenir les informations de l'utilisateur");
    }
    
    // Créer ou mettre à jour l'utilisateur dans la base de données
    $userModel = new User();
    $user = $userModel->createOrUpdateFromGoogle($userInfo);
    echo $userInfo;
    
    if (!$user) {
        throw new Exception("Impossible de créer ou mettre à jour l'utilisateur");
    }
    
    // Connecter l'utilisateur
    Session::setUser($user);
    
    // Rediriger l'utilisateur
    header('Location: ../private.php');
    
} catch (Exception $e) {
    // En cas d'erreur, afficher un message d'erreur
    echo '<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Erreur d\'authentification</title>
    </head>
    <body>
        <div class="container mt-5">
            <div class="alert alert-danger">
                <h4 class="alert-heading">Erreur d\'authentification!</h4>
                <p>' . htmlspecialchars($e->getMessage()) . '</p>
                <hr>
                <a href="index.php" class="btn btn-primary">Retour à l\'accueil</a>
            </div>
        </div>
    </body>
    </html>';
} 
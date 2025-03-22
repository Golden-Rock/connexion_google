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
    
    if (!$user) {
        throw new Exception("Impossible de créer ou mettre à jour l'utilisateur");
    }
    
    // Connecter l'utilisateur
    Session::setUser($user);
    
    // Rediriger l'utilisateur
    header('Location: ../private.php');
    
} catch (Exception $e) {
    // Rediriger vers la page d'erreur avec le message
    $errorMessage = urlencode($e->getMessage());
    header("Location: ../error.php?error=$errorMessage");
    exit;
} 
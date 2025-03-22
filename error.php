<?php
require_once 'auth/Session.php';

// Vérifier si l'utilisateur est déjà connecté
Session::start();
if (Session::isLoggedIn()) {
    // Rediriger vers la page privée si l'utilisateur est connecté
    header('Location: private.php');
    exit;
}

// Récupérer le message d'erreur s'il existe
$errorMessage = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : "Une erreur s'est produite lors de l'authentification";
$errorType = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : "error";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur d'authentification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .error-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        .error-icon {
            color: #e74c3c;
            font-size: 48px;
            margin-bottom: 20px;
        }
        .error-warning {
            color: #f39c12;
        }
        .error-info {
            color: #3498db;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        p {
            color: #555;
            margin-bottom: 25px;
            line-height: 1.5;
        }
        .button {
            display: inline-block;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <!-- <div class="error-icon <?php echo $errorType === 'warning' ? 'error-warning' : ($errorType === 'info' ? 'error-info' : ''); ?>">
            <?php if ($errorType === 'warning'): ?>
                ⚠️
            <?php elseif ($errorType === 'info'): ?>
                ℹ️
            <?php else: ?>
                ❌
            <?php endif; ?>
        </div> -->
        <h1 style="color: #e74c3c;">Erreur d'authentification</h1>
        <p><?php echo $errorMessage; ?></p>
        <a href="index.php" class="button">Retour à l'accueil</a>
    </div>
</body>
</html>

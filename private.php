<?php
require_once 'auth/Session.php';
Session::start();

// Vérifier si l'utilisateur est connecté
if (!Session::isLoggedIn()) {
  // Rediriger vers la page d'accueil avec un message d'erreur
  header('Location: index.php');
  exit;
}

// Récupérer les données de l'utilisateur
$user = Session::getUser();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Espace Privé</title>
</head>
<body>
  <!-- Inclure le header -->
  <?php include_once 'src/components/features/layout/header.php'; ?>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-body p-5">
            <div class="text-center mb-4">
              <img src="<?= htmlspecialchars($user['picture'] ?? 'https://via.placeholder.com/100') ?>" alt="Photo de profil" class="rounded-circle img-thumbnail" width="100" height="100"
                  onerror="this.src='https://via.placeholder.com/100?text=User'">
              <h1 class="h3 mt-3">Bienvenue, <?= htmlspecialchars($user['name'] ?? 'Utilisateur') ?> !</h1>
              <p class="text-muted"><?= htmlspecialchars($user['email'] ?? '') ?></p>
            </div>
            
            <div class="alert alert-success" role="alert">
              <h4 class="alert-heading">Connexion réussie !</h4>
              <p>Vous êtes maintenant connecté à votre espace privé. Cette page n'est accessible qu'aux utilisateurs authentifiés.</p>
              <hr>
              <p class="mb-0">Vous pouvez maintenant accéder à toutes les fonctionnalités de notre application.</p>
            </div>
            
            <div class="card mb-4">
              <div class="card-header">
                Vos informations
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  ID
                  <span class="badge bg-primary rounded-pill"><?= htmlspecialchars($user['id'] ?? 'N/A') ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Google ID
                  <span class="badge bg-secondary rounded-pill"><?= htmlspecialchars($user['google_id'] ?? 'N/A') ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Date d'inscription
                  <span><?= htmlspecialchars($user['created_at'] ?? 'N/A') ?></span>
                </li>
              </ul>
            </div>
            
            <div class="d-grid gap-2">
             
              <form action="auth/logout.php" method="post" class="mt-2">
                <button type="submit" class="btn btn-danger w-100">Se déconnecter</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
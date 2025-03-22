<?php
// Le composant user dropdown reçoit $user de header.php
if (!isset($user) || empty($user)) {
    return;
}

// Variables pour afficher les informations utilisateur
$userName = htmlspecialchars($user['name'] ?? 'Utilisateur');
$userEmail = htmlspecialchars($user['email'] ?? '');
$userPicture = $user['picture'] ?? '../../../../public/placeholder.jpg';
?>

<div class="dropdown">
  <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" id="userDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
    <div class="position-relative me-2">
      <img src="<?= $userPicture ?>" alt="Photo de profil" width="32" height="32" class="rounded-circle" 
           onerror="this.src='../../../../public/placeholder.jpg'">
     
    </div>
    <!-- <span class="d-none d-md-inline"><?= $userName ?></span> -->
  </button>
  
  <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdownButton">
    <li class="px-3 py-2 d-flex flex-column align-items-center border-bottom">
      <img src="<?= $userPicture ?>" alt="Photo de profil" width="60" height="60" class="rounded-circle mb-2"
           onerror="this.src='https://via.placeholder.com/60?text=User'">
      <strong class="text-center"><?= $userName ?></strong>
      <span class="text-muted small"><?= $userEmail ?></span>
    </li>
    <li>
      <a class="dropdown-item" href="#">Mon profil</a>
    </li>
    <li>
      <a class="dropdown-item" href="#">Paramètres</a>
    </li>
    <li><hr class="dropdown-divider"></li>
    <li>
      <!-- Inclusion du composant de déconnexion -->
      <?php include_once __DIR__ . '/./logoutButton.php'; ?>
    </li>
  </ul>
</div> 
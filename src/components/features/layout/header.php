<?php
require_once __DIR__ . '/../../../../auth/Session.php';
require_once __DIR__ . '/../../../../auth/User.php';
require_once __DIR__ . '/../../../../config/GoogleAuth.php';
require_once __DIR__ . '/../../../../config/google.php';
Session::start();
// Vérifiez si l'utilisateur est connecté
/* $isLoggedIn = Session::isLoggedIn(); */
$user = Session::getUser();
/* $user = $isLoggedIn ? Session::getUser() : null; */
$googleAuth = new GoogleAuth(GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_REDIRECT_URI);
$authUrl = $googleAuth->getAuthUrl();
?>

<header class="py-3 border-bottom bg-white shadow-sm">
  <div class="container d-flex justify-content-between align-items-center">
    <!-- Logo à gauche -->
    <a href="/" class="text-decoration-none">
      <div class="d-flex align-items-center">
       
        <span class="fs-4 fw-bold text-primary">AuthApp</span>
      </div>
    </a>

    <!-- Bouton de connexion ou User Dropdown à droite -->
    <?php if (!isset($user) || empty($user)): ?>
      <!-- Bouton de connexion Google -->
      <a href="<?php echo $authUrl ?>" class="btn btn-outline-primary d-flex align-items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="18" height="18" class="me-2">
          <path fill="#4285F4" d="M24 9.5c3.1 0 5.6 1.1 7.5 2.9l5.6-5.6C33.8 3.2 29.2 1 24 1 14.9 1 7.3 6.6 4.3 14.4l6.9 5.4C12.8 13.1 17.9 9.5 24 9.5z"/>
          <path fill="#34A853" d="M46.5 24c0-1.6-.1-3.1-.4-4.5H24v9h12.7c-.6 3.1-2.4 5.7-5 7.4l7.7 6C43.1 38.1 46.5 31.7 46.5 24z"/>
          <path fill="#FBBC05" d="M10.2 28.8c-1.1-3.1-1.1-6.5 0-9.6L3.3 13.8C-1.1 21.1-1.1 30.9 3.3 38.2l6.9-5.4z"/>
          <path fill="#EA4335" d="M24 46.5c5.2 0 9.8-1.7 13.5-4.7l-7.7-6c-2.1 1.4-4.7 2.2-7.5 2.2-6.1 0-11.2-3.6-13.2-8.7l-6.9 5.4C7.3 41.4 14.9 46.5 24 46.5z"/>
          <path fill="none" d="M0 0h48v48H0z"/>
        </svg>
        Se connecter avec Google
      </a>
    <?php else: ?>
      <!-- User Dropdown - Inclusion du composant -->
      <?php include_once __DIR__ . '/../../../../src/components/features/auth/userDropdown.php'; ?>
    <?php endif; ?>
  </div>
</header> 
<?php
require_once 'Session.php';

// Démarrer la session
Session::start();

// Détruire la session
Session::destroy();

// Rediriger vers la page d'accueil
header('Location: ../index.php');
exit; 
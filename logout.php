<?php
require_once 'includes/functions.php';

// Vérifier si l'utilisateur est connecté
if (isLoggedIn()) {
    // Déconnecter l'utilisateur
    logoutUser();
}

// Rediriger vers la page de connexion
header('Location: login.php');
exit;
?>
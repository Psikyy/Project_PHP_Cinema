<?php
// Configuration de la base de données
define('DB_HOST', 'db');  // Nom du service MySQL dans docker-compose
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'imdb');

// Configuration du site
define('SITE_URL', 'http://localhost');
define('SITE_NAME', 'Internet Movies DataBase & Co');

// Configuration des sessions
session_start();
?>
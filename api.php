<?php
require_once 'config/db.php';
require_once 'utils/response.php';

// Récupération de l'endpoint
$endpoint = $_GET['endpoint'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

// Routage
switch ($endpoint) {
    case 'films':
        require_once 'endpoints/films.php';
        handleFilms($pdo, $method);
        break;
    case 'realisateurs':
        require_once 'endpoints/realisateurs.php';
        handleRealisateurs($pdo, $method);
        break;
    case 'categories':
        require_once 'endpoints/categories.php';
        handleCategories($pdo, $method);
        break;
    case 'utilisateurs':
        require_once 'endpoints/utilisateurs.php';
        handleUtilisateurs($pdo, $method);
        break;
    case 'cart':
        require_once 'endpoints/cart.php';
        handleCart($pdo, $method);
        break;
    default:
        jsonResponse(["success" => false, "message" => "Endpoint invalide."], 404);
}

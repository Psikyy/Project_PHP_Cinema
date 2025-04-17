<?php
session_start();
require_once 'includes/functions.php';

if (!isset($_POST['action']) || $_POST['action'] !== 'add') {
    http_response_code(400);
    echo "Action invalide.";
    exit;
}

if (!isset($_POST['film_id'])) {
    http_response_code(400);
    echo "ID du film manquant.";
    exit;
}

$filmId = intval($_POST['film_id']);
$quantity = 1; // Tu peux rendre ça dynamique plus tard

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$filmId])) {
    $_SESSION['cart'][$filmId] += $quantity;
} else {
    $_SESSION['cart'][$filmId] = $quantity;
}

// Redirection vers la page précédente ou vers le panier
header("Location: index.php"); // ou header("Location: cart.php");
exit;
?>

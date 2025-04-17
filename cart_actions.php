<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';

$conn = getDbConnection();

switch ($action) {
    case 'add':
        if (!isset($_POST['film_id'])) {
            header('Location: index.php?error=missing_id');
            exit;
        }

        $filmId = intval($_POST['film_id']);
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

        // Vérifie si l'article est déjà dans le panier
        $stmt = $conn->prepare("SELECT id FROM paniers WHERE utilisateur_id = :user_id AND film_id = :film_id");
        $stmt->execute(['user_id' => $userId, 'film_id' => $filmId]);

        if ($stmt->fetch()) {
            // Déjà présent → on incrémente
            $stmt = $conn->prepare("UPDATE paniers SET quantite = quantite + :quantity WHERE utilisateur_id = :user_id AND film_id = :film_id");
        } else {
            // Pas présent → on ajoute
            $stmt = $conn->prepare("INSERT INTO paniers (utilisateur_id, film_id, quantite, date_ajout) VALUES (:user_id, :film_id, :quantity, NOW())");
        }

        if ($stmt->execute(['user_id' => $userId, 'film_id' => $filmId, 'quantity' => $quantity])) {
            // ✅ Redirection après succès
            header('Location: cart.php');
            exit;
        } else {
            // ❌ Erreur → retour page film
            header('Location: film.php?id=' . $filmId . '&error=add_failed');
            exit;
        }

    case 'remove':
        if (!isset($_POST['film_id'])) {
            header('Location: cart.php');
            exit;
        }

        $filmId = intval($_POST['film_id']);

        $stmt = $conn->prepare("DELETE FROM paniers WHERE utilisateur_id = :user_id AND film_id = :film_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':film_id', $filmId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header('Location: cart.php');
            exit;
        } else {
            header('Location: cart.php?error=remove_failed');
            exit;
        }

    case 'clear':
        $stmt = $conn->prepare("DELETE FROM paniers WHERE utilisateur_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header('Location: cart.php');
            exit;
        } else {
            header('Location: cart.php?error=clear_failed');
            exit;
        }

    default:
        header('Location: index.php?error=invalid_action');
        exit;
}
?>

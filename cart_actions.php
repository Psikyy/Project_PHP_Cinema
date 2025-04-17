<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    exit;
}

$userId = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';

$conn = getDbConnection();

switch ($action) {
    case 'add':
        if (!isset($_POST['film_id'])) {
            echo json_encode(['success' => false, 'message' => 'ID du film manquant.']);
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
            echo json_encode(['success' => true, 'message' => 'Film ajouté au panier.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout du film.']);
        }
        break;

        case 'remove':
            if (!isset($_POST['film_id'])) {
                echo json_encode(['success' => false, 'message' => 'ID du film manquant.']);
                exit;
            }
    
            $filmId = intval($_POST['film_id']);
    
            $stmt = $conn->prepare("DELETE FROM paniers WHERE utilisateur_id = :user_id AND film_id = :film_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':film_id', $filmId, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Film retiré du panier.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors du retrait du film.']);
            }
            break;
    
        case 'clear':
            // Vider le panier
            $stmt = $conn->prepare("DELETE FROM paniers WHERE utilisateur_id = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Le panier a été vidé avec succès.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors du vidage du panier.']);
            }
            break;
    
        default:
            echo json_encode(['success' => false, 'message' => 'Action inconnue.']);
            break;
    }
    ?>

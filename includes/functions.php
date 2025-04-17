<?php
require_once 'db.php';

// Fonction pour récupérer tous les films
function getAllFilms($limit = null) {
    $conn = getDbConnection();
    $sql = "SELECT f.*, r.nom as realisateur_nom, c.nom as categorie_nom 
            FROM films f 
            LEFT JOIN realisateurs r ON f.realisateur_id = r.id 
            LEFT JOIN categories c ON f.categorie_id = c.id 
            ORDER BY f.id DESC";
            
    if ($limit) {
        $sql .= " LIMIT :limit";
    }
    
    $stmt = $conn->prepare($sql);
    
    if ($limit) {
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer un film par ID
function getFilmById($id) {
    $conn = getDbConnection();
    $stmt = $conn->prepare("SELECT f.*, r.nom as realisateur_nom, c.nom as categorie_nom 
                           FROM films f 
                           LEFT JOIN realisateurs r ON f.realisateur_id = r.id 
                           LEFT JOIN categories c ON f.categorie_id = c.id 
                           WHERE f.id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer les acteurs d'un film
function getActorsByFilmId($filmId) {
    $conn = getDbConnection();
    $stmt = $conn->prepare("SELECT a.* FROM acteurs a 
                           JOIN film_acteurs fa ON a.id = fa.acteur_id 
                           WHERE fa.film_id = :film_id");
    $stmt->bindParam(':film_id', $filmId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer les films par catégorie
function getFilmsByCategory($categoryId) {
    $conn = getDbConnection();
    $stmt = $conn->prepare("SELECT f.*, r.nom as realisateur_nom, c.nom as categorie_nom 
                           FROM films f 
                           LEFT JOIN realisateurs r ON f.realisateur_id = r.id 
                           LEFT JOIN categories c ON f.categorie_id = c.id 
                           WHERE f.categorie_id = :category_id");
    $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer les films par réalisateur
function getFilmsByDirector($directorId) {
    $conn = getDbConnection();
    $stmt = $conn->prepare("SELECT f.*, r.nom as realisateur_nom, c.nom as categorie_nom 
                           FROM films f 
                           LEFT JOIN realisateurs r ON f.realisateur_id = r.id 
                           LEFT JOIN categories c ON f.categorie_id = c.id 
                           WHERE f.realisateur_id = :director_id");
    $stmt->bindParam(':director_id', $directorId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction de recherche de films par titre ou réalisateur
function searchFilms($query) {
    $conn = getDbConnection();
    $searchQuery = "%$query%";
    $stmt = $conn->prepare("SELECT f.*, r.nom as realisateur_nom, c.nom as categorie_nom 
                           FROM films f 
                           LEFT JOIN realisateurs r ON f.realisateur_id = r.id 
                           LEFT JOIN categories c ON f.categorie_id = c.id 
                           WHERE f.titre LIKE :query OR r.nom LIKE :query");
    $stmt->bindParam(':query', $searchQuery, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour vérifier si l'utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Rediriger si l'utilisateur n'est pas connecté
function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header('Location: login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }
}

// Fonction pour ajouter un film au panier
function addToCart($filmId, $quantity = 1) {
    if (!isLoggedIn()) {
        return false;
    }
    
    $conn = getDbConnection();
    
    // Vérifier si le film est déjà dans le panier
    $stmt = $conn->prepare("SELECT * FROM paniers WHERE utilisateur_id = :user_id AND film_id = :film_id");
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':film_id', $filmId, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        // Mettre à jour la quantité
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $newQuantity = $row['quantite'] + $quantity;
        
        $updateStmt = $conn->prepare("UPDATE paniers SET quantite = :quantity WHERE id = :id");
        $updateStmt->bindParam(':quantity', $newQuantity, PDO::PARAM_INT);
        $updateStmt->bindParam(':id', $row['id'], PDO::PARAM_INT);
        return $updateStmt->execute();
    } else {
        // Ajouter le film au panier
        $insertStmt = $conn->prepare("INSERT INTO paniers (utilisateur_id, film_id, quantite) VALUES (:user_id, :film_id, :quantity)");
        $insertStmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $insertStmt->bindParam(':film_id', $filmId, PDO::PARAM_INT);
        $insertStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        return $insertStmt->execute();
    }
}

// Fonction pour récupérer le panier de l'utilisateur
function getUserCart() {
    if (!isLoggedIn()) {
        return [];
    }
    
    $conn = getDbConnection();
    $stmt = $conn->prepare("SELECT p.*, f.titre, f.prix 
                           FROM paniers p 
                           JOIN films f ON p.film_id = f.id 
                           WHERE p.utilisateur_id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour calculer le total du panier
function getCartTotal() {
    $cart = getUserCart();
    $total = 0;
    
    foreach ($cart as $item) {
        $total += $item['prix'] * $item['quantite'];
    }
    
    return $total;
}

// Fonction pour supprimer un film du panier
function removeFromCart($itemId) {
    if (!isLoggedIn()) {
        return false;
    }
    
    $conn = getDbConnection();
    $stmt = $conn->prepare("DELETE FROM paniers WHERE id = :id AND utilisateur_id = :user_id");
    $stmt->bindParam(':id', $itemId, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    return $stmt->execute();
}

// Fonction pour vider le panier
function emptyCart() {
    if (!isLoggedIn()) {
        return false;
    }
    
    $conn = getDbConnection();
    $stmt = $conn->prepare("DELETE FROM paniers WHERE utilisateur_id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    return $stmt->execute();
}

// Fonction pour récupérer toutes les catégories
function getAllCategories() {
    $conn = getDbConnection();
    $stmt = $conn->prepare("SELECT * FROM categories");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour enregistrer un nouvel utilisateur
function registerUser($email, $password) {
    $conn = getDbConnection();
    
    // Vérifier si l'email existe déjà
    $checkStmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $checkStmt->bindParam(':email', $email, PDO::PARAM_STR);
    $checkStmt->execute();
    
    if ($checkStmt->rowCount() > 0) {
        return ['success' => false, 'message' => 'Cet email est déjà utilisé.'];
    }
    
    // Hasher le mot de passe avant de le stocker
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insérer le nouvel utilisateur
    $insertStmt = $conn->prepare("INSERT INTO utilisateurs (email, mot_de_passe) VALUES (:email, :password)");
    $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
    $insertStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
    
    if ($insertStmt->execute()) {
        return ['success' => true, 'message' => 'Inscription réussie. Vous pouvez maintenant vous connecter.'];
    } else {
        return ['success' => false, 'message' => 'Une erreur est survenue lors de l\'inscription.'];
    }
}

function logoutUser() {
    // Démarrer la session si ce n'est pas déjà fait
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Supprimer toutes les variables de session
    $_SESSION = [];

    // Détruire la session
    session_destroy();
}

// Fonction pour connecter un utilisateur
function loginUser($email, $password) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $conn = getDbConnection();
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Vérifier le mot de passe
        if (password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            return ['success' => true, 'message' => 'Connexion réussie.'];
        }
    }
    
    return ['success' => false, 'message' => 'Email ou mot de passe incorrect.'];
}

// Fonction pour changer le mot de passe
function changePassword($userId, $currentPassword, $newPassword) {
    $conn = getDbConnection();
    
    // Récupérer le mot de passe actuel
    $stmt = $conn->prepare("SELECT mot_de_passe FROM utilisateurs WHERE id = :userId");
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Vérifier si le mot de passe actuel est correct
    if (!password_verify($currentPassword, $user['mot_de_passe'])) {
        return ['success' => false, 'message' => 'Le mot de passe actuel est incorrect.'];
    }
    
    // Hasher le nouveau mot de passe
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
    // Mettre à jour le mot de passe
    $updateStmt = $conn->prepare("UPDATE utilisateurs SET mot_de_passe = :password WHERE id = :userId");
    $updateStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
    $updateStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    
    if ($updateStmt->execute()) {
        return ['success' => true, 'message' => 'Mot de passe changé avec succès.'];
    } else {
        return ['success' => false, 'message' => 'Une erreur est survenue lors du changement de mot de passe.'];
    }
}
?>
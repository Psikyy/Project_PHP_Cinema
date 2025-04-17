<?php
require_once 'config.php';

function getDbConnection() {
    try {
        $conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        die('Erreur de connexion à la base de données: ' . $e->getMessage());
    }
}

// Fonction pour échapper les données et éviter les injections SQL
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
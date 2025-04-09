<?php
function handleCategories($pdo, $method) {
    if ($method === 'GET') {
        if (!empty($_GET['id'])) {
            $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $categorie = $stmt->fetch(PDO::FETCH_ASSOC);
            jsonResponse(["success" => true, "data" => $categorie]);
        } else {
            $stmt = $pdo->query("SELECT * FROM categories");
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            jsonResponse(["success" => true, "data" => $categories]);
        }
    }
    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("INSERT INTO categories (nom) VALUES (?)");
        $stmt->execute([$data['nom']]);
        jsonResponse(["success" => true, "message" => "Catégorie ajoutée"]);
    }
    elseif ($method === 'PUT') {
        $id = $_GET['id'] ?? null;
        if (!$id) jsonResponse(["success" => false, "message" => "ID requis"], 400);
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("UPDATE categories SET nom = ? WHERE id = ?");
        $stmt->execute([$data['nom'], $id]);
        jsonResponse(["success" => true, "message" => "Catégorie modifiée"]);
    }
    elseif ($method === 'DELETE') {
        $id = $_GET['id'] ?? null;
        if (!$id) jsonResponse(["success" => false, "message" => "ID requis"], 400);
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        jsonResponse(["success" => true, "message" => "Catégorie supprimée"]);
    }
}

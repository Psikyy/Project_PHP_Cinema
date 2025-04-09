<?php
function handleRealisateurs($pdo, $method) {
    if ($method === 'GET') {
        if (!empty($_GET['id'])) {
            $stmt = $pdo->prepare("SELECT * FROM realisateurs WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $realisateur = $stmt->fetch(PDO::FETCH_ASSOC);
            jsonResponse(["success" => true, "data" => $realisateur]);
        } else {
            $stmt = $pdo->query("SELECT * FROM realisateurs");
            $realisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            jsonResponse(["success" => true, "data" => $realisateurs]);
        }
    }
    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("INSERT INTO realisateurs (nom) VALUES (?)");
        $stmt->execute([$data['nom']]);
        jsonResponse(["success" => true, "message" => "Réalisateur ajouté"]);
    }
    elseif ($method === 'PUT') {
        $id = $_GET['id'] ?? null;
        if (!$id) jsonResponse(["success" => false, "message" => "ID requis"], 400);
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("UPDATE realisateurs SET nom = ? WHERE id = ?");
        $stmt->execute([$data['nom'], $id]);
        jsonResponse(["success" => true, "message" => "Réalisateur modifié"]);
    }
    elseif ($method === 'DELETE') {
        $id = $_GET['id'] ?? null;
        if (!$id) jsonResponse(["success" => false, "message" => "ID requis"], 400);
        $stmt = $pdo->prepare("DELETE FROM realisateurs WHERE id = ?");
        $stmt->execute([$id]);
        jsonResponse(["success" => true, "message" => "Réalisateur supprimé"]);
    }
}

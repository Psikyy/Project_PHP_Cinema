<?php
function handleFilms($pdo, $method) {
    if ($method === 'GET') {
        if (!empty($_GET['id'])) {
            $stmt = $pdo->prepare("SELECT * FROM films WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $film = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($film) {
                jsonResponse(["success" => true, "data" => $film]);
            } else {
                jsonResponse(["success" => false, "message" => "Film non trouvé"]);
            }
        } else {
            $stmt = $pdo->query("SELECT * FROM films");
            $films = $stmt->fetchAll(PDO::FETCH_ASSOC);
            jsonResponse(["success" => true, "data" => $films]);
        }
    }
    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("INSERT INTO films (titre, description, realisateur_id, categorie_id, prix) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$data['titre'], $data['description'], $data['realisateur_id'], $data['categorie_id'], $data['prix']]);
        jsonResponse(["success" => true, "message" => "Film ajouté"]);
    }
    elseif ($method === 'PUT') {
        $id = $_GET['id'] ?? null;
        if (!$id) jsonResponse(["success" => false, "message" => "ID requis"], 400);
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("UPDATE films SET titre=?, description=?, realisateur_id=?, categorie_id=?, prix=? WHERE id=?");
        $stmt->execute([$data['titre'], $data['description'], $data['realisateur_id'], $data['categorie_id'], $data['prix'], $id]);
        jsonResponse(["success" => true, "message" => "Film modifié"]);
    }
    elseif ($method === 'DELETE') {
        $id = $_GET['id'] ?? null;
        if (!$id) jsonResponse(["success" => false, "message" => "ID requis"], 400);
        $stmt = $pdo->prepare("DELETE FROM films WHERE id = ?");
        $stmt->execute([$id]);
        jsonResponse(["success" => true, "message" => "Film supprimé"]);
    }
}

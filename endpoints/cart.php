<?php
session_start();

function handleCart($pdo, $method) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if ($method === 'GET') {
        jsonResponse(["success" => true, "cart" => $_SESSION['cart']]);
    }
    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id_film = $data['film_id'] ?? null;
        if (!$id_film) jsonResponse(["success" => false, "message" => "film_id manquant"], 400);
        $_SESSION['cart'][] = $id_film;
        jsonResponse(["success" => true, "message" => "Film ajouté au panier"]);
    }
    elseif ($method === 'DELETE') {
        session_destroy();
        jsonResponse(["success" => true, "message" => "Panier vidé"]);
    }
}

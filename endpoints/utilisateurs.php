<?php
session_start();

function handleUtilisateurs($pdo, $method) {
    if ($method === 'POST') {
        $action = $_GET['action'] ?? '';

        $data = json_decode(file_get_contents("php://input"), true);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            jsonResponse(["success" => false, "message" => "Email et mot de passe requis"], 400);
        }

        if ($action === 'register') {
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                jsonResponse(["success" => false, "message" => "Utilisateur déjà existant"], 409);
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, mot_de_passe) VALUES (?, ?)");
            $stmt->execute([$email, $hash]);
            jsonResponse(["success" => true, "message" => "Inscription réussie"]);
        }

        if ($action === 'login') {
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($password, $user['mot_de_passe'])) {
                jsonResponse(["success" => false, "message" => "Identifiants incorrects"], 401);
            }

            $_SESSION['user_id'] = $user['id'];
            jsonResponse(["success" => true, "message" => "Connexion réussie"]);
        }

        jsonResponse(["success" => false, "message" => "Action non reconnue"], 400);
    }

    elseif ($method === 'GET') {
        if (!isset($_SESSION['user_id'])) {
            jsonResponse(["success" => false, "message" => "Non connecté"], 401);
        }

        $stmt = $pdo->prepare("SELECT id, email FROM utilisateurs WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        jsonResponse(["success" => true, "data" => $user]);
    }

    elseif ($method === 'DELETE') {
        session_destroy();
        jsonResponse(["success" => true, "message" => "Déconnexion réussie"]);
    }
}

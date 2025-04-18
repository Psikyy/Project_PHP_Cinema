<?php
require_once 'includes/functions.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Rediriger si l'utilisateur est déjà connecté
if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$message = '';
$messageType = '';
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $message = 'Tous les champs sont obligatoires.';
        $messageType = 'danger';
    } else {
        $result = loginUser($email, $password);
        
        if ($result['success']) {
            header('Location: ' . $redirect);
            exit;
        } else {
            $message = $result['message'];
            $messageType = 'danger';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= htmlspecialchars($messageType) ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="login.php?redirect=<?= urlencode($redirect) ?>">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>

        <div class="form-footer" style="margin-top: 1em;">
            <p>Pas encore de compte ? <a href="register.php" class="btn-link">Créer un compte</a></p>
        </div>
    </div>
</body>
</html>

<?php
require_once 'includes/functions.php';

// Rediriger si l'utilisateur est déjà connecté
if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$message = '';
$messageType = '';

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Validation de base
    if (empty($email) || empty($password) || empty($confirmPassword)) {
        $message = 'Tous les champs sont obligatoires.';
        $messageType = 'danger';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'L\'adresse email n\'est pas valide.';
        $messageType = 'danger';
    } elseif ($password !== $confirmPassword) {
        $message = 'Les mots de passe ne correspondent pas.';
        $messageType = 'danger';
    } elseif (strlen($password) < 8) {
        $message = 'Le mot de passe doit contenir au moins 8 caractères.';
        $messageType = 'danger';
    } else {
        // Tentative d'inscription
        $result = registerUser($email, $password);
        
        if ($result['success']) {
            $message = $result['message'];
            $messageType = 'success';
        } else {
            $message = $result['message'];
            $messageType = 'danger';
        }
    }
}

$pageTitle = 'Inscription';
$pageDescription = 'Créez un compte sur Internet Movies DataBase & Co pour acheter des films en ligne';

include 'includes/header.php';
?>

<div class="form-container">
    <h2>Inscription</h2>
    
    <?php if ($message): ?>
        <div class="alert alert-<?php echo $messageType; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
            <small>Le mot de passe doit contenir au moins 8 caractères.</small>
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Confirmer le mot de passe</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">S'inscrire</button>
        </div>
    </form>
    
    <div class="form-footer">
        <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
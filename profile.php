<?php
require_once 'includes/functions.php';

// Rediriger si l'utilisateur n'est pas connecté
redirectIfNotLoggedIn();

// Récupérer les informations de l'utilisateur connecté
$conn = getDbConnection();
$stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE id = :user_id");
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Si l'utilisateur n'existe pas, déconnecter et rediriger
    logoutUser();
    header('Location: login.php');
    exit;
}

$pageTitle = 'Profil';
$pageDescription = 'Gérez vos informations personnelles et vos paramètres de compte.';

include 'includes/header.php';
?>

<section class="profile-section">
    <div class="section-header">
        <h2>Mon Profil</h2>
    </div>
    
    <div class="profile-grid">
        <div class="profile-section">
            <h3>Informations personnelles</h3>
            <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Date d'inscription :</strong> <?php echo date('d/m/Y', strtotime($user['created_at'])); ?></p>
        </div>
        
        <div class="profile-section">
            <h3>Changer le mot de passe</h3>
            <form action="change_password.php" method="POST">
                <div class="form-group">
                    <label for="current_password">Mot de passe actuel</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Nouveau mot de passe</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn">Mettre à jour</button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
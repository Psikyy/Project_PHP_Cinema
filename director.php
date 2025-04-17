<?php
require_once 'includes/functions.php';

// Vérifier si l'ID du réalisateur est fourni
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$directorId = intval($_GET['id']);
$films = getFilmsByDirector($directorId);

// Si le réalisateur n'existe pas, rediriger vers la page d'accueil
if (empty($films)) {
    header('Location: index.php');
    exit;
}

$directorName = $films[0]['realisateur_nom'];

$pageTitle = 'Réalisateur: ' . $directorName;
$pageDescription = 'Découvrez tous les films réalisés par ' . $directorName . ' sur Internet Movies DataBase & Co';

include 'includes/header.php';
?>

<section class="director-section">
    <div class="section-header">
        <h2>Films réalisés par <?php echo $directorName; ?></h2>
    </div>
    
    <div class="film-grid">
        <?php foreach ($films as $film): ?>
            <div class="film-card">
                <div class="film-image">
                    <a href="film.php?id=<?php echo $film['id']; ?>">
                        <img src="assets/images/films/<?php echo $film['id']; ?>.jpg" onerror="this.src='assets/images/placeholder.jpg'" alt="<?php echo $film['titre']; ?>">
                    </a>
                </div>
                <div class="film-info">
                    <h3><a href="film.php?id=<?php echo $film['id']; ?>"><?php echo $film['titre']; ?></a></h3>
                    <div class="film-category">
                        <a href="category.php?id=<?php echo $film['categorie_id']; ?>"><?php echo $film['categorie_nom']; ?></a>
                    </div>
                    <div class="film-price">
                        <span class="price"><?php echo number_format($film['prix'], 2, ',', ' '); ?> €</span>
                        <form action="cart_actions.php" method="POST">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="film_id" value="<?php echo $film['id']; ?>">
                            <button type="submit" class="btn add-to-cart-btn"><i class="fas fa-shopping-cart"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
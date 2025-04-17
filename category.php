<?php
require_once 'includes/functions.php';

// Vérifier si l'ID de la catégorie est fourni
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$categoryId = intval($_GET['id']);
$films = getFilmsByCategory($categoryId);

// Si la catégorie n'existe pas, rediriger vers la page d'accueil
if (empty($films)) {
    header('Location: index.php');
    exit;
}

$categoryName = $films[0]['categorie_nom'];

$pageTitle = 'Catégorie: ' . $categoryName;
$pageDescription = 'Découvrez tous les films de la catégorie ' . $categoryName . ' sur Internet Movies DataBase & Co';

include 'includes/header.php';
?>

<section class="category-section">
    <div class="section-header">
        <h2>Films de la catégorie : <?php echo $categoryName; ?></h2>
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
                    <div class="film-director">
                        <a href="director.php?id=<?php echo $film['realisateur_id']; ?>"><?php echo $film['realisateur_nom']; ?></a>
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
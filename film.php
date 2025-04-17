<?php
require_once 'includes/functions.php';

// Vérifier si l'ID du film est fourni
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$filmId = intval($_GET['id']);
$film = getFilmById($filmId);

// Si le film n'existe pas, rediriger vers la page d'accueil
if (!$film) {
    header('Location: index.php');
    exit;
}

$actors = getActorsByFilmId($filmId);

$pageTitle = $film['titre'];
$pageDescription = substr($film['description'], 0, 160) . '...';

include 'includes/header.php';
?>

<div class="film-detail">
    <div class="film-poster">
        <img src="assets/images/films/<?php echo $film['id']; ?>.jpg" onerror="this.src='assets/images/placeholder.jpg'" alt="<?php echo $film['titre']; ?>">
    </div>
    
    <div class="film-info-detail">
        <h2><?php echo $film['titre']; ?></h2>
        
        <div class="film-meta">
            <span>Réalisé par <a href="director.php?id=<?php echo $film['realisateur_id']; ?>"><?php echo $film['realisateur_nom']; ?></a></span>
            <span> | </span>
            <span>Catégorie: <a href="category.php?id=<?php echo $film['categorie_id']; ?>"><?php echo $film['categorie_nom']; ?></a></span>
        </div>
        
        <div class="film-description">
            <p><?php echo $film['description']; ?></p>
        </div>
        
        <div class="film-actors">
            <h3>Acteurs</h3>
            <div class="actors-list">
                <?php foreach ($actors as $actor): ?>
                    <span class="actor-badge"><?php echo $actor['nom']; ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="film-actions">
            <div class="price-tag">
                <span class="price"><?php echo number_format($film['prix'], 2, ',', ' '); ?> €</span>
            </div>
            
            <form action="cart_actions.php" method="POST">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="film_id" value="<?php echo $film['id']; ?>">
                <button type="submit" class="btn add-to-cart-btn">Ajouter au panier</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<?php
require_once 'includes/functions.php';

$searchQuery = '';
$searchResults = [];

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $searchQuery = sanitize($_GET['q']);
    $searchResults = searchFilms($searchQuery);
}

$pageTitle = 'Recherche';
$pageDescription = 'Recherchez des films par titre ou réalisateur sur Internet Movies DataBase & Co';

include 'includes/header.php';
?>

<section class="search-section">
    <h2>Recherche de films</h2>
    
    <div class="search-form-container">
        <form action="search.php" method="GET" class="search-form">
            <div class="form-group">
                <input type="text" name="q" value="<?php echo $searchQuery; ?>" placeholder="Rechercher un film ou un réalisateur..." required>
                <button type="submit" class="btn">Rechercher</button>
            </div>
        </form>
    </div>
    
    <?php if ($searchQuery): ?>
        <div class="search-results">
            <h3>Résultats pour "<?php echo $searchQuery; ?>"</h3>
            
            <?php if (count($searchResults) > 0): ?>
                <div class="film-grid">
                    <?php foreach ($searchResults as $film): ?>
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
            <?php else: ?>
                <div class="no-results">
                    <p>Aucun résultat trouvé pour votre recherche. Veuillez essayer avec d'autres termes.</p>
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="search-tips">
            <h3>Conseils de recherche</h3>
            <ul>
                <li>Recherchez par titre de film, par exemple : "Inception", "Titanic"</li>
                <li>Recherchez par nom de réalisateur, par exemple : "Christopher Nolan", "James Cameron"</li>
                <li>Soyez concis dans vos termes de recherche pour de meilleurs résultats</li>
            </ul>
        </div>
    <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>
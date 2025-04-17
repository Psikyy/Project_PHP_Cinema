<?php
require_once 'includes/functions.php';

$pageTitle = 'Accueil';
$pageDescription = 'Bienvenue sur Internet Movies DataBase & Co - Votre source pour tous les films!';

// Récupérer les films les plus récents
$recentFilms = getAllFilms(6);

include 'includes/header.php';
?>

<section class="hero">
    <h2>Bienvenue sur Internet Movies DataBase & Co</h2>
    <p>Découvrez et achetez les meilleurs films de tous les temps. Notre collection comprend des milliers de films de tous genres, des grands classiques aux dernières sorties.</p>
    <a href="search.php" class="btn">Explorer les films</a>
</section>

<section class="recent-films">
    <div class="section-header">
        <h2>Films récents</h2>
        <a href="search.php" class="view-all">Voir tout</a>
    </div>
    
    <div class="film-grid">
        <?php foreach ($recentFilms as $film): ?>
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

<section class="categories">
    <div class="section-header">
        <h2>Catégories</h2>
    </div>
    
    <div class="category-grid">
        <?php foreach ($categories as $category): ?>
            <a href="category.php?id=<?php echo $category['id']; ?>" class="category-card">
                <div class="category-content">
                    <h3><?php echo $category['nom']; ?></h3>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="about-section">
    <div class="section-header">
        <h2>À propos d'Internet Movies DataBase & Co</h2>
    </div>
    
    <div class="about-content">
        <p>Internet Movies DataBase & Co est votre destination ultime pour tous les films. Que vous soyez fan d'action, de drame, de comédie ou de science-fiction, nous avons ce qu'il vous faut.</p>
        <p>Notre mission est de rendre accessible le plus grand nombre de films pour tous les cinéphiles. Nous proposons une large sélection de films, des grands classiques aux dernières sorties.</p>
        <p>Parcourez notre catalogue, trouvez votre prochain film préféré et commandez-le en quelques clics !</p>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
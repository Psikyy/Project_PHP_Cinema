<?php
require_once 'includes/functions.php';

// Rediriger si l'utilisateur n'est pas connecté
redirectIfNotLoggedIn();

// Récupérer les films récents
$recentFilms = getAllFilms(6);

include 'includes/header.php';
?>

<!-- Section des films récents -->
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
                        <form action="cart_actions.php" method="POST" class="add-to-cart-form">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="film_id" value="<?php echo $film['id']; ?>">
                            <button type="submit" class="btn add-to-cart-btn"><i class="fas fa-shopping-cart"></i> Ajouter au panier</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Notification Box -->
<div id="notification" class="notification hidden">
    <p id="notification-message"></p>
</div>

<?php include 'includes/footer.php'; ?>

<script>
// Fonction pour afficher la notification
function showNotification(message, success = true) {
    const notification = document.getElementById('notification');
    const messageElem = document.getElementById('notification-message');
    notification.classList.remove('hidden');
    messageElem.textContent = message;

    // Appliquer une classe de succès ou d'erreur
    notification.classList.add(success ? 'success' : 'error');

    // Appliquer un délai avant de cacher la notification
    setTimeout(() => {
        notification.classList.add('hidden');
    }, 3000);
}

// Gestion des actions du panier (ajouter / retirer)
document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const action = form.querySelector('input[name="action"]').value;
        const filmId = form.querySelector('input[name="film_id"]').value;

        fetch('cart_actions.php', {
            method: 'POST',
            body: new URLSearchParams(new FormData(form))
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, true);
                if (action === 'remove') {
                    window.location.href = 'index.php';  // Rediriger vers l'accueil après suppression
                }
            } else {
                showNotification(data.message, false);
            }
        })
        .catch(error => {
            showNotification('Une erreur est survenue, veuillez réessayer.', false);
        });
    });
});
</script>

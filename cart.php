<?php
require_once 'includes/functions.php';

// Rediriger si l'utilisateur n'est pas connecté
redirectIfNotLoggedIn();

// Récupérer le panier de l'utilisateur
$cartItems = getUserCart();
$cartTotal = getCartTotal();

$pageTitle = 'Panier';
$pageDescription = 'Consultez et gérez les articles dans votre panier.';

include 'includes/header.php';
?>

<section class="cart-section">
    <div class="section-header">
        <h2>Mon Panier</h2>
    </div>
    
    <?php if (count($cartItems) > 0): ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Film</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['titre']); ?></td>
                        <td><?php echo number_format($item['prix'], 2, ',', ' '); ?> €</td>
                        <td>
                            <form action="cart_actions.php" method="POST">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantite']; ?>" min="1" class="quantity-input">
                            </form>
                        </td>
                        <td><?php echo number_format($item['prix'] * $item['quantite'], 2, ',', ' '); ?> €</td>
                        <td>
                            <form method="POST" action="cart_actions.php" class="remove-form">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="film_id" value="<?= $item['film_id'] ?>">
                                <button type="submit" class="remove-btn">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="cart-total">
            <div class="cart-total-box">
                <div class="cart-total-row">
                    <span class="cart-total-label">Total :</span>
                    <span class="cart-total-price"><?php echo number_format($cartTotal, 2, ',', ' '); ?> €</span>
                </div>
                <div class="cart-actions">
                    <form action="cart_actions.php" method="POST" id="clearCartForm">
                        <input type="hidden" name="action" value="clear">
                        <button type="submit" class="btn empty-cart-btn">Vider le panier</button>
                    </form>
                    <a href="checkout.php" class="btn">Passer à la caisse</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-cart">
            <p>Votre panier est vide. <a href="index.php">Commencez vos achats</a>.</p>
        </div>
    <?php endif; ?>
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

// Vider le panier
document.getElementById('clearCartForm').addEventListener('submit', function(e) {
    e.preventDefault();

    if (confirm('Êtes-vous sûr de vouloir vider votre panier ?')) {
        fetch('cart_actions.php', {
            method: 'POST',
            body: new URLSearchParams(new FormData(this))
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Le panier a été vidé avec succès.', true);
                window.location.href = 'cart.php'; // Rediriger vers le panier après vidage
            } else {
                showNotification('Erreur lors du vidage du panier.', false);
            }
        })
        .catch(error => {
            showNotification('Une erreur est survenue, veuillez réessayer.', false);
        });
    }
});
</script>

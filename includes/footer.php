</div>
    </main>
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>À propos</h3>
                    <p>Internet Movies DataBase & Co est votre source principale pour découvrir et acheter des films de qualité.</p>
                </div>
                <div class="footer-section">
                    <h3>Catégories</h3>
                    <ul>
                        <?php
                        $categories = getAllCategories();
                        foreach ($categories as $category) {
                            echo '<li><a href="category.php?id=' . $category['id'] . '">' . $category['nom'] . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Liens rapides</h3>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="search.php">Recherche</a></li>
                        <?php if (isLoggedIn()): ?>
                            <li><a href="cart.php">Panier</a></li>
                            <li><a href="profile.php">Profil</a></li>
                        <?php else: ?>
                            <li><a href="login.php">Connexion</a></li>
                            <li><a href="register.php">Inscription</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>Email: contact@imdb-co.com</p>
                    <p>Téléphone: +33 1 23 45 67 89</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> Internet Movies DataBase & Co. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    <script src="assets/js/script.js"></script>
</body>
</html>
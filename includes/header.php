<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' . SITE_NAME : SITE_NAME; ?></title>
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Internet Movies DataBase & Co - Votre source pour tous les films'; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="index.php">
                        <h1><?php echo SITE_NAME; ?></h1>
                    </a>
                </div>
                <div class="search-box">
                    <form action="search.php" method="GET">
                        <input type="text" name="q" placeholder="Rechercher un film ou un réalisateur..." required>
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <nav class="main-nav">
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li class="dropdown">
                            <a href="#">Catégories <i class="fas fa-caret-down"></i></a>
                            <ul class="dropdown-content">
                                <?php
                                require_once 'includes/functions.php';
                                $categories = getAllCategories();
                                foreach ($categories as $category) {
                                    echo '<li><a href="category.php?id=' . $category['id'] . '">' . $category['nom'] . '</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                        <?php if (isLoggedIn()): ?>
                            <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> Panier</a></li>
                            <li><a href="profile.php"><i class="fas fa-user"></i> Profil</a></li>
                            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                        <?php else: ?>
                            <li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Connexion</a></li>
                            <li><a href="register.php"><i class="fas fa-user-plus"></i> Inscription</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <div class="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
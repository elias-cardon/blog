<?php
// Inclure le fichier d'en-tête
include 'backend/partials/header.php';

// Récupérer tous les articles de la table posts, triés par date décroissante
$query = "SELECT * FROM posts ORDER BY date_time DESC";
$posts_stmt = $connection->query($query); // Exécuter la requête
$posts = $posts_stmt->fetchAll(PDO::FETCH_ASSOC); // Récupérer tous les résultats sous forme de tableau associatif
?>

<section class="title_big">
    <h1>Blog</h1>
</section>

<!--==============================BARRE DE RECHERCHE=========================================-->
<section class="search__bar">
    <form action="<?= ROOT_URL ?>search.php" class="container search__bar-container" method="GET">
        <div>
            <i class="uil uil-search"></i>
            <input type="search" name="search" placeholder="Rechercher"> <!-- Champ de recherche -->
        </div>
        <button type="submit" name="submit" class="btn">Chercher</button> <!-- Bouton de soumission -->
    </form>
</section>
<!--==============================FIN DE LA BARRE DE RECHERCHE=========================================-->

<!--===============================ARTICLES=========================================-->
<section class="posts">
    <div class="container normal_post posts__container">
        <?php foreach ($posts as $post) : ?> <!-- Boucle sur chaque article -->
            <article class="post">
                <div class="post__thumbnail">
                    <img src="<?= ROOT_URL ?>frontend/assets/images/<?= $post['thumbnail'] ?>"
                         alt="Image de l'article"> <!-- Afficher la miniature de l'article -->
                </div>
                <div class="post__info">
                    <?php
                    // Récupérer la catégorie de l'article en utilisant category_id
                    $category_id = $post['category_id'];
                    $category_query = "SELECT * FROM categories WHERE id = :category_id";
                    $category_stmt = $connection->prepare($category_query); // Préparer la requête
                    $category_stmt->execute(['category_id' => $category_id]); // Exécuter la requête avec le paramètre
                    $category = $category_stmt->fetch(PDO::FETCH_ASSOC); // Récupérer le résultat
                    ?>
                    <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>"
                       class="category__button"><?= $category['title'] ?></a> <!-- Lien vers la catégorie de l'article -->
                    <h3 class="post__title">
                        <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>">
                            <?= $post['title'] ?> <!-- Titre de l'article -->
                        </a>
                    </h3>
                    <p class="post__body">
                        <?= substr($post['body'], 0, 150) ?>... <!-- Extrait du corps de l'article -->
                    </p>
                    <div class="post__author">
                        <?php
                        // Récupérer l'auteur de l'article en utilisant author_id
                        $author_id = $post['author_id'];
                        $author_query = "SELECT * FROM users WHERE id = :author_id";
                        $author_stmt = $connection->prepare($author_query); // Préparer la requête
                        $author_stmt->execute(['author_id' => $author_id]); // Exécuter la requête avec le paramètre
                        $author = $author_stmt->fetch(PDO::FETCH_ASSOC); // Récupérer le résultat
                        ?>
                        <div class="post__author-avatar">
                            <img src="frontend/assets/images/<?= $author['avatar'] ?>"
                                 alt="Avatar de l'auteur de l'article"> <!-- Afficher l'avatar de l'auteur -->
                        </div>
                        <div class="post__author-info">
                            <h5>Par : <?= "{$author['username']}" ?></h5> <!-- Nom de l'auteur -->
                            <small><?= date("d M Y - H:i", strtotime($post['date_time'])) ?></small> <!-- Date de publication -->
                        </div>
                    </div>
                </div>
            </article>
        <?php endforeach; ?> <!-- Fin de la boucle sur les articles -->
    </div>
</section>
<!--==============================FIN DES ARTICLES=========================================-->
<!--==============================LISTE DES CATÉGORIES=========================================-->
<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
        // Récupérer toutes les catégories de la table categories
        $all_categories_query = "SELECT * FROM categories";
        $all_categories_stmt = $connection->query($all_categories_query); // Exécuter la requête
        $all_categories = $all_categories_stmt->fetchAll(PDO::FETCH_ASSOC); // Récupérer tous les résultats sous forme de tableau associatif
        ?>
        <?php foreach ($all_categories as $category) : ?> <!-- Boucle sur chaque catégorie -->
            <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>"
               class="category__button"><?= $category['title'] ?></a> <!-- Lien vers la catégorie -->
        <?php endforeach; ?> <!-- Fin de la boucle sur les catégories -->
    </div>
</section>
<!--==============================FIN DE LA LISTE DES CATÉGORIES=========================================-->
<?php
// Inclure le fichier de pied de page
include 'backend/partials/footer.php';
?>
<script src="frontend/assets/main.js"></script> <!-- Inclure le fichier JavaScript principal -->
</body>
</html>

<?php
// Inclure le fichier d'en-tête
require 'backend/partials/header.php';

if (isset($_GET['search']) && isset($_GET['submit'])) {
    // Filtrer et sécuriser la chaîne de recherche
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Requête pour récupérer les articles correspondant à la recherche
    $query = "SELECT * FROM posts WHERE title LIKE :search ORDER BY date_time DESC";
    $stmt = $connection->prepare($query); // Préparer la requête
    $stmt->execute(['search' => "%$search%"]); // Exécuter la requête avec le paramètre
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupérer tous les résultats sous forme de tableau associatif
} else {
    // Rediriger vers la page blog si aucun terme de recherche n'est défini
    header('Location: ' . ROOT_URL . 'blog.php');
    die(); // Arrêter l'exécution du script
}
?>

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

<?php if (count($posts) > 0) : ?> <!-- Vérifier s'il y a des articles correspondant à la recherche -->
    <section class="posts section__extra-margin">
        <div class="container posts__container">
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
<?php else: ?> <!-- Si aucun article n'est trouvé -->
    <div class="alert__message error lg">
        <p>Aucun article ne porte ce nom.</p>
    </div>
<?php endif; ?>

<!--==============================LISTE DES CATÉGORIES=========================================-->
<section class="category__buttons">
    <div class="container category__buttons-container section__extra-margin">
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

<?php include 'backend/partials/footer.php' ?> <!-- Inclure le fichier de pied de page -->
<script src="frontend/assets/main.js"></script> <!-- Inclure le fichier JavaScript principal -->
</body>
</html>

<!doctype html>
<?php
// Inclure le fichier d'en-tête
include 'backend/partials/header.php';

// Vérifier si l'ID de la catégorie est défini dans l'URL
if (isset($_GET['id'])) {
    // Filtrer et valider l'ID de la catégorie
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Préparer la requête pour récupérer les articles de la catégorie spécifiée, triés par date décroissante
    $query = "SELECT * FROM posts WHERE category_id = :id ORDER BY date_time DESC";
    $posts_stmt = $connection->prepare($query); // Préparer la requête
    $posts_stmt->execute(['id' => $id]); // Exécuter la requête avec le paramètre
    $posts = $posts_stmt->fetchAll(PDO::FETCH_ASSOC); // Récupérer tous les résultats sous forme de tableau associatif
} else {
    // Rediriger vers la page blog si aucun ID n'est défini
    header('Location: ' . ROOT_URL . 'blog.php');
    die(); // Arrêter l'exécution du script
}
?>

<header class="category__title">
    <h2>
        <?php
        // Préparer la requête pour récupérer les informations de la catégorie
        $category_query = "SELECT * FROM categories WHERE id = :id";
        $category_stmt = $connection->prepare($category_query); // Préparer la requête
        $category_stmt->execute(['id' => $id]); // Exécuter la requête avec le paramètre
        $category = $category_stmt->fetch(PDO::FETCH_ASSOC); // Récupérer le résultat
        echo $category['title']; // Afficher le titre de la catégorie
        ?>
    </h2>
</header>
<!--===============================ARTICLES=========================================-->
<?php if (count($posts) > 0) : ?> <!-- Vérifier s'il y a des articles dans la catégorie -->
    <section class="posts">
        <div class="container posts__container">
            <?php foreach ($posts as $post) : ?> <!-- Boucle sur chaque article -->
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="<?= ROOT_URL ?>frontend/assets/images/<?= $post['thumbnail'] ?>"
                             alt="Image de l'article"> <!-- Afficher la miniature de l'article -->
                    </div>
                    <div class="post__info">
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
                            // Préparer la requête pour récupérer les informations de l'auteur
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
        <p>Aucun article disponible dans cette catégorie.</p>
    </div>
<?php endif; ?>
<!--==============================FIN DES ARTICLES=========================================-->
<!--==============================LISTE DES CATÉGORIES=========================================-->
<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
        // Préparer la requête pour récupérer toutes les catégories
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

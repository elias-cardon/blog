<?php
require 'backend/partials/header.php';

if (isset($_GET['search']) && isset($_GET['submit'])) {
    // Filtrer et sécuriser la chaîne de recherche
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // Requête pour récupérer les articles correspondant à la recherche
    $query = "SELECT * FROM posts WHERE title LIKE :search ORDER BY date_time DESC";
    $stmt = $connection->prepare($query);
    $stmt->execute(['search' => "%$search%"]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Rediriger vers la page blog si aucun terme de recherche n'est défini
    header('Location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

<!--==============================BARRE DE RECHERCHE=========================================-->
<section class="search__bar">
    <form action="<?= ROOT_URL ?>search.php" class="container search__bar-container" method="GET">
        <div>
            <i class="uil uil-search"></i>
            <input type="search" name="search" placeholder="Rechercher">
        </div>
        <button type="submit" name="submit" class="btn">Chercher</button>
    </form>
</section>
<!--==============================FIN DE LA BARRE DE RECHERCHE=========================================-->
<?php if (count($posts) > 0) : ?>
    <section class="posts section__extra-margin">
        <div class="container posts__container">
            <?php foreach ($posts as $post) : ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="<?= ROOT_URL ?>frontend/assets/images/<?= $post['thumbnail'] ?>"
                             alt="Image de l'article">
                    </div>
                    <div class="post__info">
                        <?php
                        // Récupérer la catégorie de l'article en utilisant category_id
                        $category_id = $post['category_id'];
                        $category_query = "SELECT * FROM categories WHERE id = :category_id";
                        $category_stmt = $connection->prepare($category_query);
                        $category_stmt->execute(['category_id' => $category_id]);
                        $category = $category_stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>"
                           class="category__button"><?= $category['title'] ?></a>
                        <h3 class="post__title">
                            <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>">
                                <?= $post['title'] ?>
                            </a>
                        </h3>
                        <p class="post__body">
                            <?= substr($post['body'], 0, 150) ?>...
                        </p>
                        <div class="post__author">
                            <?php
                            // Récupérer l'auteur de l'article en utilisant author_id
                            $author_id = $post['author_id'];
                            $author_query = "SELECT * FROM users WHERE id = :author_id";
                            $author_stmt = $connection->prepare($author_query);
                            $author_stmt->execute(['author_id' => $author_id]);
                            $author = $author_stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <div class="post__author-avatar">
                                <img src="frontend/assets/images/<?= $author['avatar'] ?>"
                                     alt="Avatar de l'auteur de l'article">
                            </div>
                            <div class="post__author-info">
                                <h5>Par : <?= "{$author['username']}" ?></h5>
                                <small><?= date("d M Y - H:i", strtotime($post['date_time'])) ?></small>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
<?php else: ?>
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
        $all_categories_stmt = $connection->query($all_categories_query);
        $all_categories = $all_categories_stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <?php foreach ($all_categories as $category) : ?>
            <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>"
               class="category__button"><?= $category['title'] ?></a>
        <?php endforeach; ?>
    </div>
</section>
<!--==============================FIN DE LA LISTE DES CATÉGORIES=========================================-->

<?php include 'backend/partials/footer.php' ?>

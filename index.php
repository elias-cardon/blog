<?php
include 'backend/partials/header.php';

// Fetch featured post from database
$_featured_query = "SELECT * FROM posts WHERE is_featured = 1";
$_featured_stmt = $connection->query($_featured_query);
$featured = $_featured_stmt->fetch(PDO::FETCH_ASSOC);

// Fetch 9 posts from posts table
$query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
$posts_stmt = $connection->query($query);
$posts = $posts_stmt->fetchAll(PDO::FETCH_ASSOC);
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

<!-- Montre l'article A la Une s'il y en a un -->
<?php if ($featured) : ?>
    <!--==============================FEATURED POST=========================================-->
    <section class="featured">
        <div class="container featured__container">
            <div class="post__thumbnail">
                <img src="frontend/assets/images/<?= $featured['thumbnail'] ?>" alt="Image du blog1">
            </div>
            <div class="post__info">
                <?php
                // Fetch category from categories table using category_id of post
                $category_id = $featured['category_id'];
                $category_query = "SELECT * FROM categories WHERE id = :category_id";
                $category_stmt = $connection->prepare($category_query);
                $category_stmt->execute(['category_id' => $category_id]);
                $category = $category_stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <a href="<?= ROOT_URL ?>category-post.php?id=<?= $featured['category_id'] ?>"
                   class="category__button"><?= $category['title'] ?></a>
                <h2 class="post__title"><a
                            href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?= $featured['title'] ?></a>
                </h2>
                <p class="post__body">
                    <?= htmlspecialchars_decode(substr($featured['body'], 0, 300)) ?>...
                </p>
                <div class="post__author">
                    <?php
                    // Fetch author from users table using author_id
                    $author_id = $featured['author_id'];
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
                        <small>
                            <?= date("d M Y - H:i", strtotime($featured['date_time'])) ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!--==============================END OF FEATURED POST=========================================-->
<!--===============================NORMAL POST=========================================-->
<section class="posts <?= $featured ? '' : 'section__extra-margin' ?>">
    <div class="container posts__container">
        <?php foreach ($posts as $post) : ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="<?= ROOT_URL ?>frontend/assets/images/<?= $post['thumbnail'] ?>"
                         alt="Image de l'article">
                </div>
                <div class="post__info">
                    <?php
                    // Fetch category from categories table using category_id of post
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
                        <?= htmlspecialchars_decode(substr($post['body'], 0, 150)) ?>...
                    </p>
                    <div class="post__author">
                        <?php
                        // Fetch author from users table using author_id
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
<!--==============================END POST=========================================-->
<!--==============================LIST CATEGORIES=========================================-->
<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
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
<!--==============================END LIST CATEGORIES=========================================-->
<?php
include 'backend/partials/footer.php';
?>
<script src="frontend/assets/main.js"></script>
</body>
</html>

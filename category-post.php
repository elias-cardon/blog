<!doctype html>
<?php
include 'backend/partials/header.php';

//fetch post if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE category_id = :id ORDER BY date_time DESC";
    $posts_stmt = $connection->prepare($query);
    $posts_stmt->execute(['id' => $id]);
    $posts = $posts_stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header('Location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

<header class="category__title">
    <h2>
        <?php
        //fetch category from categories table using category_id of post
        $category_query = "SELECT * FROM categories WHERE id = :id";
        $category_stmt = $connection->prepare($category_query);
        $category_stmt->execute(['id' => $id]);
        $category = $category_stmt->fetch(PDO::FETCH_ASSOC);
        echo $category['title'];
        ?>
    </h2>
</header>
<!--===============================POST=========================================-->
<?php if (count($posts) > 0) : ?>
    <section class="posts">
        <div class="container posts__container">
            <?php foreach ($posts as $post) : ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="<?= ROOT_URL ?>frontend/assets/images/<?= $post['thumbnail'] ?>"
                             alt="Image de l'article">
                    </div>
                    <div class="post__info">
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
                            //fetch author from users table using author_id
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
        <p>Aucun article disponible dans cette catégorie.</p>
    </div>
<?php endif; ?>
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

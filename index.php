<?php
include 'backend/partials/header.php';

//fetch featured post from database
$_featured_query = "SELECT * FROM `posts` WHERE is_featured = 1";
$_featured_result = mysqli_query($connection, $_featured_query);
$featured = mysqli_fetch_assoc($_featured_result);

//fetch 9 posts from posts table
$query = "SELECT * FROM `posts` ORDER BY date_time DESC LIMIT 9";
$posts = mysqli_query($connection, $query);
?>

<!-- Montre l'article A la Une s'il y en a un -->
<?php if (mysqli_num_rows($_featured_result) == 1) : ?>
    <!--==============================FEATURED POST=========================================-->
    <section class="featured">
        <div class="container featured__container">
            <div class="post__thumbnail">
                <img src="frontend/assets/images/<?= $featured['thumbnail'] ?>" alt="Image du blog1">
            </div>
            <div class="post__info">
                <?php
                //fetch category from categories table using category_id of post
                $category_id = $featured['category_id'];
                $category_query = "SELECT * FROM categories WHERE id = '$category_id'";
                $category_result = mysqli_query($connection, $category_query);
                $category = mysqli_fetch_assoc($category_result);
                ?>
                <a href="<?= ROOT_URL ?>category-post.php?id=<?= $featured['category_id'] ?>"
                   class="category__button"><?= $category['title'] ?></a>
                <h2 class="post__title"><a
                            href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?= $featured['title'] ?></a>
                </h2>
                <p class="post__body">
                    <?= substr($featured['body'], 0, 300) ?>...
                </p>
                <div class="post__author">
                    <?php
                    //fetch author from users table using author_id
                    $author_id = $featured['author_id'];
                    $author_query = "SELECT * FROM users WHERE id = '$author_id'";
                    $author_result = mysqli_query($connection, $author_query);
                    $author = mysqli_fetch_assoc($author_result);
                    ?>
                    <div class="post__author-avatar">
                        <img src="frontend/assets/images/<?= $author['avatar'] ?>"
                             alt="Avatar de l'auteur de l'article">
                    </div>
                    <div class="post__author-info">
                        <h5>Par : <?= $author['username'] ?></h5>
                        <small>
                            <?= date("d M Y - H:i", strtotime($featured['date_time'])) ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================END OF FEATURED POST=========================================-->
    <!--===============================NORMAL POST=========================================-->
    <section class="posts">
        <div class="container posts__container">
            <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="<?= ROOT_URL ?>frontend/assets/images/<?= $post['thumbnail'] ?>"
                             alt="Image de l'article">
                    </div>
                    <div class="post__info">
                        <?php
                        //fetch category from categories table using category_id of post
                        $category_id = $featured['category_id'];
                        $category_query = "SELECT * FROM categories WHERE id = '$category_id'";
                        $category_result = mysqli_query($connection, $category_query);
                        $category = mysqli_fetch_assoc($category_result);
                        ?>
                        <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>"
                           class="category__button"><?= $category['title'] ?></a>
                        <h3 class="post__title">
                            <a href="post.php">
                                <?= $post['title'] ?>
                            </a>
                        </h3>
                        <p class="post__body">
                            <?= substr($post['body'], 0, 300) ?>...
                        </p>
                        <div class="post__author">
                            <div class="post__author-avatar">
                                <img src="frontend/assets/images/<?= $author['avatar'] ?>"
                                     alt="Avatar de l'auteur de l'article">
                            </div>
                            <div class="post__author-info">
                                <h5>Par : <?= $author['username'] ?></h5>
                                <?= date("d M Y - H:i", strtotime($featured['date_time'])) ?>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </section>
<?php endif; ?>
<!--==============================END POST=========================================-->
<!--==============================LIST CATEGORIES=========================================-->
<section class="category__buttons">
    <div class="container category__buttons-container">
        <a href="" class="category__button">Art</a>
        <a href="" class="category__button">Wild Life</a>
        <a href="" class="category__button">Travel</a>
        <a href="" class="category__button">Science & Technologie</a>
        <a href="" class="category__button">Musique</a>
        <a href="" class="category__button">Nourriture</a>
    </div>
</section>
<!--==============================END LIST CATEGORIES=========================================-->
<?php
include 'backend/partials/footer.php';
?>
<script src="frontend/assets/main.js"></script>
</body>
</html>
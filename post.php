<?php
include 'backend/partials/header.php';

//fetch post from database if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->execute(['id' => $id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header('Location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

<!--==============================POST=========================================-->
<section class="singlepost">
    <div class="container singlepost__container">
        <h2><?= $post['title'] ?></h2>
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
        <div class="singlepost__thumbnail">
            <img src="frontend/assets/images/<?= $post['thumbnail'] ?>" alt="Image du post">
        </div>
        <p>
            <?= $post['body'] ?>
        </p>
    </div>
</section>
<!--==============================END POST=========================================-->

<?php
include 'backend/partials/footer.php';
?>
<script src="frontend/assets/main.js"></script>
</body>
</html>

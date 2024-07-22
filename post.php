<?php
include 'backend/partials/header.php';

// Récupérer l'article de la base de données si l'id est défini
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->execute(['id' => $id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Rediriger vers la page blog si aucun id n'est défini
    header('Location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

<!--==============================ARTICLE=========================================-->
<section class="singlepost">
    <div class="container singlepost__container">
        <h2><?= htmlspecialchars($post['title']) ?></h2>
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
                <img src="frontend/assets/images/<?= htmlspecialchars($author['avatar']) ?>"
                     alt="Avatar de l'auteur de l'article">
            </div>
            <div class="post__author-info">
                <h5>Par : <?= htmlspecialchars($author['username']) ?></h5>
                <small><?= date("d M Y - H:i", strtotime($post['date_time'])) ?></small>
            </div>
        </div>
        <div class="singlepost__thumbnail">
            <img src="frontend/assets/images/<?= htmlspecialchars($post['thumbnail']) ?>" alt="Image du post">
        </div>
        <div class="singlepost__content">
            <?= htmlspecialchars_decode($post['body']) ?>
        </div>
    </div>
</section>
<!--==============================FIN DE L'ARTICLE=========================================-->

<?php
include 'backend/partials/footer.php';
?>
<script src="frontend/assets/main.js"></script>
</body>
</html>

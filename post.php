<?php
// Inclure le fichier d'en-tête
include 'backend/partials/header.php';

// Récupérer l'article de la base de données si l'id est défini
if (isset($_GET['id'])) {
    // Filtrer et valider l'ID de l'article
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Préparer la requête pour récupérer l'article spécifié par l'ID
    $query = "SELECT * FROM posts WHERE id = :id";
    $stmt = $connection->prepare($query); // Préparer la requête
    $stmt->execute(['id' => $id]); // Exécuter la requête avec le paramètre
    $post = $stmt->fetch(PDO::FETCH_ASSOC); // Récupérer le résultat
} else {
    // Rediriger vers la page blog si aucun ID n'est défini
    header('Location: ' . ROOT_URL . 'blog.php');
    die(); // Arrêter l'exécution du script
}
?>

<!--==============================ARTICLE=========================================-->
<section class="singlepost">
    <div class="container singlepost__container">
        <h2><?= htmlspecialchars($post['title']) ?></h2> <!-- Afficher le titre de l'article -->
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
                <img src="frontend/assets/images/<?= htmlspecialchars($author['avatar']) ?>"
                     alt="Avatar de l'auteur de l'article"> <!-- Afficher l'avatar de l'auteur -->
            </div>
            <div class="post__author-info">
                <h5>Par : <?= htmlspecialchars($author['username']) ?></h5> <!-- Nom de l'auteur -->
                <small><?= date("d M Y - H:i", strtotime($post['date_time'])) ?></small> <!-- Date de publication -->
            </div>
        </div>
        <div class="singlepost__thumbnail">
            <img src="frontend/assets/images/<?= htmlspecialchars($post['thumbnail']) ?>" alt="Image du post"> <!-- Afficher la miniature de l'article -->
        </div>
        <div class="singlepost__content">
            <?= htmlspecialchars_decode($post['body']) ?> <!-- Afficher le contenu de l'article -->
        </div>
    </div>
</section>
<!--==============================FIN DE L'ARTICLE=========================================-->

<?php
// Inclure le fichier de pied de page
include 'backend/partials/footer.php';
?>
<script src="frontend/assets/main.js"></script> <!-- Inclure le fichier JavaScript principal -->
</body>
</html>

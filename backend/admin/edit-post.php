<?php
// Inclure le fichier de l'en-tête
require './partials/header.php';

// Récupérer les catégories de la base de données
$category_query = "SELECT * FROM categories";
$stmt = $connection->query($category_query);
// Récupérer toutes les catégories sous forme de tableau associatif
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les données de l'article de la base de données si l'ID est défini
if (isset($_GET['id'])) {
    // Assainir l'ID pour éviter les injections de code
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Rediriger si l'article n'existe pas
    if (!$post) {
        header('Location: ' . ROOT_URL . 'backend/admin/');
        die();
    }
} else {
    // Rediriger si l'ID de l'article n'est pas fourni
    header('Location: ' . ROOT_URL . 'backend/admin/');
    die();
}
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Modifier l'article</h2>
        <!-- Formulaire pour modifier l'article -->
        <form action="<?= ROOT_URL ?>backend/admin/edit-post-logic.php" method="POST" enctype="multipart/form-data">
            <!-- Champ caché pour l'ID de l'article -->
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <!-- Champ caché pour le nom de la miniature précédente -->
            <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>">
            <!-- Champ pour le titre de l'article -->
            <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" placeholder="Titre de l'article">
            <!-- Liste déroulante pour sélectionner la catégorie de l'article -->
            <select name="category">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $post['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($category['title']) ?></option>
                <?php endforeach; ?>
            </select>
            <!-- Champ pour le texte de l'article -->
            <textarea id="editor" rows="10" name="body" placeholder="Texte de l'article"><?= htmlspecialchars($post['body']) ?></textarea>
            <!-- Option pour mettre l'article à la Une -->
            <div class="form__control inline">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" <?= $post['is_featured'] ? 'checked' : '' ?>>
                <label for="is_featured">A la Une</label>
            </div>
            <!-- Champ pour modifier la miniature -->
            <div class="form__control">
                <label for="thumbnail">Modifier la miniature</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <!-- Bouton pour soumettre le formulaire -->
            <button type="submit" name="submit" class="btn">Modifier l'article</button>
        </form>
    </div>
</section>
<!-- Script pour initialiser l'éditeur de texte TinyMCE -->
<script src="https://cdn.tiny.cloud/1/14atl2lzsnthvqxbgqk17092nkns5qm2g6sqtwx54mr39r8w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#editor'
    });
</script>
<?php
// Inclure le fichier du pied de page
require '../partials/footer.php';
?>
</body>
</html>

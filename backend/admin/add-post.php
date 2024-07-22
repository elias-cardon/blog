<?php
// Inclure le fichier de l'en-tête
require 'partials/header.php';

// Récupérer les catégories de la base de données
$query = "SELECT * FROM categories";
$stmt = $connection->query($query);
// Récupérer toutes les catégories sous forme de tableau associatif
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les données du formulaire si elles sont invalides
// Si les données existent dans la session, les assigner aux variables $title et $body
// Sinon, assigner des chaînes vides
$title = $_SESSION['add-post-data']['title'] ?? '';
$body = $_SESSION['add-post-data']['body'] ?? '';

// Supprimer les données de session après les avoir récupérées
unset($_SESSION['add-post-data']);
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Ajout d'article</h2>
        <?php
        // Vérifier s'il y a un message d'erreur dans la session
        if (isset($_SESSION['add-post'])) : ?>
            <div class="alert__message error">
                <p>
                    <?php
                    // Afficher le message d'erreur et le supprimer de la session
                    echo $_SESSION['add-post'];
                    unset($_SESSION['add-post']);
                    ?>
                </p>
            </div>
        <?php endif; ?>
        <!-- Formulaire pour ajouter un nouvel article -->
        <form action="<?= ROOT_URL ?>backend/admin/add-post-logic.php" method="POST" enctype="multipart/form-data">
            <!-- Champ pour le titre de l'article -->
            <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" placeholder="Titre de l'article">
            <!-- Liste déroulante pour sélectionner la catégorie de l'article -->
            <select name="category">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                <?php endforeach; ?>
            </select>
            <!-- Champ pour le texte de l'article -->
            <textarea id="editor" rows="10" name="body" placeholder="Texte de l'article"><?= htmlspecialchars($body) ?></textarea>
            <?php
            // Si l'utilisateur est un administrateur, afficher l'option "A la Une"
            if (isset($_SESSION['user_is_admin'])) : ?>
                <div class="form__control inline">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured" checked>
                    <label for="is_featured">A la Une</label>
                </div>
            <?php endif; ?>
            <!-- Champ pour ajouter une miniature -->
            <div class="form__control">
                <label for="thumbnail">Ajouter une miniature</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <!-- Bouton pour soumettre le formulaire -->
            <button type="submit" name="submit" class="btn">Ajouter l'article</button>
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

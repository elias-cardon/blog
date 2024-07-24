<?php
require 'partials/header.php';

// Fetch categories from database
$query = "SELECT * FROM categories";
$stmt = $connection->query($query);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get back form data if form was invalid
$title = $_SESSION['add-post-data']['title'] ?? '';
$body = $_SESSION['add-post-data']['body'] ?? '';

// Delete form data session
unset($_SESSION['add-post-data']);
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Ajout d'article</h2>
        <?php if (isset($_SESSION['add-post'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['add-post'];
                    unset($_SESSION['add-post']) ?>
                </p>
            </div>
        <?php endif; ?>
        <form action="<?= ROOT_URL ?>backend/admin/add-post-logic.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" placeholder="Titre de l'article">
            <select name="category">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                <?php endforeach; ?>
            </select>
            <textarea id="editor" rows="10" name="body" placeholder="Texte de l'article"><?= htmlspecialchars($body) ?></textarea>
            <?php if (isset($_SESSION['user_is_admin'])) : ?>
                <div class="form__control inline">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured" checked>
                    <label for="is_featured">A la Une</label>
                </div>
            <?php endif; ?>
            <div class="form__control">
                <label for="thumbnail">Ajouter une miniature</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn">Ajouter l'article</button>
        </form>
    </div>
</section>
<script src="https://cdn.tiny.cloud/1/14atl2lzsnthvqxbgqk17092nkns5qm2g6sqtwx54mr39r8w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script><script> tinymce.init({ selector: '#editor' }); </script>
<?php
require '../partials/footer.php';
?>
</body>
</html>
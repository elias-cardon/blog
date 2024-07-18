<?php
require './partials/header.php';

// Fetch categories from database
$category_query = "SELECT * FROM categories";
$stmt = $connection->query($category_query);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch post data from database if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        header('Location: ' . ROOT_URL . 'backend/admin/');
        die();
    }
} else {
    header('Location: ' . ROOT_URL . 'backend/admin/');
    die();
}
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Modifier d'article</h2>
        <form action="<?= ROOT_URL ?>backend/admin/edit-post-logic.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>">
            <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" placeholder="Titre de l'article">
            <select name="category">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $post['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($category['title']) ?></option>
                <?php endforeach; ?>
            </select>
            <textarea id="editor" rows="10" name="body" placeholder="Texte de l'article"><?= htmlspecialchars($post['body']) ?></textarea>
            <div class="form__control inline">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" <?= $post['is_featured'] ? 'checked' : '' ?>>
                <label for="is_featured">A la Une</label>
            </div>
            <div class="form__control">
                <label for="thumbnail">Modifier la miniature</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn">Modifier l'article</button>
        </form>
    </div>
</section>
<script src="https://cdn.tiny.cloud/1/14atl2lzsnthvqxbgqk17092nkns5qm2g6sqtwx54mr39r8w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#editor'
    });
</script>
<?php
require '../partials/footer.php';
?>
</body>
</html>

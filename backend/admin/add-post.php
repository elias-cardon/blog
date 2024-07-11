<?php
require 'partials/header.php';

//Fetch categories from database
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Ajout d'article</h2>
        <div class="alert__message error">
            <p>C'est un message d'erreur.</p>
        </div>
        <form action="<?= ROOT_URL ?>backend/admin/add-post-logic.php" method="POST">
            <input type="text" name="title" placeholder="Titre de l'article">
            <select name="category">
                <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                <?php endwhile; ?>
            </select>
            <textarea rows="10" name="body" placeholder="Texte de l'article"></textarea>
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
<?php
require '../partials/footer.php';
?>
</body>
</html>
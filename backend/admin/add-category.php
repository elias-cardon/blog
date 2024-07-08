<?php
require 'partials/header.php';

//get back form data if invalid
$title = $_SESSION['add-category-data']['title'] ?? null;
$description = $_SESSION['add-category-data']['description'] ?? null;

unset($_SESSION['add-category-data']);
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Ajout de catégorie</h2>
        <?php if (isset($_SESSION['add-category'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['add-category'];
                    unset($_SESSION['add-category'])?>
                </p>
            </div>
        <?php endif; ?>
        <form action="<?= ROOT_URL ?>backend/admin/add-category-logic.php" method="POST">
            <input type="text" value="<?php $title ?>" name="title" placeholder="Nom de la catégorie">
            <textarea rows="4" value="<?php $description ?>" name="description" placeholder="Description"></textarea>
            <button type="submit" name="submit" class="btn">Ajouter catégorie</button>
        </form>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
</body>
</html>
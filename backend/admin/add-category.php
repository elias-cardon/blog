<?php
require 'partials/header.php';

// Récupérer les données du formulaire si elles sont invalides
$title = $_SESSION['add-category-data']['title'] ?? '';
$description = $_SESSION['add-category-data']['description'] ?? '';

// Supprimer les données de session après les avoir récupérées
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
                    unset($_SESSION['add-category']) ?>
                </p>
            </div>
        <?php endif; ?>
        <form action="<?= ROOT_URL ?>backend/admin/add-category-logic.php" method="POST">
            <input type="text" value="<?= htmlspecialchars($title) ?>" name="title" placeholder="Nom de la catégorie">
            <textarea rows="4" name="description" placeholder="Description"><?= htmlspecialchars($description) ?></textarea>
            <button type="submit" name="submit" class="btn">Ajouter catégorie</button>
        </form>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
</body>
</html>

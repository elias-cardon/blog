<?php
require 'partials/header.php';
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Ajout de catégorie</h2>
        <div class="alert__message error">
            <p>C'est un message d'erreur.</p>
        </div>
        <form action="<?= ROOT_URL ?>backend/admin/add-category-logic.php" method="POST">
            <input type="text" name="title" placeholder="Nom de la catégorie">
            <textarea rows="4" name="description" placeholder="Description"></textarea>
            <button type="submit" name="submit" class="btn">Ajouter catégorie</button>
        </form>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
</body>
</html>
<?php
// Inclure le fichier de l'en-tête
require 'partials/header.php';

// Récupérer les données du formulaire si elles sont invalides
// Si les données existent dans la session, les assigner aux variables $title et $description
// Sinon, assigner des chaînes vides
$title = $_SESSION['add-category-data']['title'] ?? '';
$description = $_SESSION['add-category-data']['description'] ?? '';

// Supprimer les données de session après les avoir récupérées
unset($_SESSION['add-category-data']);
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Ajout de catégorie</h2>
        <?php
        // Vérifier s'il y a un message d'erreur dans la session
        if (isset($_SESSION['add-category'])) : ?>
            <div class="alert__message error">
                <p>
                    <?php
                    // Afficher le message d'erreur et le supprimer de la session
                    echo $_SESSION['add-category'];
                    unset($_SESSION['add-category']);
                    ?>
                </p>
            </div>
        <?php endif; ?>
        <!-- Formulaire pour ajouter une nouvelle catégorie -->
        <form action="<?= ROOT_URL ?>backend/admin/add-category-logic.php" method="POST">
            <!-- Champ pour le nom de la catégorie -->
            <input type="text" value="<?= htmlspecialchars($title) ?>" name="title" placeholder="Nom de la catégorie">
            <!-- Champ pour la description de la catégorie -->
            <textarea rows="4" name="description" placeholder="Description"><?= htmlspecialchars($description) ?></textarea>
            <!-- Bouton pour soumettre le formulaire -->
            <button type="submit" name="submit" class="btn">Ajouter catégorie</button>
        </form>
    </div>
</section>
<?php
// Inclure le fichier du pied de page
require '../partials/footer.php';
?>
</body>
</html>

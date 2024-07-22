<?php
// Inclure le fichier de l'en-tête
require './partials/header.php';

// Vérifier si l'ID de la catégorie est fourni dans l'URL
if (isset($_GET['id'])) {
    // Assainir l'ID pour éviter les injections de code
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Récupérer la catégorie de la base de données
    $query = "SELECT * FROM categories WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->execute(['id' => $id]);

    // S'assurer qu'une seule catégorie a été récupérée
    if ($stmt->rowCount() == 1) {
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} else {
    // Rediriger si l'ID de la catégorie n'est pas fourni
    header('Location: ' . ROOT_URL . 'backend/admin/manage-category.php');
    die();
}
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Modifier la catégorie</h2>
        <!-- Formulaire pour modifier la catégorie -->
        <form action="<?= ROOT_URL ?>backend/admin/edit-category-logic.php" method="POST">
            <!-- Champ caché pour l'ID de la catégorie -->
            <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">
            <!-- Champ pour le nom de la catégorie -->
            <input type="text" name="title" value="<?= htmlspecialchars($category['title']) ?>" placeholder="Nom de la catégorie">
            <!-- Champ pour la description de la catégorie -->
            <textarea rows="4" name="description" placeholder="Description"><?= htmlspecialchars($category['description']) ?></textarea>
            <!-- Bouton pour soumettre le formulaire -->
            <button type="submit" name="submit" class="btn">Modifier la catégorie</button>
        </form>
    </div>
</section>
<?php
// Inclure le fichier du pied de page
require '../partials/footer.php';
?>
</body>
</html>

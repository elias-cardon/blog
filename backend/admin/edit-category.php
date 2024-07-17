<?php
require './partials/header.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //fetch category from database
    $query = "SELECT * FROM categories WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->execute(['id' => $id]);
    if ($stmt->rowCount() == 1) {
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header('Location: ' . ROOT_URL . 'backend/admin/manage-category.php');
    die();
}
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Modifier la catégorie</h2>
        <form action="<?= ROOT_URL ?>backend/admin/edit-category-logic.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">
            <input type="text" name="title" value="<?= htmlspecialchars($category['title']) ?>" placeholder="Nom de la catégorie">
            <textarea rows="4" name="description" placeholder="Description"><?= htmlspecialchars($category['description']) ?></textarea>
            <button type="submit" name="submit" class="btn">Modifier la catégorie</button>
        </form>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
</body>
</html>

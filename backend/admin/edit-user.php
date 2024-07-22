<?php
require './partials/header.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    // Récupère l'utilisateur de la base de données
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Redirige si l'utilisateur n'existe pas
    if (!$user) {
        header('Location: ' . ROOT_URL . 'backend/admin/manage-user.php');
        die();
    }
} else {
    // Redirige si l'ID de l'utilisateur n'est pas fourni
    header('Location: ' . ROOT_URL . 'backend/admin/manage-user.php');
    die();
}
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Modifier l'utilisateur</h2>
        <form action="<?= ROOT_URL ?>/backend/admin/edit-user-logic.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="<?= htmlspecialchars($user['id']) ?>" name="id">
            <input type="text" value="<?= htmlspecialchars($user['firstname']) ?>" name="firstname" placeholder="Prénom">
            <input type="text" value="<?= htmlspecialchars($user['lastname']) ?>" name="lastname" placeholder="Nom de famille">
            <input type="password" name="password" placeholder="Nouveau mot de passe (laisser vide pour ne pas changer)">
            <div class="form__control">
                <label for="avatar">Modifier l'avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <select name="userrole">
                <option value="0" <?= $user['is_admin'] == 0 ? 'selected' : '' ?>>Auteur</option>
                <option value="1" <?= $user['is_admin'] == 1 ? 'selected' : '' ?>>Admin</option>
            </select>
            <button type="submit" name="submit" class="btn">Modifier l'utilisateur</button>
        </form>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
</body>
</html>

<?php
// Inclure le fichier de l'en-tête
require './partials/header.php';

// Vérifier si l'ID de l'utilisateur est fourni dans l'URL
if (isset($_GET['id'])) {
    // Assainir l'ID pour éviter les injections de code
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    // Récupérer l'utilisateur de la base de données
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Rediriger si l'utilisateur n'existe pas
    if (!$user) {
        header('Location: ' . ROOT_URL . 'backend/admin/manage-user.php');
        die();
    }
} else {
    // Rediriger si l'ID de l'utilisateur n'est pas fourni
    header('Location: ' . ROOT_URL . 'backend/admin/manage-user.php');
    die();
}
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Modifier l'utilisateur</h2>
        <!-- Formulaire pour modifier l'utilisateur -->
        <form action="<?= ROOT_URL ?>/backend/admin/edit-user-logic.php" method="POST" enctype="multipart/form-data">
            <!-- Champ caché pour l'ID de l'utilisateur -->
            <input type="hidden" value="<?= htmlspecialchars($user['id']) ?>" name="id">
            <!-- Champ pour le prénom -->
            <input type="text" value="<?= htmlspecialchars($user['firstname']) ?>" name="firstname" placeholder="Prénom">
            <!-- Champ pour le nom de famille -->
            <input type="text" value="<?= htmlspecialchars($user['lastname']) ?>" name="lastname" placeholder="Nom de famille">
            <!-- Champ pour le nouveau mot de passe (laisser vide pour ne pas changer) -->
            <input type="password" name="password" placeholder="Nouveau mot de passe (laisser vide pour ne pas changer)">
            <!-- Champ pour modifier l'avatar -->
            <div class="form__control">
                <label for="avatar">Modifier l'avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <!-- Liste déroulante pour sélectionner le rôle de l'utilisateur -->
            <select name="userrole">
                <option value="0" <?= $user['is_admin'] == 0 ? 'selected' : '' ?>>Auteur</option>
                <option value="1" <?= $user['is_admin'] == 1 ? 'selected' : '' ?>>Admin</option>
            </select>
            <!-- Bouton pour soumettre le formulaire -->
            <button type="submit" name="submit" class="btn">Modifier l'utilisateur</button>
        </form>
    </div>
</section>
<?php
// Inclure le fichier du pied de page
require '../partials/footer.php';
?>
</body>
</html>

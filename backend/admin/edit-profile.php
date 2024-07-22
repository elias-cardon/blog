<?php
// Inclure le fichier de l'en-tête
require './partials/header.php';

// Récupérer l'ID de l'utilisateur actuel depuis la session
$current_user_id = $_SESSION['user-id'];

// Récupérer les informations de l'utilisateur depuis la base de données
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $connection->prepare($query);
$stmt->bindParam(':id', $current_user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur existe et s'il est administrateur
if (!$user || !$user['is_admin']) {
    // Rediriger vers la page d'administration si l'utilisateur n'est pas administrateur
    header('Location: ' . ROOT_URL . 'backend/admin/');
    die();
}
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Modifier le profil</h2>
        <!-- Formulaire pour modifier le profil -->
        <form action="<?= ROOT_URL ?>/backend/admin/edit-profile-logic.php" method="POST" enctype="multipart/form-data">
            <!-- Champ caché pour l'ID de l'utilisateur -->
            <input type="hidden" value="<?= htmlspecialchars($user['id']) ?>" name="id">
            <!-- Champ pour le prénom -->
            <input type="text" value="<?= htmlspecialchars($user['firstname']) ?>" name="firstname" placeholder="Prénom">
            <!-- Champ pour le nom de famille -->
            <input type="text" value="<?= htmlspecialchars($user['lastname']) ?>" name="lastname" placeholder="Nom de famille">
            <!-- Champ pour le pseudonyme -->
            <input type="text" value="<?= htmlspecialchars($user['username']) ?>" name="username" placeholder="Pseudonyme">
            <!-- Champ pour le nouveau mot de passe (laisser vide pour ne pas changer) -->
            <input type="password" name="password" placeholder="Nouveau mot de passe (laisser vide pour ne pas changer)">
            <!-- Champ pour modifier l'avatar -->
            <div class="form__control">
                <label for="avatar">Modifier l'avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <!-- Bouton pour soumettre le formulaire -->
            <button type="submit" name="submit" class="btn">Modifier le profil</button>
        </form>
    </div>
</section>
<?php
// Inclure le fichier du pied de page
require '../partials/footer.php';
?>
</body>
</html>

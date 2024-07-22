<?php
require './partials/header.php';

// Récupère l'ID de l'utilisateur actuel depuis la session
$current_user_id = $_SESSION['user-id'];

// Récupère les informations de l'utilisateur depuis la base de données
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $connection->prepare($query);
$stmt->bindParam(':id', $current_user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifie si l'utilisateur existe et s'il est administrateur
if (!$user || !$user['is_admin']) {
    // Redirige vers la page d'administration si l'utilisateur n'est pas administrateur
    header('Location: ' . ROOT_URL . 'backend/admin/');
    die();
}
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Modifier le profil</h2>
        <form action="<?= ROOT_URL ?>/backend/admin/edit-profile-logic.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="<?= htmlspecialchars($user['id']) ?>" name="id">
            <input type="text" value="<?= htmlspecialchars($user['firstname']) ?>" name="firstname" placeholder="Prénom">
            <input type="text" value="<?= htmlspecialchars($user['lastname']) ?>" name="lastname" placeholder="Nom de famille">
            <input type="text" value="<?= htmlspecialchars($user['username']) ?>" name="username" placeholder="Pseudonyme">
            <input type="password" name="password" placeholder="Nouveau mot de passe (laisser vide pour ne pas changer)">
            <div class="form__control">
                <label for="avatar">Modifier l'avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Modifier le profil</button>
        </form>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
</body>
</html>

<?php
// Inclure le fichier de l'en-tête
require './partials/header.php';

// Récupérer les données du formulaire si une erreur s'est produite
// Si les données existent dans la session, les assigner aux variables correspondantes
// Sinon, assigner des chaînes vides
$firstname = $_SESSION['add-user-data']['firstname'] ?? '';
$lastname = $_SESSION['add-user-data']['lastname'] ?? '';
$username = $_SESSION['add-user-data']['username'] ?? '';
$email = $_SESSION['add-user-data']['email'] ?? '';
$createpassword = $_SESSION['add-user-data']['createpassword'] ?? '';
$confirm_password = $_SESSION['add-user-data']['confirmpassword'] ?? '';

// Supprimer les données de session après les avoir récupérées
unset($_SESSION['add-user-data']);
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Ajout d'utilisateur</h2>
        <?php
        // Vérifier s'il y a un message d'erreur dans la session
        if (isset($_SESSION['add-user'])) : ?>
            <div class="alert__message error">
                <p>
                    <?php
                    // Afficher le message d'erreur et le supprimer de la session
                    echo $_SESSION['add-user'];
                    unset($_SESSION['add-user']);
                    ?>
                </p>
            </div>
        <?php endif; ?>
        <!-- Formulaire pour ajouter un nouvel utilisateur -->
        <form action="<?= ROOT_URL ?>backend/admin/add-user-logic.php" method="POST" enctype="multipart/form-data">
            <!-- Champ pour le prénom -->
            <input type="text" name="firstname" value="<?= htmlspecialchars($firstname) ?>" placeholder="Prénom">
            <!-- Champ pour le nom de famille -->
            <input type="text" name="lastname" value="<?= htmlspecialchars($lastname) ?>" placeholder="Nom de famille">
            <!-- Champ pour le pseudonyme -->
            <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" placeholder="Pseudonyme">
            <!-- Champ pour l'adresse email -->
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Adresse email">
            <!-- Champ pour le mot de passe -->
            <input type="password" name="createpassword" value="<?= htmlspecialchars($createpassword) ?>" placeholder="Mot de passe">
            <!-- Champ pour la confirmation du mot de passe -->
            <input type="password" name="confirmpassword" value="<?= htmlspecialchars($confirm_password) ?>" placeholder="Confirmation du mot de passe">
            <!-- Liste déroulante pour sélectionner le rôle de l'utilisateur -->
            <select name="userrole">
                <option value="0">Auteur</option>
                <option value="1">Admin</option>
            </select>
            <!-- Champ pour ajouter un avatar -->
            <div class="form__control">
                <label for="avatar">Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <!-- Bouton pour soumettre le formulaire -->
            <button type="submit" name="submit" class="btn">Ajouter utilisateur</button>
        </form>
    </div>
</section>
<?php
// Inclure le fichier du pied de page
require '../partials/footer.php';
?>
</body>
</html>

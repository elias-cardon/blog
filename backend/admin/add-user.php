<?php
require './partials/header.php';

//get back form data if there was an error
$firstname = $_SESSION['add-user-data']['firstname'] ?? '';
$lastname = $_SESSION['add-user-data']['lastname'] ?? '';
$username = $_SESSION['add-user-data']['username'] ?? '';
$email = $_SESSION['add-user-data']['email'] ?? '';
$createpassword = $_SESSION['add-user-data']['createpassword'] ?? '';
$confirm_password = $_SESSION['add-user-data']['confirmpassword'] ?? '';

//delete session data
unset($_SESSION['add-user-data']);
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Ajout d'utilisateur</h2>
        <?php if (isset($_SESSION['add-user'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['add-user'];
                    unset($_SESSION['add-user']);
                    ?>
                </p>
            </div>
        <?php endif; ?>
        <form action="<?= ROOT_URL ?>backend/admin/add-user-logic.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="firstname" value="<?= htmlspecialchars($firstname) ?>" placeholder="Prénom">
            <input type="text" name="lastname" value="<?= htmlspecialchars($lastname) ?>" placeholder="Nom de famille">
            <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" placeholder="Pseudonyme">
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Adresse email">
            <input type="password" name="createpassword" value="<?= htmlspecialchars($createpassword) ?>" placeholder="Mot de passe">
            <input type="password" name="confirmpassword" value="<?= htmlspecialchars($confirm_password) ?>" placeholder="Confirmation du mot de passe">
            <select name="userrole">
                <option value="0">Auteur</option>
                <option value="1">Admin</option>
            </select>
            <div class="form__control">
                <label for="avatar">Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Ajouter utilisateur</button>
        </form>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
</body>
</html>

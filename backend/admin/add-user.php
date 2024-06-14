<?php
require './partials/header.php';
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Ajout d'utilisateur</h2>
        <div class="alert__message error">
            <p>C'est un message d'erreur.</p>
        </div>
        <form action="<?= ROOT_URL ?>add-user-logic.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="firstname" placeholder="Prénom">
            <input type="text" name="lastname" placeholder="Nom de famille">
            <input type="text" name="username" placeholder="Pseudonyme">
            <input type="email" name="email" placeholder="Adresse email">
            <input type="password" name="createpassword" placeholder="Mot de passe">
            <input type="password" name="confirmpassword" placeholder="Confirmation du mot de passe">
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
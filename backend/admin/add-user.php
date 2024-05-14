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
        <form action="" enctype="multipart/form-data">
            <input type="text" placeholder="Prénom">
            <input type="text" placeholder="Nom de famille">
            <input type="text" placeholder="Pseudonyme">
            <input type="email" placeholder="Adresse email">
            <input type="password" placeholder="Mot de passe">
            <input type="password" placeholder="Confirmation du mot de passe">
            <select>
                <option value="0">Auteur</option>
                <option value="1">Admin</option>
            </select>
            <div class="form__control">
                <label for="avatar">Avatar</label>
                <input type="file" id="avatar">
            </div>
            <button type="submit" class="btn">Ajouter utilisateur</button>
        </form>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
</body>
</html>
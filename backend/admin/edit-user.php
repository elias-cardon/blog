<?php
require './partials/header.php';
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Modifier l'utilisateur</h2>
        <form action="" enctype="multipart/form-data">
            <input type="text" placeholder="Prénom">
            <input type="text" placeholder="Nom de famille">
            <select>
                <option value="0">Auteur</option>
                <option value="1">Admin</option>
            </select>
            <button type="submit" class="btn">Modifier l'utilisateur</button>
        </form>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
</body>
</html>
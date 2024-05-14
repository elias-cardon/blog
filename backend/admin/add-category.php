<?php
require 'partials/header.php';
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Ajout de catégorie</h2>
        <div class="alert__message error">
            <p>C'est un message d'erreur.</p>
        </div>
        <form action="" enctype="multipart/form-data">
            <input type="text" placeholder="Nom de la catégorie">
            <textarea rows="4" placeholder="Description"></textarea>
            <button type="submit" class="btn">Ajouter catégorie</button>
        </form>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
</body>
</html>
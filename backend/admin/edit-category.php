<?php
require './partials/header.php';
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Modifier la catégorie</h2>
        <form action="" enctype="multipart/form-data">
            <input type="text" placeholder="Nom de la catégorie">
            <textarea rows="4" placeholder="Description"></textarea>
            <button type="submit" class="btn">Modifier la catégorie</button>
        </form>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
</body>
</html>
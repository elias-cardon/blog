<?php
require 'partials/header.php';
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Ajout d'article</h2>
        <div class="alert__message error">
            <p>C'est un message d'erreur.</p>
        </div>
        <form action="" enctype="multipart/form-data">
            <input type="text" placeholder="Titre de l'article">
            <select>
                <option value="1">Travel</option>
                <option value="2">Art</option>
                <option value="3">Science et technologie</option>
                <option value="1">Travel</option>
                <option value="1">Travel</option>
                <option value="1">Travel</option>
            </select>
            <textarea rows="10" placeholder="Texte de l'article"></textarea>
            <div class="form__control inline">
                <input type="checkbox" id="is_featured" checked>
                <label for="is_featured">A la Une</label>
            </div>
            <div class="form__control">
                <label for="thumbnail">Ajouter une miniature</label>
                <input type="file" id="thumbnail">
            </div>
            <button type="submit" class="btn">Ajouter l'article</button>
        </form>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
</body>
</html>
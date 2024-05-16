<?php
require './partials/header.php';
?>
<section class="dashboard">
    <div class="container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-right-b"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-left-b"></i></button>
        <aside>
            <ul>
                <li>
                    <a href="add-post.php">
                        <i class="uil uil-pen"></i>
                        <h5>Ajouter un article</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php" class="active">
                        <i class="uil uil-postcard"></i>
                        <h5>Liste des articles</h5>
                    </a>
                </li>
                <li>
                    <a href="add-user.php">
                        <i class="uil uil-user-plus"></i>
                        <h5>Ajouter un utilisateur</h5>
                    </a>
                </li>
                <li>
                    <a href="manage-user.php">
                        <i class="uil uil-users-alt"></i>
                        <h5>Liste des utilisateurs</h5>
                    </a>
                </li>
                <li>
                    <a href="add-category.php">
                        <i class="uil uil-edit"></i>
                        <h5>Ajouter une catégorie</h5>
                    </a>
                </li>
                <li>
                    <a href="manage-category.php">
                        <i class="uil uil-list-ul"></i>
                        <h5>Liste des catégories</h5>
                    </a>
                </li>
            </ul>
        </aside>
        <main>
            <h2>Liste des articles</h2>
            <table>
                <thead>
                <tr>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Un article</td>
                    <td>Une catégorie</td>
                    <td><a href="edit-post.php" class="btn sm">Modifier</a></td>
                    <td><a href="delete-post.php" class="btn sm danger">Supprimer</a></td>
                </tr>
                <tr>
                    <td>Un autre article</td>
                    <td>Une autre catégorie</td>
                    <td><a href="edit-post.php" class="btn sm">Modifier</a></td>
                    <td><a href="delete-post.php" class="btn sm danger">Supprimer</a></td>
                </tr>
                <tr>
                    <td>Un article mdrrr</td>
                    <td>Une catégorie yoyoyo</td>
                    <td><a href="edit-post.php" class="btn sm">Modifier</a></td>
                    <td><a href="delete-post.php" class="btn sm danger">Supprimer</a></td>
                </tr>
                </tbody>
            </table>
        </main>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
<script src="../../frontend/assets/main.js"></script>
</body>
</html>
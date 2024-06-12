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
                    <a href="index.php">
                        <i class="uil uil-postcard"></i>
                        <h5>Liste des articles</h5>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_is_admin'])): ?>
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
                        <a href="manage-category.php" class="active">
                            <i class="uil uil-list-ul"></i>
                            <h5>Liste des catégories</h5>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </aside>
        <main>
            <h2>Liste des utilisateurs</h2>
            <table>
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Pseudo</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                    <th>Admin</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Elias Cardon</td>
                    <td>Jobba</td>
                    <td><a href="edit-user.php" class="btn sm">Modifier</a></td>
                    <td><a href="delete-user.php" class="btn sm danger">Supprimer</a></td>
                    <td>Oui</td>
                </tr>
                <tr>
                    <td>Mike</td>
                    <td>Rocky Mike</td>
                    <td><a href="edit-user.php" class="btn sm">Modifier</a></td>
                    <td><a href="delete-user.php" class="btn sm danger">Supprimer</a></td>
                    <td>Non</td>
                </tr>
                <tr>
                    <td>Marine</td>
                    <td>Le Pen</td>
                    <td><a href="edit-user.php" class="btn sm">Modifier</a></td>
                    <td><a href="delete-user.php" class="btn sm danger">Supprimer</a></td>
                    <td>Non</td>
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
<?php
require './partials/header.php';

//fetch categories from database
$query = "SELECT * FROM categories ORDER BY title";
$categories = mysqli_query($connection, $query);
?>
<section class="dashboard">
    <?php if (isset($_SESSION['add-category-success'])) : //Shows if add category is successful ?>
    <div class="alert__message success container">
        <p>
            <?= $_SESSION['add-category-success'];
            unset($_SESSION['add-category-success']);
            ?>
        </p>
    </div>
    <?php endif; ?>
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
            <h2>Liste des catégories</h2>
            <?php if (mysqli_num_rows($categories) > 0) : ?>
            <table>
                <thead>
                <tr>
                    <th>Titre</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                <tr>
                    <td><?= $category['title'] ?></td>
                    <td><a href="<?= ROOT_URL ?>backend/admin/edit-category.php?id=<?= $category['id'] ?>" class="btn sm">Modifier</a></td>
                    <td><a href="<?= ROOT_URL ?>backend/admin/delete-category.php?id=<?= $category['id'] ?>" class="btn sm danger">Supprimer</a></td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <?php else : ?>
            <div class="alert__message error"><?= "Aucune catégorie trouvée. Pas de cat, prend un KitKat." ?></div>
            <?php endif; ?>
        </main>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
<script src="../../frontend/assets/main.js"></script>
</body>
</html>
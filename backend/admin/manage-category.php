<?php
require './partials/header.php';

// Récupère les catégories de la base de données
$query = "SELECT * FROM categories ORDER BY title";
$stmt = $connection->query($query);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="dashboard">
    <?php if (isset($_SESSION['add-category-success'])) : // Affiche un message si l'ajout d'une catégorie est réussi ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['add-category-success'];
                unset($_SESSION['add-category-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['add-category'])) : // Affiche un message si l'ajout d'une catégorie échoue ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['add-category'];
                unset($_SESSION['add-category']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-category'])) : // Affiche un message si la modification d'une catégorie échoue ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['edit-category'];
                unset($_SESSION['edit-category']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-category-success'])) : // Affiche un message si la modification d'une catégorie est réussie ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['edit-category-success'];
                unset($_SESSION['edit-category-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-category-success'])) : // Affiche un message si la suppression d'une catégorie est réussie ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['delete-category-success'];
                unset($_SESSION['delete-category-success']);
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
            <?php if (count($categories) > 0) : ?>
                <table>
                    <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($categories as $category) : ?>
                        <tr>
                            <td><?= htmlspecialchars_decode($category['title']) ?></td>
                            <td><a href="<?= ROOT_URL ?>backend/admin/edit-category.php?id=<?= $category['id'] ?>"
                                   class="btn sm">Modifier</a></td>
                            <td><a href="<?= ROOT_URL ?>backend/admin/delete-category.php?id=<?= $category['id'] ?>"
                                   class="btn sm danger">Supprimer</a></td>
                        </tr>
                    <?php endforeach; ?>
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

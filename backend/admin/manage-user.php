<?php
require './partials/header.php';

//fetch users from database but not current user
$current_admin_id = $_SESSION['user-id'];

$query = "SELECT * FROM `users` WHERE NOT id='$current_admin_id'";
$users = mysqli_query($connection, $query);
?>
<section class="dashboard">
    <?php if (isset($_SESSION['add-user-success'])) : //Shows if add user is successful ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['add-user-success'];
                unset($_SESSION['add-user-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-user-success'])) : //Shows if edit user is successful?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['edit-user-success'];
                unset($_SESSION['edit-user-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-user'])) : //Shows if edit user is not successful?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['edit-user'];
                unset($_SESSION['edit-user']);
                ?>
            </p>
        </div>
    <?php endif ?>
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
                <?php while ($user = mysqli_fetch_assoc($users)) : ?>
                    <tr>
                        <td><?= "{$user['firstname']} {$user['lastname']}" ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><a href="<?= ROOT_URL ?>backend/admin/edit-user.php?id=<?= $user['id'] ?>" class="btn sm">Modifier</a></td>
                        <td><a href="<?= ROOT_URL ?>backend/admin/delete-user.php?id=<?= $user['id'] ?>" class="btn sm danger">Supprimer</a></td>
                        <td><?= $user['is_admin'] ? 'Oui' : 'Non' ?></td>
                    </tr>
                <?php endwhile; ?>
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
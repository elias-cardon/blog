<?php
// Inclure le fichier de l'en-tête
require './partials/header.php';

// Récupérer les utilisateurs de la base de données sauf l'utilisateur actuel
$current_admin_id = $_SESSION['user-id'];

$query = "SELECT * FROM users WHERE id != :current_admin_id";
$stmt = $connection->prepare($query);
$stmt->bindParam(':current_admin_id', $current_admin_id, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="dashboard">
    <?php if (isset($_SESSION['add-user-success'])) : // Afficher un message si l'ajout d'un utilisateur est réussi ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['add-user-success'];
                unset($_SESSION['add-user-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-user-success'])) : // Afficher un message si la modification d'un utilisateur est réussie ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['edit-user-success'];
                unset($_SESSION['edit-user-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-user'])) : // Afficher un message si la modification d'un utilisateur échoue ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['edit-user'];
                unset($_SESSION['edit-user']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-user'])) : // Afficher un message si la suppression d'un utilisateur échoue ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['delete-user'];
                unset($_SESSION['delete-user']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-user-success'])) : // Afficher un message si la suppression d'un utilisateur est réussie ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['delete-user-success'];
                unset($_SESSION['delete-user-success']);
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
            <?php if (count($users) > 0) : ?>
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
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= htmlspecialchars("{$user['firstname']} {$user['lastname']}") ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><a href="<?= ROOT_URL ?>backend/admin/edit-user.php?id=<?= $user['id'] ?>" class="btn sm">Modifier</a></td>
                            <td><a href="<?= ROOT_URL ?>backend/admin/delete-user.php?id=<?= $user['id'] ?>" class="btn sm danger">Supprimer</a></td>
                            <td><?= $user['is_admin'] ? 'Oui' : 'Non' ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert__message error"><?= "Aucun utilisateur trouvé. Un petit Solitaire ?" ?></div>
            <?php endif ?>
        </main>
    </div>
</section>
<?php
// Inclure le fichier du pied de page
require '../partials/footer.php';
?>
<script src="../../frontend/assets/main.js"></script>
</body>
</html>

<?php
require './partials/header.php';

// Fetch current user's posts from database
$current_user_id = $_SESSION['user-id'];
$is_admin = $_SESSION['user_is_admin'] ?? false;

if ($is_admin) {
    $query = "SELECT posts.id, posts.title, posts.category_id, posts.is_featured, users.username AS author 
              FROM posts 
              JOIN users ON posts.author_id = users.id 
              ORDER BY posts.id DESC";
    $stmt = $connection->prepare($query);
    $stmt->execute();
} else {
    $query = "SELECT id, title, category_id, is_featured FROM posts WHERE author_id = :current_user_id ORDER BY id DESC";
    $stmt = $connection->prepare($query);
    $stmt->execute(['current_user_id' => $current_user_id]);
}
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css">
</head>
<body>
<section class="dashboard">
    <?php if (isset($_SESSION['add-post-success'])) : // Shows if add post is successful ?>
        <div class="alert__message success container">
            <p>
                <?= htmlspecialchars($_SESSION['add-post-success'], ENT_QUOTES, 'UTF-8');
                unset($_SESSION['add-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post-success'])) : // Shows if edit post is successful ?>
        <div class="alert__message success container">
            <p>
                <?= htmlspecialchars($_SESSION['edit-post-success'], ENT_QUOTES, 'UTF-8');
                unset($_SESSION['edit-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post'])) : // Shows if edit post is not successful ?>
        <div class="alert__message error container">
            <p>
                <?= htmlspecialchars($_SESSION['edit-post'], ENT_QUOTES, 'UTF-8');
                unset($_SESSION['edit-post']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-post-success'])) : // Shows if delete post is successful ?>
        <div class="alert__message success container">
            <p>
                <?= htmlspecialchars($_SESSION['delete-post-success'], ENT_QUOTES, 'UTF-8');
                unset($_SESSION['delete-post-success']);
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
                    <a href="index.php" class="active">
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
                        <a href="manage-category.php">
                            <i class="uil uil-list-ul"></i>
                            <h5>Liste des catégories</h5>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </aside>
        <main>
            <h2>Liste des articles</h2>
            <?php if (count($posts) > 0) : ?>
                <table>
                    <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Auteur</th>
                        <th>A la Une</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($posts as $post) : ?>
                        <!-- Get category title of each post from categories table -->
                        <?php
                        $category_id = $post['category_id'];
                        $category_query = "SELECT title FROM categories WHERE id = :category_id";
                        $category_stmt = $connection->prepare($category_query);
                        $category_stmt->execute(['category_id' => $category_id]);
                        $category = $category_stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <tr>
                            <td><?= htmlspecialchars_decode(htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8')) ?></td>
                            <td><?= htmlspecialchars_decode(htmlspecialchars($category['title'], ENT_QUOTES, 'UTF-8')) ?></td>
                            <td><?= htmlspecialchars_decode(htmlspecialchars($post['author'], ENT_QUOTES, 'UTF-8')) ?></td>
                            <td><?= $post['is_featured'] ? 'Oui' : 'Non' ?></td>
                            <td><a href="<?= htmlspecialchars(ROOT_URL . 'backend/admin/edit-post.php?id=' . $post['id'], ENT_QUOTES, 'UTF-8') ?>" class="btn sm">Modifier</a></td>
                            <td><a href="<?= htmlspecialchars(ROOT_URL . 'backend/admin/delete-post.php?id=' . $post['id'], ENT_QUOTES, 'UTF-8') ?>" class="btn sm danger">Supprimer</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert__message error"><?= "Aucun post trouvé." ?></div>
            <?php endif ?>
        </main>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
<script src="../../frontend/assets/main.js"></script>
</body>
</html>

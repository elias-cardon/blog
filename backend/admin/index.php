<?php
// Inclure le fichier de l'en-tête (header) qui contient probablement des initialisations et le début du code HTML
require './partials/header.php';

// Récupérer les ID et privilèges de l'utilisateur actuel depuis la session
$current_user_id = $_SESSION['user-id'];
$is_admin = $_SESSION['user_is_admin'] ?? false; // Si l'utilisateur est un administrateur, cette variable sera vraie

// Si l'utilisateur est un administrateur, récupérer tous les articles avec leurs auteurs
if ($is_admin) {
    $query = "SELECT posts.id, posts.title, posts.category_id, posts.is_featured, users.username AS author 
              FROM posts 
              JOIN users ON posts.author_id = users.id 
              ORDER BY posts.id DESC";
    $stmt = $connection->prepare($query); // Préparer la requête SQL
    $stmt->execute(); // Exécuter la requête
} else {
    // Sinon, récupérer uniquement les articles de l'utilisateur actuel
    $query = "SELECT id, title, category_id, is_featured FROM posts WHERE author_id = :current_user_id ORDER BY id DESC";
    $stmt = $connection->prepare($query); // Préparer la requête SQL
    $stmt->execute(['current_user_id' => $current_user_id]); // Exécuter la requête avec le paramètre de l'utilisateur actuel
}
// Récupérer tous les résultats sous forme de tableau associatif
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
<section class="dashboard">
    <!-- Afficher des messages de succès ou d'erreur en fonction des actions effectuées -->
    <?php if (isset($_SESSION['add-post-success'])) : // Afficher si l'ajout d'un article a réussi ?>
        <div class="alert__message success container">
            <p>
                <?= htmlspecialchars($_SESSION['add-post-success'], ENT_QUOTES, 'UTF-8'); // Afficher le message et le supprimer ensuite
                unset($_SESSION['add-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post-success'])) : // Afficher si la modification d'un article a réussi ?>
        <div class="alert__message success container">
            <p>
                <?= htmlspecialchars($_SESSION['edit-post-success'], ENT_QUOTES, 'UTF-8'); // Afficher le message et le supprimer ensuite
                unset($_SESSION['edit-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post'])) : // Afficher si la modification d'un article a échoué ?>
        <div class="alert__message error container">
            <p>
                <?= htmlspecialchars($_SESSION['edit-post'], ENT_QUOTES, 'UTF-8'); // Afficher le message et le supprimer ensuite
                unset($_SESSION['edit-post']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-post-success'])) : // Afficher si la suppression d'un article a réussi ?>
        <div class="alert__message success container">
            <p>
                <?= htmlspecialchars($_SESSION['delete-post-success'], ENT_QUOTES, 'UTF-8'); // Afficher le message et le supprimer ensuite
                unset($_SESSION['delete-post-success']);
                ?>
            </p>
        </div>
    <?php endif; ?>

    <!-- Contenu principal du tableau de bord -->
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
                <!-- Afficher des options supplémentaires pour l'administrateur -->
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
                        <!-- Récupérer le titre de la catégorie pour chaque article -->
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
// Inclure le fichier du pied de page (footer) qui contient probablement la fin du code HTML et des scripts
require '../partials/footer.php';
?>
<script src="../../frontend/assets/main.js"></script> <!-- Lien vers le fichier JavaScript -->
</body>
</html>

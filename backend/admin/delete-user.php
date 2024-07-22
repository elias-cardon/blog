<?php
// Inclure le fichier de configuration de la base de données
require '../config/database.php';

// Vérifier si l'ID de l'utilisateur est fourni dans l'URL
if (isset($_GET['id'])) {
    // Assainir l'ID pour éviter les injections de code
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Récupérer l'utilisateur de la base de données
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // S'assurer qu'un seul utilisateur a été récupéré
    if ($stmt->rowCount() == 1) {
        $avatar_name = $user['avatar'];
        $avatar_path = '../../frontend/assets/images/' . $avatar_name;
        // Supprimer l'image de l'avatar si elle existe
        if (file_exists($avatar_path)) {
            unlink($avatar_path);
        }
    }

    // Récupérer toutes les miniatures des articles de l'utilisateur et les supprimer
    $thumbnails_query = "SELECT thumbnail FROM posts WHERE author_id = :id";
    $stmt = $connection->prepare($thumbnails_query);
    $stmt->execute(['id' => $id]);
    $thumbnails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($thumbnails as $thumbnail) {
        $thumbnail_path = '../../frontend/assets/images/' . $thumbnail['thumbnail'];
        // Supprimer la miniature du dossier d'images si elle existe
        if (file_exists($thumbnail_path)) {
            unlink($thumbnail_path);
        }
    }

    // Supprimer l'utilisateur de la base de données
    $delete_user_query = "DELETE FROM users WHERE id = :id";
    $stmt = $connection->prepare($delete_user_query);
    $stmt->execute(['id' => $id]);

    // Vérifier si la suppression a réussi
    if ($stmt->rowCount() > 0) {
        // Enregistrer un message de succès dans la session
        $_SESSION['delete-user'] = "Suppression de {$user['firstname']} {$user['lastname']} effectuée.";
    } else {
        // Enregistrer un message d'erreur dans la session si la suppression a échoué
        $_SESSION['delete-user'] = "Suppression de {$user['firstname']} {$user['lastname']} impossible.";
    }
}

// Rediriger vers la page de gestion des utilisateurs
header('Location: ' . ROOT_URL . 'backend/admin/manage-user.php');
die();
?>

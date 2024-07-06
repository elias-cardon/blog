<?php
require './partials/header.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);
} else{
    header('Location:' . ROOT_URL . 'backend/admin/manage-user.php');
    die();
}
?>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Modifier l'utilisateur</h2>
        <form action="<?= ROOT_URL ?>/backend/admin/edit-user-logic.php" method="POST">
            <input type="hidden" value="<?= $user['id'] ?>" name="id">
            <input type="text" value="<?= $user['firstname'] ?>" name="firstname" placeholder="Prénom">
            <input type="text" value="<?= $user['lastname'] ?>" name="lastname" placeholder="Nom de famille">
            <select name="userrole">
                <option value="0">Auteur</option>
                <option value="1">Admin</option>
            </select>
            <button type="submit" name="submit" class="btn">Modifier l'utilisateur</button>
        </form>
    </div>
</section>
<?php
require '../partials/footer.php';
?>
</body>
</html>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="C'est le blog de Jobba, le meilleur de France.">
    <meta name="keywords" content="HTML, CSS, JavaScript, blog, Jobba, meilleur, Elias, Menace, Article, Star Wars">
    <meta name="author" content="Elias Cardon aka Jobba">
    <title>Le blog de Jobba</title>
    <!--C'est le CSS-->
    <link rel="icon" type="image/png" href="assets/images/logo.png"/>
    <link rel="stylesheet" href="assets/style.css">
    <!--Iconscout CDN-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
</head>
<body>
<nav>
    <div class="container nav__container">
        <a href="index.php" class="nav__logo">Le blog de Jobba</a>
        <ul class="nav__items">
            <li><a href="blog.php">Blog</a></li>
            <li><a href="about.php">A propos</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="signin.php">Se connecter</a></li>
            <li class="nav__profile">
                <div class="avatar">
                    <img src="./assets/images/avatar1.jpg" alt="Un avatar">
                </div>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Se déconnecter</a></li>
                </ul>
            </li>
        </ul>

        <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
        <button id="open__nav-btn"><i class="uil uil-multiply"></i></button>
    </div>
</nav>
</body>
</html>
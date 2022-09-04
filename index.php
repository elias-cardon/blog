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
<!--==============================NAVBAR=========================================-->
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
                    <li><a href="logout.php">Déconnexion</a></li>
                </ul>
            </li>
        </ul>

        <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
        <button id="open__nav-btn"><i class="uil uil-multiply"></i></button>
    </div>
</nav>
<!--==============================END OF NAVBAR=========================================-->
<!--==============================FEATURED POST=========================================-->
<section class="featured">
    <div class="container featured__container">
        <div class="post__thumbnail">
            <img src="./assets/images/blog1.jpg" alt="Image du blog1">
        </div>
        <div class="post__info">
            <a href="" class="category__button">Wild Life</a>
            <h2 class="post__title"><a href="post.php">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a>
            </h2>
            <p class="post__body">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab alias culpa delectus error est eum, fuga
                inventore, nam nostrum perferendis praesentium quibusdam repellendus sunt tenetur ullam vel, vitae.
                Expedita, fuga.
            </p>
            <div class="post__author">
                <div class="post__author-avatar">
                    <img src="./assets/images/avatar1.jpg" alt="Avatar de l'auteur de l'article">
                </div>
                <div class="post__author-info">
                    <h5>Par : Jobba</h5>
                    <small>3 septembre 2022 - 14:19</small>
                </div>
            </div>
        </div>
    </div>
</section>
<!--==============================END OF FEATURED POST=========================================-->
<!--===============================POST=========================================-->
<section class="posts">
    <div class="container posts__container">
        <article class="post">
            <div class="post__thumbnail">
                <img src="./assets/images/blog2.jpg" alt="Image du blog2">
            </div>
            <div class="post__info">
                <a href="" class="category__button">Wild Life</a>
                <h3 class="post__title">
                    <a href="post.php">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </a>
                </h3>
                <p class="post__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium cupiditate
                    delectus dolore ea expedita id, labore modi non quidem quo quos, repellat voluptatum.
                </p>
                <div class="post__author">
                    <div class="post__author-avatar">
                        <img src="./assets/images/avatar3.jpg" alt="Avatar de l'auteur">
                    </div>
                    <div class="post__author-info">
                        <h5>Par : Jobbax</h5>
                        <small>3 septempbre 2022 - 17:49</small>
                    </div>
                </div>
            </div>
        </article>
        <article class="post">
            <div class="post__thumbnail">
                <img src="./assets/images/blog3.jpg" alt="Image du blog2">
            </div>
            <div class="post__info">
                <a href="" class="category__button">Wild Life</a>
                <h3 class="post__title">
                    <a href="post.php">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </a>
                </h3>
                <p class="post__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium cupiditate
                    delectus dolore ea expedita id, labore modi non quidem quo quos, repellat voluptatum.
                </p>
                <div class="post__author">
                    <div class="post__author-avatar">
                        <img src="./assets/images/avatar2.jpg" alt="Avatar de l'auteur">
                    </div>
                    <div class="post__author-info">
                        <h5>Par : Jobbax</h5>
                        <small>3 septempbre 2022 - 17:49</small>
                    </div>
                </div>
            </div>
        </article>
        <article class="post">
            <div class="post__thumbnail">
                <img src="./assets/images/blog4.jpg" alt="Image du blog2">
            </div>
            <div class="post__info">
                <a href="" class="category__button">Wild Life</a>
                <h3 class="post__title">
                    <a href="post.php">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </a>
                </h3>
                <p class="post__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium cupiditate
                    delectus dolore ea expedita id, labore modi non quidem quo quos, repellat voluptatum.
                </p>
                <div class="post__author">
                    <div class="post__author-avatar">
                        <img src="./assets/images/avatar4.jpg" alt="Avatar de l'auteur">
                    </div>
                    <div class="post__author-info">
                        <h5>Par : Jobbax</h5>
                        <small>3 septempbre 2022 - 17:49</small>
                    </div>
                </div>
            </div>
        </article>
        <article class="post">
            <div class="post__thumbnail">
                <img src="./assets/images/blog5.jpg" alt="Image du blog2">
            </div>
            <div class="post__info">
                <a href="" class="category__button">Wild Life</a>
                <h3 class="post__title">
                    <a href="post.php">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </a>
                </h3>
                <p class="post__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium cupiditate
                    delectus dolore ea expedita id, labore modi non quidem quo quos, repellat voluptatum.
                </p>
                <div class="post__author">
                    <div class="post__author-avatar">
                        <img src="./assets/images/avatar5.jpg" alt="Avatar de l'auteur">
                    </div>
                    <div class="post__author-info">
                        <h5>Par : Jobbax</h5>
                        <small>3 septempbre 2022 - 17:49</small>
                    </div>
                </div>
            </div>
        </article>
        <article class="post">
            <div class="post__thumbnail">
                <img src="./assets/images/blog6.jpg" alt="Image du blog2">
            </div>
            <div class="post__info">
                <a href="" class="category__button">Wild Life</a>
                <h3 class="post__title">
                    <a href="post.php">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </a>
                </h3>
                <p class="post__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium cupiditate
                    delectus dolore ea expedita id, labore modi non quidem quo quos, repellat voluptatum.
                </p>
                <div class="post__author">
                    <div class="post__author-avatar">
                        <img src="./assets/images/avatar6.jpg" alt="Avatar de l'auteur">
                    </div>
                    <div class="post__author-info">
                        <h5>Par : Jobbax</h5>
                        <small>3 septempbre 2022 - 17:49</small>
                    </div>
                </div>
            </div>
        </article>
        <article class="post">
            <div class="post__thumbnail">
                <img src="./assets/images/blog7.jpg" alt="Image du blog2">
            </div>
            <div class="post__info">
                <a href="" class="category__button">Wild Life</a>
                <h3 class="post__title">
                    <a href="post.php">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </a>
                </h3>
                <p class="post__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium cupiditate
                    delectus dolore ea expedita id, labore modi non quidem quo quos, repellat voluptatum.
                </p>
                <div class="post__author">
                    <div class="post__author-avatar">
                        <img src="./assets/images/avatar7.jpg" alt="Avatar de l'auteur">
                    </div>
                    <div class="post__author-info">
                        <h5>Par : Jobbax</h5>
                        <small>3 septembre 2022 - 17:49</small>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
<!--==============================END POST=========================================-->
<!--==============================LIST CATEGORIES=========================================-->
<section class="category__buttons">
    <div class="container category__buttons-container">
        <a href="" class="category__button">Art</a>
        <a href="" class="category__button">Wild Life</a>
        <a href="" class="category__button">Travel</a>
        <a href="" class="category__button">Science & Technologie</a>
        <a href="" class="category__button">Musique</a>
        <a href="" class="category__button">Nourriture</a>
    </div>
</section>
<!--==============================END LIST CATEGORIES=========================================-->
</body>
</html>
// Sélectionne l'élément avec la classe 'nav__items' dans le document et le stocke dans la variable 'navItems'
const navItems = document.querySelector('.nav__items');

// Sélectionne l'élément avec l'ID 'open__nav-btn' dans le document et le stocke dans la variable 'openNavBtn'
const openNavBtn = document.querySelector('#open__nav-btn');

// Sélectionne l'élément avec l'ID 'close__nav-btn' dans le document et le stocke dans la variable 'closeNavBtn'
const closeNavBtn = document.querySelector('#close__nav-btn');

// Fonction pour ouvrir la barre de navigation (navbar) en mode Media Queries
const openNav = () => {
    // Change l'affichage des éléments de la barre de navigation à 'flex'
    navItems.style.display = 'flex';
    // Cache le bouton pour ouvrir la barre de navigation
    openNavBtn.style.display = 'none';
    // Affiche le bouton pour fermer la barre de navigation
    closeNavBtn.style.display = 'inline-block';
}

// Fonction pour fermer la barre de navigation (navbar) en mode Media Queries
const closeNav = () => {
    // Cache les éléments de la barre de navigation
    navItems.style.display = 'none';
    // Affiche le bouton pour ouvrir la barre de navigation
    openNavBtn.style.display = 'inline-block';
    // Cache le bouton pour fermer la barre de navigation
    closeNavBtn.style.display = 'none';
}

// Ajoute un écouteur d'événement sur le bouton d'ouverture de la barre de navigation
// Lorsque ce bouton est cliqué, la fonction openNav est appelée
openNavBtn.addEventListener('click', openNav);

// Ajoute un écouteur d'événement sur le bouton de fermeture de la barre de navigation
// Lorsque ce bouton est cliqué, la fonction closeNav est appelée
closeNavBtn.addEventListener('click', closeNav);

// Sélectionne l'élément <aside> dans le document et le stocke dans la variable 'sidebar'
const sidebar = document.querySelector('aside');

// Sélectionne l'élément avec l'ID 'show__sidebar-btn' dans le document et le stocke dans la variable 'showSidebarBtn'
const showSidebarBtn = document.querySelector('#show__sidebar-btn');

// Sélectionne l'élément avec l'ID 'hide__sidebar-btn' dans le document et le stocke dans la variable 'hideSidebarBtn'
const hideSidebarBtn = document.querySelector('#hide__sidebar-btn');

// Fonction pour afficher la barre latérale (sidebar) sur les petits écrans
const showSidebar = () => {
    // Change la position de la barre latérale à '0', la rendant visible
    sidebar.style.left = '0';
    // Cache le bouton pour afficher la barre latérale
    showSidebarBtn.style.display = 'none';
    // Affiche le bouton pour cacher la barre latérale
    hideSidebarBtn.style.display = 'inline-block';
}

// Fonction pour cacher la barre latérale (sidebar) sur les petits écrans
const hideSidebar = () => {
    // Change la position de la barre latérale à '-100%', la rendant invisible
    sidebar.style.left = '-100%';
    // Affiche le bouton pour afficher la barre latérale
    showSidebarBtn.style.display = 'inline-block';
    // Cache le bouton pour cacher la barre latérale
    hideSidebarBtn.style.display = 'none';
}

// Ajoute un écouteur d'événement sur le bouton d'affichage de la barre latérale
// Lorsque ce bouton est cliqué, la fonction showSidebar est appelée
showSidebarBtn.addEventListener('click', showSidebar);

// Ajoute un écouteur d'événement sur le bouton de masquage de la barre latérale
// Lorsque ce bouton est cliqué, la fonction hideSidebar est appelée
hideSidebarBtn.addEventListener('click', hideSidebar);

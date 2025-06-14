export function renderHeader() {
    return `
    <link rel="stylesheet" href="/app/Views/components/header.css">
    <header class="main-header">
        <div class="header-logo">
            <img src="../../assets/images/Logo.png" alt="Icône PulseZone" class="header-logo-img" >
        </div>
        <button class="hamburger" id="hamburger-btn" aria-label="Ouvrir le menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav class="main-nav nav">
            <a href="../Views/SensorPanel.php" class="nav-link">Espace de Gestion</a>
            <a href="/APP-ProjetCommun/app/Views/About.php" class="nav-link">Fonctionnement</a>
            <a href="../Controllers/ContactPage.php" class="nav-link">Contact</a>
            <a href="../Controllers/logIn.php" class="connection-link">Se Connecter</a>
            <a href="../Controllers/signUp.php" class="inscription-link">Inscription</a>
        </nav>
    </header>
    `;
}

export function initHeaderScripts() {
    // Animation navFadeIn sur les liens
    document.querySelectorAll('.nav-link, .inscription-link').forEach((link, i) => {
        link.style.animationDelay = `${0.3 + i * 0.15}s`;
    });
   
      // Remplace "Inscription" par "Se déconnecter" si l'utilisateur est connecté
    if (window.isLoggedIn === true || window.isLoggedIn === 'true') {
          const navBar = document.querySelector('.nav'); 
    if (navBar) {
        const homeLink = document.createElement('a');
        homeLink.href = '../Views/home.php'; 
        homeLink.textContent = 'Accueil';
        homeLink.classList.add('nav-link');
        homeLink.style.animationDelay = '0s';
        navBar.insertBefore(homeLink, navBar.firstChild); 
    }
        const link = document.querySelector('.inscription-link');
        if (link) {
            link.textContent ="Se déconnecter";
            link.href = "../Controllers/logout.php";
            link.classList.add("logout-link"); 
            link.addEventListener('click', (e) => {
            alert("Vous vous êtes déconnecté.");
        });
        }
         const loginButton = document.querySelector('.connection-link');
    if (loginButton) {
        loginButton.style.display = "none";
    }
    }

    // Effet bulle sur resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
        const header = document.querySelector('.main-header');
        if (header) {
            header.classList.add('bubble-animate');
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                header.classList.remove('bubble-animate');
            }, 500);
        }
    });

    // Hamburger menu
    const hamburger = document.getElementById('hamburger-btn');
    const nav = document.querySelector('.main-nav');
    if (hamburger && nav) {
        hamburger.addEventListener('click', () => {
            nav.classList.toggle('open');
        });
    }
}
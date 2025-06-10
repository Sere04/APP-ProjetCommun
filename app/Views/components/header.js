export function renderHeader() {
    return `
    <link rel="stylesheet" href="/app/Views/components/header.css">
    <header class="main-header">
        <div class="header-logo">
            <img src="../../assets/images/Logo.png" alt="Icône PulseZone" class="header-logo-img" >

        </div>
        <nav class="main-nav">
            <a href="/APP-ProjetCommun/index.php" class="nav-link">Accueil</a>
            <a href="/APP-ProjetCommun/app/Views/SensorPanel.php" class="nav-link">Espace de Gestion</a>
            <a href="/APP-ProjetCommun/app/Views/About.php" class="nav-link">Fonctionnement</a>
            <a href="../Controllers/ContactPage.php" class="nav-link">Contact</a>
            <a href="../Controllers/signUp.php" class="inscription-link">Inscription</a>
        </nav>
    </header>
    <script>
        document.querySelectorAll('.nav-link').forEach((link, i) => {
            link.style.animationDelay = \`\${0.3 + i * 0.15}s\`;
        });
    </script>

    `;
}
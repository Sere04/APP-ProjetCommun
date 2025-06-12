export function renderHeader() {
    return `
    <link rel="stylesheet" href="/app/Views/components/header.css">
    <header class="main-header">
        <div class="header-logo">
            <img src="../../assets/images/Logo.png" alt="Icône PulseZone" class="header-logo-img" >
        </div>
        <nav class="main-nav">
            <a href="/" class="nav-link">Accueil</a>
            <a href="#" class="nav-link">Produits</a>
            <a href="#" class="nav-link">Fonctionnement</a>
            <a href="#" class="nav-link">Blog</a>
            <a href="#" class="nav-link">Contact</a>
        </nav>
    </header>
    <script>
        document.querySelectorAll('.nav-link').forEach((link, i) => {
            link.style.animationDelay = \`\${0.3 + i * 0.15}s\`;
        });
    </script>
    `;
}
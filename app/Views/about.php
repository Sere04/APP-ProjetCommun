<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fonctionnement du site</title>
    <link rel="stylesheet" href="components/header.css">
    <link rel="stylesheet" href="components/footer.css">
    <link rel="stylesheet" href="Layouts/legalNoticecss.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
            <div id="header"></div>

<div class="legal-page-container">
    <h1>Fonctionnement du site</h1>

    <div class="notice-section">
        <h2>Objectif du site</h2>
        <p>
            Le site <strong>PulseZone</strong> a pour mission de surveiller en temps réel les conditions environnementales d’une salle de concert.
            Grâce à des capteurs connectés, il fournit des données essentielles à la sécurité, au confort et à la gestion technique de l’espace.
        </p>
    </div>

    <div class="notice-section">
        <h2>Données collectées</h2>
        <ul>
            <li>Température ambiante</li>
            <li>Taux d’humidité</li>
            <li>Niveau sonore</li>
            <li>Autres indicateurs environnementaux</li>
        </ul>
        <p>
            Ces informations sont accessibles à tous les visiteurs sur la page d’accueil, sans nécessité de compte utilisateur.
        </p>
    </div>

    <div class="notice-section">
        <h2>Types d'utilisateurs</h2>
        <p>Le site PulseZone propose plusieurs niveaux d’accès selon le profil :</p>
        <ul>
            <li><strong>Visiteur :</strong> accès libre aux données affichées publiquement.</li>
            <li><strong>Utilisateur inscrit :</strong> accès standard sans privilèges supplémentaires.</li>
            <li><strong>Modérateur :</strong> accès aux outils de gestion des capteurs (ajout, modification, suppression).</li>
            <li><strong>Administrateur :</strong> accès total, y compris à la gestion des utilisateurs et des rôles.</li>
        </ul>
    </div>

    <div class="notice-section">
        <h2>Fonctionnalités principales</h2>
        <ul>
            <li>Affichage en temps réel des données environnementales</li>
            <li>Création de compte et authentification</li>
            <li>Gestion des capteurs pour les modérateurs</li>
            <li>Interface d’administration pour les administrateurs</li>
        </ul>
    </div>

    <div class="notice-section">
        <h2>Autres pages utiles</h2>
        <p>
            Le site PulseZone inclut également :
        </p>
        <ul>
            <li>Une page <a href="../Views/ContactPageView.php">Contact</a> pour toute demande ou suggestion</li>
            <li>Une page <a href="../Views/legalNotice.html">Mentions légales</a> détaillant les aspects juridiques du site</li>
        </ul>
    </div>
</div>

<div id="footer"></div>
  <script>
    window.isLoggedIn = <?= isset($_SESSION['user']) ? 'true' : 'false' ?>;
    window.userRole = "<?php echo isset($_SESSION['Permission']) ? htmlspecialchars($_SESSION['Permission']) : ''; ?>";

</script>
<script type="module">
    import { renderHeader, initHeaderScripts } from '/APP-ProjetCommun/app/Views/components/header.js';
    import { renderFooter } from '/APP-ProjetCommun/app/Views/components/footer.js';
    document.getElementById('header').innerHTML = renderHeader();
        initHeaderScripts();
    document.getElementById('footer').innerHTML = renderFooter();
</script>
</body>
</html>

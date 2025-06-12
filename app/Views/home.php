<?php
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="Layouts/home.css">
    <link rel="stylesheet" href="components/header.css">
    <link rel="stylesheet" href="components/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div id="header"></div>
    <div class="main-content">
        <div class="main-content-white">
            <section class="concert-section">
                <img src="../../assets/images/concert.gif" alt="Concert" class="concert-gif">

                <div class="concert-blur"></div>
                <div class="concert-overlay"></div>
                <div class="concert-content">
                    <h2 class="concert-title">
                        Vivez vos évènements dans la plus <span class="gradient-text">high tech</span> des salles de concerts
                    </h2>
                    <p class="concert-desc">Lorem Ipsum</p>
                </div>
            </section>

            <section class="cards-row">
                <div class="gradient-card">
                    <div class="gradient-card-inner">
                        <h2>Sécurité</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                    </div>
                </div>
                <div class="gradient-card">
                    <div class="gradient-card-inner">
                        <h2>Sécurité</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                    </div>
                </div>
                <div class="gradient-card">
                    <div class="gradient-card-inner">
                        <h2>Sécurité</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                    </div>
                </div>
                <div class="gradient-card">
                    <div class="gradient-card-inner">
                        <h2>Sécurité</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                    </div>
                </div>
                <div class="gradient-card">
                    <div class="gradient-card-inner">
                        <h2>Sécurité</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                    </div>
                </div>
                <div class="gradient-card">
                    <div class="gradient-card-inner">
                        <h2>Sécurité</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                    </div>
                </div>
            </section>
        
        <section class="title-section">
            <div class="background-circle"></div>
            <div class="global-blur-overlay"></div>
            <div class="content">
                <h1 class="main-title">
                    <span class="gradient-text">Bienvenue</span> sur la page d'accueil
                </h1>
                <p>Effet de profondeur avec dégradé et flou.</p>
            </div>
        </section>
        </div>
        
    </div>
    <div id="footer"></div>
    <script type="module">
        import { renderHeader } from '/APP-ProjetCommun/app/Views/components/header.js';
        import { renderFooter } from '/APP-ProjetCommun/app/Views/components/footer.js';
        document.getElementById('header').innerHTML = renderHeader();
        document.getElementById('footer').innerHTML = renderFooter();
    </script>
</body>
</html>


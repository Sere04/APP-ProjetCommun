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

            <section>
                <!--<div id="refresh-timer" class="refresh-timer">
                    Rafraîchissement dans <span id="timer">10</span> secondes
                </div>-->
                <div id="cards-dynamic" class="cards-row">
                    <!-- Les cartes capteurs seront injectées ici -->
                </div>
            </section>
        
            <section class="title-section">
                <div class="background-circle"></div>
                <div class="global-blur-overlay"></div>
                <div class="content">
                    <h1 class="main-title">
                        <span class="gradient-text">Rafraîchissement :</span>
                        <span id="timer">10</span> secondes
                    </h1>
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

        // --- Début du script capteurs dynamiques ---
        const cardsDynamic = document.getElementById('cards-dynamic');
        const timerSpan = document.getElementById('timer');
        const refreshInterval = 10;
        let timer = refreshInterval;
        let timerInterval = null;

        function renderCards(capteurs) {
            if (!Array.isArray(capteurs) || capteurs.length === 0) {
                cardsDynamic.innerHTML = '<div style="color:#888; text-align:center; width:100%;">Aucun capteur trouvé.</div>';
                return;
            }
            cardsDynamic.innerHTML = capteurs.map(c =>
                `<div class="gradient-card">
                    <div class="gradient-card-inner">
                        <h2>${c.description ? c.description : ''}</h2>
                        <p>Capteur : ${c.nom}</p>
                        <div style="margin-top:10px;">
                            <strong>Valeur :</strong> ${c.valeur_mesure !== null ? c.valeur_mesure : 'N/A'}
                            <br>
                            <small style="color:#888;">${c.date_mesure ? 'Mesuré le ' + new Date(c.date_mesure).toLocaleString('fr-FR') : ''}</small>
                        </div>
                    </div>
                </div>`
            ).join('');
        }

        async function fetchCapteurs() {
            try {
                const res = await fetch('../Models/Check_Capteurs.php');
                const data = await res.json();
                renderCards(data);
            } catch (e) {
                cardsDynamic.innerHTML = '<div style="color:red; text-align:center; width:100%;">Erreur lors du chargement des capteurs.</div>';
            }
        }

        function startTimer() {
            timer = refreshInterval;
            timerSpan.textContent = timer;
            if (timerInterval) clearInterval(timerInterval);
            timerInterval = setInterval(() => {
                timer--;
                timerSpan.textContent = timer;
                if (timer <= 0) {
                    fetchCapteurs();
                    timer = refreshInterval;
                    timerSpan.textContent = timer;
                }
            }, 1000);
        }

        // Initialisation
        fetchCapteurs();
        startTimer();
        setInterval(fetchCapteurs, refreshInterval * 1000);
    </script>
</body>
</html>

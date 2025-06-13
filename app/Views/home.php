<?php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="Layouts/home.css">
    <script src="assets/js/loader.js"></script>
    <link rel="stylesheet" href="components/header.css">
    <link rel="stylesheet" href="components/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Modal pour graphe capteur */
        .sensor-modal-bg {
            position: fixed;
            inset: 0;
            background: rgba(201,41,128,0.10);
            backdrop-filter: blur(2px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sensor-modal-panel {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(201,41,128,0.13);
            padding: 2.2rem 2rem 1.5rem 2rem;
            min-width: 320px;
            max-width: 95vw;
            max-height: 90vh;
            text-align: center;
            color: #c92980;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        .sensor-modal-panel h2 {
            margin-bottom: 1.2rem;
            font-size: 1.2rem;
            font-weight: 700;
        }
        .sensor-modal-close {
            position: absolute;
            top: 1.2rem;
            right: 1.2rem;
            background: none;
            border: none;
            font-size: 2rem;
            color: #c92980;
            cursor: pointer;
            z-index: 10;
        }
        .sensor-modal-canvas {
            width: 100% !important;
            max-width: 600px;
            height: 320px !important;
            margin: 0 auto;
        }
        @media (max-width: 700px) {
            .sensor-modal-panel {
                padding: 1rem 0.2rem 1rem 0.2rem;
            }
            .sensor-modal-canvas {
                height: 180px !important;
            }
        }
    </style>
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
                    <p class="concert-desc">PulseWave révolutionne l'expérience sonore et visuelle en vous plongeant au cœur d'une immersion totale. Grâce à une acoustique de pointe, des jeux de lumières intelligents et une technologie connectée inédite, chaque concert, conférence ou spectacle devient un moment inoubliable. Entrez dans une nouvelle ère événementielle où chaque vibration compte.</p>
                </div>
            </section>
            
            <section class="title-section">
                <div class="content">
                    <h1 class="main-title">
                        Les données de votre salle de concert<span class="gradient-text"> mises à jour en temps réel</span>.
                    </h1>
                    <p>Prochaine actualisation dans <span id="timer">10</span> secondes</p>
                </div>
            </section>

            <section>
                <!--<div id="refresh-timer" class="refresh-timer">
                    Rafraîchissement dans <span id="timer">10</span> secondes
                </div>-->
                <div class="background-circle"></div>
                <div class="global-blur-overlay"></div>

                <div id="cards-dynamic" class="cards-row">
                    <!-- Les cartes capteurs seront injectées ici -->
                </div>
            </section>

            <section class="title-section justified-flex">
                <div class="content">
                    <h1 class="main-title">
                        <span class="gradient-text">Plus aucun secret pour vous</span>.
                    </h1>
                    <p class="dj-section-text">
                        Que vous soyez un simple visiteur ou un prestataire souhaitant proposer un évènement, le système PulseZone vous indique tout ce qu'il faut savoir sur votre lieu de fête. C'est notre devise.
                    </p>
                </div>
                <img src="../../assets/images/nightclub.jpg" alt="DJ" class="dj-image">
            </section>



        </div>
        
    </div>
    <div id="footer"></div>
    <div id="sensor-modal-root"></div>
    <script type="module">
        import { renderHeader, initHeaderScripts } from '/APP-ProjetCommun/app/Views/components/header.js';
        import { renderFooter } from '/APP-ProjetCommun/app/Views/components/footer.js';

        document.getElementById('header').innerHTML = renderHeader();
        initHeaderScripts();

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
            cardsDynamic.innerHTML = capteurs.map((c, i) =>
                `<div class="gradient-card" data-id="${c.id_objet}" style="cursor:pointer;">

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
            // Ajoute l'écouteur pour ouvrir le modal
            document.querySelectorAll('.gradient-card').forEach(card => {
                card.addEventListener('click', () => {
                    const id = card.getAttribute('data-id');
                    openSensorModal(id);
                });
            });

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

        let sensorChartModal = null;

        async function openSensorModal(id_objet) {
            // Récupère les données du capteur (historique)
            const res = await fetch('../Models/Get_Capteur_Stats.php');
            const capteurs = await res.json();
            const capteur = capteurs.find(c => c.id_objet == id_objet);
            if (!capteur) return;

            // Crée le modal
            const modalRoot = document.getElementById('sensor-modal-root');
            modalRoot.innerHTML = `
                <div class="sensor-modal-bg">
                    <div class="sensor-modal-panel">
                        <button class="sensor-modal-close" aria-label="Fermer">&times;</button>
                        <h2>${capteur.description || capteur.nom}</h2>
                        <canvas id="sensorModalChart" class="sensor-modal-canvas"></canvas>
                    </div>
                </div>
            `;

            // Fermer le modal
            modalRoot.querySelector('.sensor-modal-close').onclick = closeSensorModal;
            modalRoot.querySelector('.sensor-modal-bg').onclick = (e) => {
                if (e.target.classList.contains('sensor-modal-bg')) closeSensorModal();
            };

            // Affiche le graphe
            const ctx = document.getElementById('sensorModalChart').getContext('2d');
            const labels = capteur.mesures.map(m => m.date);
            const data = capteur.mesures.map(m => parseFloat(m.valeur));
            if (sensorChartModal) sensorChartModal.destroy();
            sensorChartModal = new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: capteur.description || capteur.nom,
                        data,
                        borderColor: 'rgb(201,41,128)',
                        backgroundColor: 'rgba(201,41,128,0.08)',
                        tension: 0.2,
                        pointRadius: 2,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: { display: true, title: { display: true, text: 'Date' } },
                        y: { display: true, title: { display: true, text: capteur.unite || '' } }
                    }
                }
            });
        }

        function closeSensorModal() {
            document.getElementById('sensor-modal-root').innerHTML = '';
            if (sensorChartModal) {
                sensorChartModal.destroy();
                sensorChartModal = null;
            }
        }


        // Initialisation
        fetchCapteurs();
        startTimer();
        setInterval(fetchCapteurs, refreshInterval * 1000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>

<?php
?>

<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panel Capteurs</title>
    <link rel="stylesheet" href="Layouts/home.css">
    <link rel="stylesheet" href="components/header.css">
    <link rel="stylesheet" href="components/footer.css">
    <link rel="stylesheet" href="Layouts/sensor-panel.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div id="header"></div>
    <main class="main-content">
        <section class="sensor-panel-section">
            <div id="sensor-buttons" style="display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:2rem;"></div>
            <div id="sensor-graph" style="width:100%; max-width:700px; margin:auto;">
                <canvas id="sensorChart"></canvas>
            </div>
            <div id="sensor-actions" class="sensor-actions">
                <button class="sensor-action-btn" id="btn-clear-data">🗑️ Effacer toutes les données</button>
                <button class="sensor-action-btn" id="btn-rename-sensor">✏️ Renommer</button>
                <button class="sensor-action-btn" id="btn-add-data">➕ Ajouter une donnée</button>
            </div>
        </section>
    </main>
    <div id="footer"></div>
    <script type="module">
        import { renderHeader, initHeaderScripts } from '/APP-ProjetCommun/app/Views/components/header.js';
        import { renderFooter } from '/APP-ProjetCommun/app/Views/components/footer.js';

        document.getElementById('header').innerHTML = renderHeader();
        initHeaderScripts();
        document.getElementById('footer').innerHTML = renderFooter();

        // --- Capteurs dynamiques ---
        let capteursData = [];
        let chart = null;
        let currentSensorId = null;

        async function fetchCapteursStats() {
            const res = await fetch('../Models/Get_Capteur_Stats.php');
            capteursData = await res.json();
            renderSensorButtons();
            if (capteursData.length > 0) showSensorGraph(capteursData[0].id_objet);
        }

        function renderSensorButtons() {
            const container = document.getElementById('sensor-buttons');
            container.innerHTML = capteursData.map(c =>
                `<button class="sensor-btn" data-id="${c.id_objet}" style="padding:0.7rem 1.3rem; border-radius:1rem; background:linear-gradient(90deg, rgb(201,41,128), rgb(247,130,52)); color:#fff; border:none; font-weight:600; font-size:1rem; cursor:pointer;">
                    ${c.description ? c.description : c.nom}
                </button>`
            ).join('');
            document.querySelectorAll('.sensor-btn').forEach(btn => {
                btn.addEventListener('click', () => showSensorGraph(btn.dataset.id));
            });
        }

        function showSensorGraph(id_objet) {
            currentSensorId = id_objet;
            const capteur = capteursData.find(c => c.id_objet == id_objet);
            if (!capteur) return;
            const ctx = document.getElementById('sensorChart').getContext('2d');
            const labels = capteur.mesures.map(m => m.date);
            const data = capteur.mesures.map(m => parseFloat(m.valeur));
            if (chart) chart.destroy();
            chart = new Chart(ctx, {
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

        // Actions
        document.addEventListener('click', async (e) => {
            if (e.target.id === 'btn-clear-data') {
                showModalConfirm(
                    "Effacer toutes les données ?",
                    "Cette action est irréversible. Êtes-vous sûr de vouloir tout supprimer ?",
                    async () => {
                        await fetch('../Models/Clear_Capteur_Data.php?id=' + currentSensorId, {method: 'POST'});
                        fetchCapteursStats();
                        closeModal();
                    }
                );
            }
            if (e.target.id === 'btn-rename-sensor') {
                showModalForm(
                    "Renommer le capteur",
                    `<input type="text" id="new-sensor-name" placeholder="Nouveau nom">`,
                    async () => {
                        const val = document.getElementById('new-sensor-name').value;
                        if(val.trim()) {
                            await fetch('../Models/Rename_Capteur.php?id=' + currentSensorId + '&name=' + encodeURIComponent(val), {method: 'POST'});
                            fetchCapteursStats();
                            closeModal();
                        }
                    }
                );
            }
            if (e.target.id === 'btn-add-data') {
                showModalForm(
                    "Ajouter une donnée",
                    `<label>Valeur : <input type="number" id="new-sensor-value" step="any"></label>
                     <label>Date (optionnel) : <input type="datetime-local" id="new-sensor-date"></label>`,
                    async () => {
                        const val = document.getElementById('new-sensor-value').value;
                        const date = document.getElementById('new-sensor-date').value;
                        if(val.trim()) {
                            await fetch('../Models/Add_Capteur_Data.php', {
                                method: 'POST',
                                headers: {'Content-Type': 'application/json'},
                                body: JSON.stringify({id: currentSensorId, valeur: val, date: date})
                            });
                            fetchCapteursStats();
                            closeModal();
                        }
                    }
                );
            }
        });

        // Modal helpers
        function showModalConfirm(title, message, onConfirm) {
            showModal(title, `<p>${message}</p>`, onConfirm);
        }
        function showModalForm(title, formHtml, onConfirm) {
            showModal(title, `<form onsubmit="return false;">${formHtml}</form>`, onConfirm);
        }
        function showModal(title, content, onConfirm) {
            closeModal();
            const modal = document.createElement('div');
            modal.className = 'modal-bg';
            modal.innerHTML = `
                <div class="modal-panel">
                    <h2>${title}</h2>
                    <div>${content}</div>
                    <div class="modal-actions">
                        <button class="cancel" type="button">Annuler</button>
                        <button class="confirm" type="button">Valider</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            modal.querySelector('.cancel').onclick = closeModal;
            modal.querySelector('.confirm').onclick = onConfirm;
        }
        function closeModal() {
            document.querySelectorAll('.modal-bg').forEach(m => m.remove());
        }

        fetchCapteursStats();
    </script>
</body>
</html>
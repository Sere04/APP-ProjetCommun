<?php
session_start();
if (!isset($_SESSION['Permission']) || $_SESSION['Permission'] === 'Utilisateur') {
    echo '<script>
        alert("Accès interdit.");
        window.location.href = "home.php"; 
    </script>';
    exit;
}
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
    <section class="main-content">
        <section class="sensor-panel-section">
            <h2 style="margin-bottom:1.5rem;">Gestion des capteurs</h2>
            <div id="sensor-buttons" style="display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:2rem;"></div>
            <div id="sensor-graph" style="width:100%; max-width:700px; margin:auto;">
                <canvas id="sensorChart"></canvas>
            </div>
            <div id="sensor-actions" class="sensor-actions">
                <button class="sensor-action-btn" id="btn-clear-data">🗑️ Effacer toutes les données</button>
                <button class="sensor-action-btn" id="btn-rename-sensor">✏️ Renommer</button>
                <button class="sensor-action-btn" id="btn-add-data">➕ Ajouter une donnée</button>
            </div>
            <div id="sensor-backup-actions" class="sensor-actions">
                <button class="sensor-action-btn" id="btn-backup">💾 Sauvegarder ce graphe</button>
                <button class="sensor-action-btn" id="btn-restore" disabled>Aucune backup disponible</button>
            </div>
        </section>

        <section class="sensor-panel-section" style="min-height:unset;">
            <h2 style="margin-bottom:1.5rem;">Gestion des utilisateurs</h2>
            <div id="user-table-container"></div>
            <button class="sensor-action-btn" id="btn-add-user" style="margin-top:1.5rem;">➕ Ajouter un utilisateur</button>
        </section>
</section>

</section>

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


    document.addEventListener('DOMContentLoaded', () => {
        if (window.userRole === 'Administrateur') {
            // Accès complet
        } else if (window.userRole === 'Modérateur') {
            // On masque la section des utilisateurs
            const userSection = document.querySelector('section:nth-of-type(2)');
            if (userSection) userSection.style.display = 'none';
        } else {
            window.location.href = 'home.php';
        }
    });
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
            updateBackupButtons();
        }

        async function updateBackupButtons() {
            const backupBtn = document.getElementById('btn-backup');
            const restoreBtn = document.getElementById('btn-restore');
            restoreBtn.disabled = true;
            restoreBtn.textContent = "Aucune backup disponible";
            if (!currentSensorId) return;
            // Vérifie s'il existe une backup
            const res = await fetch('../Models/Get_Backup_Info.php?id=' + currentSensorId);
            const info = await res.json();
            if (info.hasBackup) {
                restoreBtn.disabled = false;
                restoreBtn.textContent = "Restaurer la backup du " + new Date(info.date).toLocaleString('fr-FR');
            }
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
            if (e.target.id === 'btn-backup') {
                if (!currentSensorId) return;
                const res = await fetch('../Models/Backup_Capteur.php?id=' + currentSensorId);
                const data = await res.json();
                alert(data.message);
                updateBackupButtons();
            }
            if (e.target.id === 'btn-restore') {
                if (!currentSensorId) return;
                if (confirm("Restaurer la dernière backup ? Les données actuelles seront remplacées.")) {
                    const res = await fetch('../Models/Restore_Capteur.php?id=' + currentSensorId);
                    const data = await res.json();
                    alert(data.message);
                    fetchCapteursStats();
                    updateBackupButtons();
                }
            }
        });

        // --- Gestion utilisateurs ---
        const userTableContainer = document.getElementById('user-table-container');
        const permissionOptions = ['Utilisateur','Modérateur','Administrateur'];

        async function fetchUsers() {
            const res = await fetch('../Models/Manage_Users.php?action=list');
            const users = await res.json();
            renderUserTable(users);
        }
        function renderUserTable(users) {
            userTableContainer.innerHTML = `
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>ID</th><th>Prénom</th><th>Nom</th><th>Email</th><th>Pseudo</th><th>Tél</th>
                            <th>Permission</th><th>Vérifié</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${users.map(u=>`
                        <tr>
                            <td data-label="ID">${u.IDUser}</td>
                            <td data-label="Prénom"><input type="text" value="${u.firstName}" data-field="firstName" data-id="${u.IDUser}" style="width:90px"></td>
                            <td data-label="Nom"><input type="text" value="${u.lastName}" data-field="lastName" data-id="${u.IDUser}" style="width:90px"></td>
                            <td data-label="Email"><input type="email" value="${u.mailUser}" data-field="mailUser" data-id="${u.IDUser}" style="width:160px"></td>
                            <td data-label="Pseudo"><input type="text" value="${u.userName}" data-field="userName" data-id="${u.IDUser}" style="width:90px"></td>
                            <td data-label="Tél"><input type="text" value="${u.phoneNumber||''}" data-field="phoneNumber" data-id="${u.IDUser}" style="width:90px"></td>
                            <td data-label="Permission">
                                <select data-field="Permission" data-id="${u.IDUser}">
                                    ${permissionOptions.map(p=>`<option value="${p}" ${u.Permission===p?'selected':''}>${p}</option>`).join('')}
                                </select>
                            </td>
                            <td data-label="Vérifié">
                                <input type="checkbox" data-field="is_verified" data-id="${u.IDUser}" ${u.is_verified==1?'checked':''}>
                            </td>
                            <td data-label="Actions">
                                <button class="sensor-action-btn" data-action="save" data-id="${u.IDUser}" style="padding:0.2rem 0.7rem;font-size:0.95rem;">💾</button>
                                <button class="sensor-action-btn" data-action="changepass" data-id="${u.IDUser}" style="padding:0.2rem 0.7rem;font-size:0.95rem;">🔑</button>
                                <button class="sensor-action-btn" data-action="delete" data-id="${u.IDUser}" style="padding:0.2rem 0.7rem;font-size:0.95rem;background:#eee;color:#c92980;">🗑️</button>
                            </td>
                        </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;
        }

        userTableContainer.addEventListener('change', async e => {
            const id = e.target.dataset.id;
            const field = e.target.dataset.field;
            if (!id || !field) return;
            let value = e.target.type === 'checkbox' ? (e.target.checked ? 1 : 0) : e.target.value;
            await fetch('../Models/Manage_Users.php?action=update', {
                method: 'POST',
                body: JSON.stringify({IDUser:id, [field]:value}),
                headers: {'Content-Type':'application/json'}
            });
            fetchUsers();
        });

        userTableContainer.addEventListener('click', async e => {
            const btn = e.target.closest('button[data-action]');
            if (!btn) return;
            const id = btn.dataset.id;
            if (btn.dataset.action === 'delete') {
                if (confirm("Supprimer cet utilisateur ?")) {
                    await fetch('../Models/Manage_Users.php?action=delete', {
                        method: 'POST',
                        body: new URLSearchParams({id}),
                        headers: {'Content-Type':'application/x-www-form-urlencoded'}
                    });
                    fetchUsers();
                }
            }
            if (btn.dataset.action === 'save') {
                // Les changements sont déjà auto-sauvegardés sur change, donc rien à faire ici
                alert("Modifications sauvegardées !");
            }
            if (btn.dataset.action === 'changepass') {
                showModalForm(
                    "Changer le mot de passe",
                    `<input type="password" id="new-user-pass" placeholder="Nouveau mot de passe">`,
                    async () => {
                        const pass = document.getElementById('new-user-pass').value;
                        if(pass.length<8) { alert("Mot de passe trop court"); return; }
                        await fetch('../Models/Manage_Users.php?action=changepass', {
                            method: 'POST',
                            body: JSON.stringify({IDUser:id, motDePasse:pass}),
                            headers: {'Content-Type':'application/json'}
                        });
                        closeModal();
                        alert("Mot de passe changé !");
                    }
                );
            }
        });

        document.getElementById('btn-add-user').onclick = () => {
            showModalForm(
                "Ajouter un utilisateur",
                `<input type="text" id="add-fn" placeholder="Prénom"><br>
                 <input type="text" id="add-ln" placeholder="Nom"><br>
                 <input type="email" id="add-mail" placeholder="Email"><br>
                 <input type="text" id="add-username" placeholder="Pseudo"><br>
                 <input type="text" id="add-phone" placeholder="Téléphone"><br>
                 <input type="password" id="add-pass" placeholder="Mot de passe"><br>
                 <select id="add-perm">${permissionOptions.map(p=>`<option value="${p}">${p}</option>`)}</select>`,
                async () => {
                    const data = {
                        firstName: document.getElementById('add-fn').value,
                        lastName: document.getElementById('add-ln').value,
                        mailUser: document.getElementById('add-mail').value,
                        userName: document.getElementById('add-username').value,
                        phoneNumber: document.getElementById('add-phone').value,
                        motDePasse: document.getElementById('add-pass').value,
                        Permission: document.getElementById('add-perm').value
                    };
                    if (!data.firstName || !data.lastName || !data.mailUser || !data.userName || !data.motDePasse) {
                        alert("Tous les champs obligatoires !");
                        return;
                    }
                    await fetch('../Models/Manage_Users.php?action=add', {
                        method: 'POST',
                        body: JSON.stringify(data),
                        headers: {'Content-Type':'application/json'}
                    });
                    closeModal();
                    fetchUsers();
                }
            );
        };

        function closeModal() {
            const m = document.querySelector('.modal-bg');
            if (m) m.remove();
        }

        function showModalForm(title, html, onValidate) {
            closeModal();
            const modal = document.createElement('div');
            modal.className = 'modal-bg';
            modal.innerHTML = `
                <div class="modal-panel">
                    <h2>${title}</h2>
                    <form onsubmit="return false;" style="margin:0;">
                        <div>${html}</div>
                        <div class="modal-actions">
                            <button type="submit" class="validate">Valider</button>
                            <button type="button" class="cancel">Annuler</button>
                        </div>
                    </form>
                </div>
            `;
            document.body.appendChild(modal);
            modal.querySelector('.cancel').onclick = closeModal;
            modal.querySelector('form').onsubmit = async (e) => {
                e.preventDefault();
                await onValidate();
            };
        }

        function showModalConfirm(title, html, onValidate) {
            closeModal();
            const modal = document.createElement('div');
            modal.className = 'modal-bg';
            modal.innerHTML = `
                <div class="modal-panel">
                    <h2>${title}</h2>
                    <div>${html}</div>
                    <div class="modal-actions">
                        <button class="validate">Oui</button>
                        <button class="cancel">Annuler</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            modal.querySelector('.cancel').onclick = closeModal;
            modal.querySelector('.validate').onclick = async () => {
                await onValidate();
            };
        }

        fetchCapteursStats();
        fetchUsers();
    </script>
</body>
</html>
// Composant d'alerte latérale rouge
export function showSideAlert(message) {
    // Injecte le CSS une seule fois
    if (!document.getElementById('side-alert-modal-css')) {
        const style = document.createElement('style');
        style.id = 'side-alert-modal-css';
        style.textContent = `
.side-alert-modal {
    position: fixed;
    top: 40px;
    right: 30px;
    z-index: 9999;
    background: #e53935;
    color: #fff;
    padding: 1.2rem 2.2rem 1.2rem 1.5rem;
    border-radius: 1.2rem 0.7rem 0.7rem 1.2rem;
    box-shadow: 0 8px 32px 0 rgba(229,57,53,0.18);
    font-size: 1.15rem;
    font-weight: 600;
    min-width: 220px;
    max-width: 90vw;
    opacity: 0;
    transform: translateX(120%);
    transition: opacity 0.3s, transform 0.3s;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.side-alert-modal.show {
    opacity: 1;
    transform: translateX(0);
}
@media (max-width: 600px) {
    .side-alert-modal {
        right: 5vw;
        left: 5vw;
        min-width: unset;
        max-width: 90vw;
        font-size: 1rem;
        padding: 1rem 1.2rem;
        border-radius: 1rem;
    }
}
        `;
        document.head.appendChild(style);
    }
    // Supprime les anciens si présents
    document.querySelectorAll('.side-alert-modal').forEach(e => e.remove());
    const div = document.createElement('div');
    div.className = 'side-alert-modal';
    div.innerHTML = `<span>⚠️</span> <span>${message}</span>`;
    document.body.appendChild(div);
    // Animation d'entrée
    setTimeout(() => div.classList.add('show'), 10);
    // Disparition auto
    setTimeout(() => {
        div.classList.remove('show');
        setTimeout(() => div.remove(), 300);
    }, 5000);
}

// Composant de succès latéral vert
export function showSideSuccess(message) {
    // Injecte le CSS une seule fois
    if (!document.getElementById('side-success-modal-css')) {
        const style = document.createElement('style');
        style.id = 'side-success-modal-css';
        style.textContent = `
.side-success-modal {
    position: fixed;
    top: 40px;
    right: 30px;
    z-index: 9999;
    background:rgb(0, 150, 75);
    color: #fff;
    padding: 1.2rem 2.2rem 1.2rem 1.5rem;
    border-radius: 1.2rem 0.7rem 0.7rem 1.2rem;
    box-shadow: 0 8px 32px 0 rgba(229,57,53,0.18);
    font-size: 1.15rem;
    font-weight: 600;
    min-width: 220px;
    max-width: 90vw;
    opacity: 0;
    transform: translateX(120%);
    transition: opacity 0.3s, transform 0.3s;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.side-success-modal.show {
    opacity: 1;
    transform: translateX(0);
}
@media (max-width: 600px) {
    .side-success-modal {
        right: 5vw;
        left: 5vw;
        min-width: unset;
        max-width: 90vw;
        font-size: 1rem;
        padding: 1rem 1.2rem;
        border-radius: 1rem;
    }
}
        `;
        document.head.appendChild(style);
    }
    // Supprime les anciens si présents
    document.querySelectorAll('.side-success-modal').forEach(e => e.remove());
    const div = document.createElement('div');
    div.className = 'side-success-modal';
    div.innerHTML = `<span>☑️</span> <span>${message}</span>`;
    document.body.appendChild(div);
    // Animation d'entrée
    setTimeout(() => div.classList.add('show'), 10);
    // Disparition auto
    setTimeout(() => {
        div.classList.remove('show');
        setTimeout(() => div.remove(), 300);
    }, 5000);
}


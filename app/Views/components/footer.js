export function renderFooter() {
    return `
    <link rel="stylesheet" href="/app/Views/components/footer.css">
    <footer class="main-footer glass-effect">
        <div class="footer-logo">
            <img src="../../assets/images/Logo.png" alt="Icône PulseZone" class="footer-logo-img" >
        </div>
        <div class="footer-infos">
            <p>PulseZone</p>


            <p>© 2025, <a href="#" class="underline">GNU v3.0</a></p>
        </div>
        <ul class="footer-links">
            <li><a href="#">Nous contacter</a></li>
            <li><a href="../Views/legalNotice.html">Mentions légales</a></li>
            <li><a href="#">Cookies</a></li>
            <li><a href="#">CGU</a></li>
            <li><a href="#">CGPS</a></li>
            <li><a href="#">FAQ</a></li>
        </ul>
    </footer>
    <script src="https://kit.fontawesome.com/c54f418805.js" crossorigin="anonymous"></script>
    `;
}
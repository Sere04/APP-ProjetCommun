<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mentions légales</title>
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
    <h1>Mentions légales</h1>

    <div class="notice-section">
        <h2>Identification et Activités</h2>

        <p>Société PulseZone</p>
        <ul>
            <li>10 Rue de Vanves, 92130 Issy-les-Moulineaux, France</li>
            <li>Téléphone : +33 (0)1 49 54 82 00</li>
            <li>Mail : contact@pulsezon.fr</li>
            <li>Site : <a class="website-link" href="">https://www.pulseZone.fr</a></li>
            <li>PulseZone est une SASU au capital de 1 000€</li>
            <li>RCS : X XXX XXX XXX</li>
            <li>Siret : XXX XXX XXX XXXXX - APE : XXXXX</li>
        </ul>
    </div>

    <div class="notice-section">
        <h2>Conditions d'Utilisation</h2>
        <p>
            L'utilisation de ce Site est régie par les présentes conditions générales.
            En se connectant sur ce Site, les internautes (ci-après nommés « Utilisateurs »), reconnaissent avoir pris connaissance des présentes conditions et les acceptent sans réserve.
            Celles-ci pourront être modifiées à tout moment et sans préavis par PulseZone. PulseZone ne saurait être tenu pour responsable en aucune manière d'une mauvaise utilisation du service.
        </p>
    </div>

    <div class="notice-section">
        <h2>Propriété Intellectuelle</h2>
        <p>
            Ce site et son contenu sont protégés, au sens du Code de la propriété intellectuelle, en particulier par les droits d'auteur, dessins et modèles et droits des marques.
            En application du Code de la propriété Intellectuelle et, plus généralement, des traités et accords internationaux comportant des dispositions relatives à la protection des droits d'auteurs,
            il est interdit de reproduire pour un usage autre que privé, vendre, distribuer, émettre, diffuser, adapter, modifier, publier, communiquer intégralement ou partiellement, sous quelque forme que ce soit,
            les données, la présentation ou l'organisation du site ou les œuvres protégées par le droit d'auteur qui figurent sur le Site sans autorisation écrite particulière et préalable du détenteur
            du droit d'auteur attaché à l'œuvre, à la présentation ou à l'organisation du site ou à la donnée reproduite.
            Le non-respect de cette interdiction constitue une contrefaçon pouvant engager la responsabilité civile et pénale du contrefacteur.
            Pour toute demande d'autorisation ou d'information, merci de nous contacter par courriel : contact@pulsezone.fr.
        </p>
    </div>

    <div class="notice-section">
        <h2>Cookies</h2>
        <p>
            L'Utilisateur est informé que lors de ses visites sur le Site, un cookie peut s'installer automatiquement sur son logiciel de navigation.
            Un cookie est un bloc de données qui ne permet pas d'identifier l'Utilisateur mais sert à enregistrer des informations relatives à la navigation de celui-ci sur le site.
            L'Utilisateur accepte l'utilisation de cookies en naviguant sur le Site.
            La durée de validité du consentement donné dans ce cadre est de 13 mois maximum.
            L'Utilisateur pourra désactiver ce cookie par l'intermédiaire des paramètres figurant dans son logiciel de navigation.
        </p>
    </div>

    <div class="notice-section">
        <h2>Données Personnelles</h2>
        <p>
            En vertu de la loi Informatique et Libertés du 6 janvier 1978, PulseZone informe les Utilisateurs de son Site que les données à caractère nominatif recueillies
            par l'intermédiaire d'un formulaire de contact sont confidentielles, elles sont destinées à PulseZone et ne sauraient être transmises à des tiers hormis pour la
            bonne exécution d'une prestation commandée par l'Utilisateur. Aucune des informations données par l'Utilisateur sur le Site n'est obligatoire.
            Conformément à la loi Informatique et Libertés du 6 janvier 1978, l'Utilisateur peut à tout moment accéder aux informations personnelles
            le concernant détenues par PulseZone, demander leur modification ou leur suppression. Ainsi, il peut, à titre irrévocable, demander que soient rectifiées,
            complétées, clarifiées, mises à jour ou effacées les informations le concernant qui sont inexactes, incomplètes, équivoques, périmées ou dont la collecte ou l'utilisation, la communication ou la conservation est interdite.
            Pour exercer ses droits, l'Utilisateur peut :

            <ul>
                <li>Envoyer un courrier à : Société PulseZone, 10 Rue de Vanves, 92130 Issy-les-Moulineaux, France</li>
                <li>Téléphoner au : +33 (0)8 203 203 63</li>
            </ul>
        </p>
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

<?php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" href="../Views/components/footer.css">
    <link rel="stylesheet" href="../Views/Layouts/ContactPageCSS.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
         <button type="button" class="go-to-home-button" onclick="window.location.href = '../Views/home.php';">Accueil</button>
    <div class="container container-contact">
        <div class="contact">
            <h1 class="contact-h1">Contact</h1>
            <div class="background-circle"></div>
            <div class="background-circle-bas"></div>  
             <?php if (!empty($errors)) : ?>
            <div class="error-container">
                <?php foreach ($errors as $error): ?>
                    <div class="wrong-contact">
                        <?= $error ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?> 
            <form action="" class="form contact-form" method="post" id="contactForm">
                <div class="form-control">
                    <label for="name">Nom<span class="required">*</span></label>
                    <input type="text" id="name" placeholder="Votre nom..." name="name" required>
                </div>

                <div class="form-control">
                    <label for="email">Email<span class="required">*</span></label>
                    <input type="email" id="email" placeholder="Votre email..." name="email" required>
                </div>

                <div class="form-control">
                    <label for="message">Message<span class="required">*</span></label>
                    <textarea  type="text" id="message" placeholder="Votre message..." name="message" required></textarea>
                </div>

                <div class="button-group">
                    <div class="button submit-button">
                        <input type="submit" class="btn submit" value="Envoyer"/>
                    </div>
                </div>
            </form>
            <div class="contact-info">
                <h2>Informations de contact</h2>
                <p style="font-size:12px"><i class="fas fa-envelope"></i> Email: <a href="mailto:pulsezonecompany@gmail.com"> pulsezonecompany@gmail.com  </a>
            </div>
                <p style="font-size:12px"><i class="fas fa-phone"></i> Téléphone: <a href="tel:+123456789">+33 1 49 54 82 00</a></p>
                <p style="font-size:12px"><i class="fas fa-map-marker-alt"></i> Adresse: 110 Rue de Vanves, 92130 Issy-les-Moulineaux, France</p>
            </div>
        </div>
    </div>
    <div id="footer" style="width:100%"></div>

    <script type="module">
        import { renderFooter } from '/../APP-ProjetCommun/app/Views/components/footer.js';
        document.getElementById('footer').innerHTML = renderFooter();
    </script>
</body>
</html>
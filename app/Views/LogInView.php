<?php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<link rel="stylesheet" href="../Views/Layouts/LogInCSS.css">
</head>
<body>
<div class="container container-sign-up">
    <div class="sign-up">
        <h1>Connexion</h1>
        <div class="background-circle"></div>
        <div class="background-circle-bas"></div>

        <?php if (!empty($errors)) : ?>
            <div class="error-container" style="margin-bottom: 1rem;">
                <?php foreach ($errors as $error): ?>
                    <div class="wrong-signup">
                        <?= $error ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="" class="form sign-up-form" method="post" id="loginForm">
            
            <div class="form-control">
                <label for="emailOrUsername">Email ou Pseudonyme<span class="required">*</span></label>
                <input type="text" id="emailOrUsername" placeholder="Votre email ou pseudo..." name="emailOrUsername" required>
            </div>

            <div class="form-control">
                <label for="password">Mot de passe<span class="required">*</span></label>
                <input id="password" type="password" placeholder="Votre mot de passe..." required name="password">
                <span class="eye-span signup-eye">
                    <i class="fa-solid fa-eye" aria-hidden="true" type="button" id="eye-login"></i>
                </span>
            </div>
            
            <div class="button-group" style="margin-top: 1.5rem;">
               <span style="margin-left: 37%;font-size: 12px;">
                    <a class="forgot-password-link" href="../Controllers/SignUp.php">Mot de passe oublié ?</a>
                </span> 
                <div class="button signup-button">
                    <input type="submit" class="btn submit" value="Se connecter"/>
                </div>
                <div class="button go-login-button">
                    <button type="button" class="button go-to-login-button" onclick="window.location.href = 'signUp.php';">Créer un compte</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="../Views/Layouts/LogInJS.js"></script>
 </body>
</html>

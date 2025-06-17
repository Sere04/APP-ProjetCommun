<?php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<link rel="stylesheet" href="../Views/Layouts/SignUpCSS.css">
</head>
<body>
<div class="container container-sign-up">
    <div class="sign-up">
        <h1>Modification mot de passe</h1>
        <div class="background-circle"></div>
        <div class="background-circle-bas"></div>

        <?php if (!empty($errors)) : ?>
            <div class="error-container" style="margin-bottom: 1rem;">
                <?php foreach ($errors as $error): ?>
                    <div class="wrong-login">
                        <?= $error ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="" class="form sign-up-form" method="post" id="loginForm">
            
            <div class="form-control">
                <label for="emailOrUsername">Email ou Pseudonyme<span class="required">*</span></label>
                <input type="text" id="emailOrUsername" placeholder="Votre email ou pseudo..." name="emailOrUsername" >
            </div>

               <div class="form-control">
                <label for="password" id="passwordLabel">Mot de passe<span class="required">*</span> <i class="fa-solid fa-circle-question" id="passwordInfo"></i></label>
                <input id="password" type="password" placeholder="Votre mot de passe..." name="motDePasse">
                <span class="tooltip" id="password-tooltip">
                    Le mot de passe doit contenir :
                    <ul>
                      <li>Au moins 8 caractères</li>
                      <li>Une lettre majuscule</li>
                      <li>Une lettre minuscule</li>
                      <li>Un chiffre</li>
                      <li>Un caractère spécial (!@#$%^&*.)</li>
                    </ul>
                </span>
                <span class="eye-span signup-eye">
                    <i class="fa-solid fa-eye" aria-hidden="true" type="button" id="eye"></i>
                </span>
            </div>

            <div class="form-control">
                <label for="passwordConfirmation">Confirmez le mot de passe<span class="required">*</span></label>
                <input id="passwordConfirmation" type="password" placeholder="Votre mot de passe..." name="motDePasseConfirmed">
                <span class="eye-span signup-eye">
                    <i class="fa-solid fa-eye" aria-hidden="true" type="button" id="eye1"></i>
                </span>
            </div>
            
            <div class="button-group" style="margin-top: 1.5rem;">
                <div class="button signup-button">
                    <input type="submit" class="btn submit" value="Modifier" id="submitForm"/>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="../Views/Layouts/SignUpJS.js"></script>
 </body>
</html>

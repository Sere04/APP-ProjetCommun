<?php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="../Views/Layouts/SignUpCSS.css">
</head>
<body>
     <button type="button" class="go-to-home-button" onclick="window.location.href = 'index.php';">Accueil</button>
<div class="container container-sign-up">
    <div class="sign-up">
        <div class="background-circle"></div>
        <div class="background-circle-bas"></div>
       

        <?php if (!empty($errors)) : ?>
            <div class="error-container">
                <?php foreach ($errors as $error): ?>
                    <div class="wrong-signup">
                        <?= $error ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="" class="form sign-up-form" method="post" id="myForm">
             <h1>Inscription</h1>
            <p class="required required-signup">* champs obligatoires</p>
            <div class="form-control">
                <label for="fName">Prénom<span class="required">*</span></label>
                <input type="text" id="fName" maxlength="50" placeholder="Votre prénom..." name="prenom">
            </div>

            <div class="form-control">
                <label for="lName">Nom de famille<span class="required">*</span></label>
                <input type="text" id="lName" maxlength="50" placeholder="Votre nom..." name="nom">
            </div>
            
            <div class="form-control">
                <label for="username">Pseudonyme<span class="required">*</span></label>
                <input type="text" id="username" maxlength="30" placeholder="Votre pseudonyme..." name="pseudonyme">
            </div>

            <div class="form-control">
                <label for="email">Email<span class="required">*</span></label>
                <input id="email" maxlength="255" placeholder="Votre email..." type="email" name="email">
                <div id="emailError" class="wrong-signup" style="display: none;"></div>
            </div>

            <div class="form-control">
                <label for="tel">Téléphone</label>
                <input type="text" id="tel" maxlength="13" placeholder="+33 6 12 34 56 78" name="telephone">
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

            <div class="button-group">
                <div class="button signup-button">
                    <input type="submit" class="btn submit" value="S'inscrire" id="submitForm"/>
                </div>
                <div class="button go-login-button">
                    <button type="button" class="button go-to-login-button" onclick="window.location.href = 'log-in.php';">Se connecter</button>
                </div>
            </div>
        </form>
    </div>
</div>
                </body>
</html>



<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const passwordInfoIcon = document.getElementById('passwordInfo');
        const passwordTooltip = document.getElementById('password-tooltip');

        if (passwordInfoIcon && passwordTooltip) {
            passwordInfoIcon.addEventListener('click', () => {
                passwordTooltip.style.display = (passwordTooltip.style.display === 'block') ? 'none' : 'block';
            });
        }
        
        const setupPasswordToggle = (eyeId, inputId) => {
            const eye = document.getElementById(eyeId);
            const input = document.getElementById(inputId);

            if (eye && input) {
                eye.addEventListener('click', () => {
                    if (input.type === 'password') {
                        input.type = 'text';
                        eye.classList.remove('fa-eye');
                        eye.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        eye.classList.remove('fa-eye-slash');
                        eye.classList.add('fa-eye');
                    }
                });
            }
        };

        setupPasswordToggle('eye', 'password');
        setupPasswordToggle('eye1', 'passwordConfirmation');
    });
</script>
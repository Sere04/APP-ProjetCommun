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
                <input type="text" id="fName" maxlength="50" placeholder="Votre prénom..." name="prenom" required>
            </div>

            <div class="form-control">
                <label for="lName">Nom de famille<span class="required">*</span></label>
                <input type="text" id="lName" maxlength="50" placeholder="Votre nom..." name="nom" required>
            </div>
            
            <div class="form-control">
                <label for="username">Pseudonyme<span class="required">*</span></label>
                <input type="text" id="username" maxlength="30" placeholder="Votre pseudonyme..." name="pseudonyme" required>
            </div>

            <div class="form-control">
                <label for="email">Email<span class="required">*</span></label>
                <input id="email" maxlength="255" placeholder="Votre email..." required type="email" name="email">
                <div id="emailError" class="wrong-signup" style="display: none;"></div>
            </div>

            <div class="form-control">
                <label for="tel">Téléphone</label>
                <input type="text" id="tel" maxlength="13" placeholder="+33 6 12 34 56 78" name="telephone">
            </div>

            <div class="form-control">
                <label for="password" id="passwordLabel">Mot de passe<span class="required">*</span> <i class="fa-solid fa-circle-question" id="passwordInfo"></i></label>
                <input id="password" type="password" placeholder="Votre mot de passe..." required name="motDePasse">
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
                <input id="passwordConfirmation" type="password" placeholder="Votre mot de passe..." required name="motDePasseConfirmed">
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
   body {
        display: block;
        justify-content: center;
        min-height: 100vh;
        margin: 0;
        background-color: #f8f8fa;
        font-family: 'Montserrat', sans-serif;
        position: relative;
            box-sizing: border-box;
            padding: 40px 0;


    }
      .background-circle {
            position: absolute;
            width: 500px;
            height: 500px;
            top:-15%;
            left: -10%;
            background: radial-gradient(circle, rgba(201, 41, 128, 0.3), rgba(247, 130, 52, 0.3), rgba(172, 30, 163, 0.3));
            border-radius: 50%;
            filter: blur(30px);
            z-index: 1;
}
.background-circle-bas{
            position: fixed;
    bottom: 0;
    left: 90%;
    transform: translateX(-50%);
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(201, 41, 128, 0.3), rgba(247, 130, 52, 0.3), rgba(172, 30, 163, 0.3));
    border-radius: 50%;
    filter: blur(80px);
    z-index: 2;
    pointer-events: none;
    overflow: hidden;
}
     .container-sign-up {
    width: 35%;
    margin: auto;
    background-color: white;
    z-index: 1;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    box-sizing: border-box;
    }

    .sign-up h1 {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        background: linear-gradient(90deg, rgb(201,41,128) 0%, rgb(247,130,52) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .required-signup {
        text-align: left;
        color: red;
        margin-bottom: -1%;
        font-size: 0.9rem;
    }

    .sign-up-form {
        display: flex;
        flex-direction: column;
    }

    .form-control {
        position: relative;
        display: flex;
        flex-direction: column;
        margin-top:3%;
    }

    .form-control label {
        font-weight: bold;
        margin-bottom: 1%;
    }

    .form-control label .required {
        color: red;
        margin-left: 2px;
    }

    .form-control input {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 2px solid rgb(247, 130, 52);
        border-radius: 8px;
        font-size: 1rem;
        background-color: #fff;
        transition: border-color 0.3s, box-shadow 0.3s;
        box-sizing: border-box;
    }

    .form-control input:focus {
        border-color: rgb(201, 41, 128);
        box-shadow: 0 0 0 3px rgba(201, 41, 128, 0.2);
    }
    
    .eye-span {
        position: absolute;
        right: 1rem;
        top: 65%;
        transform: translateY(-50%);
        cursor: pointer;
    }

    #passwordInfo {
        cursor: pointer;
        margin-left: 0.25rem;
    }

    .tooltip {
        display: none;
        position: absolute;
        bottom: 105%;
        left: 0;
        background-color: #333;
        color: #fff;
        padding: 0.8rem;
        border-radius: 6px;
        font-size: 0.85rem;
        z-index: 10;
        width: 100%;
        box-sizing: border-box;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    
    .tooltip ul {
        margin: 0;
        padding-left: 1rem;
    }
    
    .button-group {
        margin-top: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .button input, .button button {
        width: 100%;
        padding: 0.9rem;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn.submit {
        background: rgb(247, 130, 52);
        color: white;
        border: none;
    }

    .btn.submit:hover {
        background: rgb(201, 41, 128);
    }

    .go-to-login-button {
        background: rgb(247, 130, 52);
        color: white;
        border: none;
    }

    .go-to-login-button:hover {
        background: rgb(201, 41, 128);
    }
    
    .wrong-signup {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        padding: 0.8rem 1rem;
        border-radius: 6px;
        border-left: 4px solid #dc3545;
    }
     @media (max-width: 520px) {
        .container-sign-up { padding: 2rem 1.5rem; margin: 1rem 0; }
        .sign-up h1 { font-size: 2rem; }
    }
    

</style>

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
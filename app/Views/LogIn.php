<div class="container container-sign-up">
    <div class="sign-up">
        <h1>Connexion</h1>

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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body {
        min-height: 100vh;
        margin: 0;
        background-color: #f8f8fa;
        font-family: 'Montserrat', sans-serif;
        position: relative;
        display: flex;
        flex-direction: column;
        padding: 1rem 0;
    }

    body::before {
        content: '';
        position: absolute;
        top: -15%;
        left: -20%;
        width: 80vmin;
        height: 80vmin;
        background: radial-gradient(circle, rgba(201, 41, 128, 0.5), rgba(247, 130, 52, 0.4));
        border-radius: 50%;
        filter: blur(100px);
        z-index: 0;
        opacity: 0.7;
        pointer-events: none;
    }

    .container-sign-up {
        position: relative;
        z-index: 1;
        width: 90%;
        max-width: 420px;
        padding: 2rem 2.5rem;
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
        margin: auto;
    }

    .sign-up h1 {
        text-align: center;
        font-size: clamp(1.8rem, 5vw, 2.2rem);
        font-weight: 700;
        margin: 0 0 1.5rem 0;
        background: linear-gradient(90deg, rgb(201,41,128) 0%, rgb(247,130,52) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
    }

    .sign-up-form {
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
    }

    .form-control {
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .form-control label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
        font-size: 0.95rem;
    }

    .form-control label .required {
        color: red;
        margin-left: 2px;
    }

    .form-control input {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 2px solid rgb(247, 130, 52);
        border-radius: 8px;
        font-size: 0.95rem;
        background-color: #fff;
        transition: border-color 0.3s, box-shadow 0.3s;
        box-sizing: border-box;
    }

    .form-control input:focus {
        outline: none;
        border-color: rgb(201, 41, 128);
        box-shadow: 0 0 0 3px rgba(201, 41, 128, 0.2);
    }
    
    .eye-span {
        position: absolute;
        right: 1rem;
        top: 65%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #888;
    }

    .button-group {
        margin-top: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .button input, .button button {
        width: 100%;
        padding: 0.8rem;
        border-radius: 8px;
        font-size: 1rem;
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
        .container-sign-up { 
            padding: 1.5rem 1.5rem; 
            margin: auto; 
        }
        .sign-up h1 { 
            font-size: 1.8rem; 
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
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

        setupPasswordToggle('eye-login', 'password');
    });
</script>
<div class="background-circle"></div>
<div class="background-circle-bas"></div>

<div class="container container-sign-up">
    <div class="sign-up">
        <h1>Mot de passe oublié</h1>
        <p class="form-description">Saisissez votre email. Si un compte existe, nous enverrons un lien pour réinitialiser votre mot de passe.</p>

        <?php if (!empty($successMessage)) : ?>
            <div class="success-message">
                <?= $successMessage ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)) : ?>
            <div class="error-container">
                <?php foreach ($errors as $error): ?>
                    <div class="wrong-signup">
                        <?= $error ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($successMessage)) : ?>
            <form action="" class="form sign-up-form" method="post" id="forgotPasswordForm">
                
                <div class="form-control">
                    <label for="email">Adresse email<span class="required">*</span></label>
                    <input type="email" id="email" placeholder="Votre email..." name="email" required>
                </div>
                
                <div class="button-group" style="margin-top: 1.5rem;">
                    <div class="button signup-button">
                        <input type="submit" class="btn submit" value="Envoyer le lien"/>
                    </div>
                </div>
            </form>
        <?php endif; ?>
        
        <div class="button-group" style="margin-top: 1rem;">
            <div class="button go-login-button">
                 <button type="button" class="button go-to-login-button" onclick="window.location.href = 'LogIn.php';">Retour à la connexion</button>
            </div>
        </div>
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
        overflow-x: hidden;
    }

    .background-circle {
        position: absolute;
        width: 600px;
        height: 600px;
        top: -20%;
        left: -15%;
        background: radial-gradient(circle, rgba(201, 41, 128, 0.22), rgba(247, 130, 52, 0.18), rgba(172, 30, 163, 0.18));
        border-radius: 50%;
        filter: blur(80px) brightness(1.2);
        z-index: 0;
        pointer-events: none;
    }
    .background-circle-bas{
        position: absolute;
        width: 600px;
        height: 600px;
        bottom: -20%;
        right: -15%;
        background: radial-gradient(circle, rgba(201, 41, 128, 0.22), rgba(247, 130, 52, 0.18), rgba(172, 30, 163, 0.18));
        border-radius: 50%;
        filter: blur(80px) brightness(1.2);
        z-index: 0;
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
        font-size: clamp(1.6rem, 5vw, 2rem);
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        background: linear-gradient(90deg, rgb(201,41,128) 0%, rgb(247,130,52) 50%, rgb(172,30,163) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
    }
    
    .form-description {
        text-align: center;
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 1.5rem;
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
    
    .wrong-signup, .success-message {
        padding: 0.8rem 1rem;
        border-radius: 6px;
        margin-bottom: 1rem;
    }
    
    .wrong-signup {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border-left: 4px solid #dc3545;
    }

    .success-message {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border-left: 4px solid #28a745;
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
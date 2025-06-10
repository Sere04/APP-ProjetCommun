//TODO : FONT SIZE 17PX

<div class="container container-sign-up">
    <div class="sign-up">
        <div class="background-circle"></div>
        <div class="blurred-overlay"></div>

        <?php if (!empty($errors)) : ?>

        <?php foreach ($errors as $error): ?>

        <div class="wrong-signup">
            <?= $error ?> <br/>
        </div>

        <?php endforeach; ?>

        <?php endif; ?>

        <form action="" class="form sign-up-form" method="post" id="myForm">
        <h1 id="titleInscription">Inscription</h1>
        <p class="required required-signup">*Ces champs sont obligatoires</p>
            <div class="form-row">
                <!-- first-name --->
                <div class="form-control">
                    <label for="fName">Prénom<span class="required" style="margin-right: 30.5%;">*</span></label>
                    <input type="text" id="fName" maxlength="50" placeholder="Votre prénom..." name="prenom" required>
                </div>
                <!-- last-name --->
                <div class="form-control">
                    <label for="lName">Nom de famille<span class="required" style="margin-right: 17%;">*</span></label>
                    <input type="text" id="lName" maxlength="50" placeholder="Votre nom..." name="nom" required>
                </div>
            </div>
            <!-- username --->
            <div class="form-control">
                <label for="username">Pseudonyme<span class="required" style="margin-right:22.5%;">*</span></label>
                <input type="text" id="username" maxlength="30" placeholder="Votre pseudonyme..." name="pseudonyme" required>
            </div>
            <!-- email --->
            <div class="form-control">
                <label for="email">Email<span class="required" style="margin-right: 35%;">*</span></label>
                <input id="email" maxlength="255" placeholder="Votre email..." required type="email" name="email">
                <div id="emailError" class="wrong-signup" style="display: none;"></div>  <!-- AJOUTE APRES-->
            </div>
            <!-- tel --->
            <div class="form-control">
                <label for="tel" style="margin-right: 29%;">Téléphone</label>
                <input type="text" id="tel" maxlength="13" placeholder="+33 6 12 34 56 78" name="telephone">
            </div>
            <!-- password --->
            <div class="form-control">
                <label for="password" id="passwordLabel">Mot de passe<span class="required">* </span><i style="margin-right: 17.5%;" class="fa-solid fa-circle-question" id="passwordInfo"></i></label>
                <input id="password" type="password" placeholder="Votre mot de passe..." required name="motDePasse">
                <span class="tooltip" id="password-tooltip" style="display: none;">
                    Le mot de passe doit contenir :
                    <ul>
                      <li>Au moins 8 caractères</li>
                      <li>Une lettre majuscule</li>
                      <li>Une lettre minuscule</li>
                      <li>Un chiffre</li>
                      <li>Un caractère spécial (!@#$%^&*.)</li>
                    </ul>
                  </span>
                <!-- show/hide password  -->
                <span class="eye-span signup-eye">
                <i class="fa-solid fa-eye" aria-hidden="true"  type="button" id="eye"></i>
            </span>
            </div>
            <div class="form-control">
                <label for="password" id="passwordLabelConfirmation" style="font-size:17px">Confirmez le mot de passe<span class="required">* </span></label>
                <input id="passwordConfirmation" type="password" placeholder="Votre mot de passe..." required name="motDePasseConfirmed">
                <span class="eye-span signup-eye">
                <i class="fa-solid fa-eye" aria-hidden="true"  type="button" id="eye1"></i>
            </div>
            <!-- <div class="checkbox-group">
                <input class="checkbox" type="checkbox" id="check" name="is18More">
                <label>En cochant cette case, vous confirmez avoir plus de 18 ans<span class="required">*</span></label>
            </div>
            <div class="checkbox-group">
                <input class="checkbox" type="checkbox" id="check1" name="AcceptCGU">
                <label>En cochant cette case, vous confirmez avoir lu les <a href="cgu.php">CGU</a><span class="required">*</span></label>
            </div>
            <div class="checkbox-group">
                <input class="checkbox" type="checkbox"id="check2" name="AcceptCGPS">
                <label>En cochant cette case, vous confirmez avoir lu les <a href="cgps.php">CGPS</a><span class="required">*</span></label>
            </div> -->
            <!-- submit --->
            <div class="button signup-button">
                <input type="submit" class="btn submit" value="S'inscrire" id="submitForm"/>
            </div>

        <div class="button go-login-button">
            <button class="button go-to-login-button" onclick="window.location.href = 'SignUpModele.php';">Se connecter</button>
        </div>
                </form>

    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f8fa;
            position: relative;
            overflow: hidden;
        }

        .background-circle {
            position: absolute;
            width: 500px;
            height: 500px;
            top:-60%;
            left: -160%;
            background: radial-gradient(circle, rgba(201, 41, 128, 0.3), rgba(247, 130, 52, 0.3), rgba(172, 30, 163, 0.3));
            border-radius: 50%;
            filter: blur(30px);
            z-index: 1;

        }

        .container-sign-up {
            position: relative;
            width: 456px;
            background:rgb(233, 238, 243);
            border-radius: 10px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            box-sizing: border-box;
            z-index: 2;
        }

        #titleInscription {
            text-align: center;
            background-image: radial-gradient(circle at 60% 40%, rgb(201, 41, 128), rgb(247, 130, 52), rgb(172, 30, 163));
            color: transparent;
            -webkit-background-clip: text;
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 10px;
            margin-top: -5%;
        }
        input {
            border: 2px solid rgb(247, 130, 52);
            border-radius: 5px;
            font-size: 16px;
        }
        .required {
            color: red;
        }

        .required-signup {
            margin-top: -10px;
            margin-bottom: 15px;
            font-size: 0.9em;
        }

        .button {
            width: 100%;
            margin-top: 10px;
            font-weight: bold;
        }

        .button input, .button button {
            font-weight: bold;
            font-size : 15px;
            width: 100%;
            padding: 10px;
            background-color: rgb(247, 130, 52);
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-control {
            margin-bottom: 5%;
        }
        .button input:hover, .button button:hover {
            background-color:rgb(201, 41, 128);
        }

        .eye-span {
            position: relative;
            float: right;
            margin-top: -30px;
            margin-right: 10px;
            cursor: pointer;
        }
</style>
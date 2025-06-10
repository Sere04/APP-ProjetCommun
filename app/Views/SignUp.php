<div class="container container-sign-up">
    <div class="sign-up">
        <div class="background-circle"></div>
        <h1 style="color:rgb(172,30,163)">Inscription</h1>
        <p class="required required-signup">*Ces champs sont obligatoires</p>

        <?php if (!empty($errors)) : ?>

        <?php foreach ($errors as $error): ?>

        <div class="wrong-signup">
            <?= $error ?> <br/>
        </div>

        <?php endforeach; ?>

        <?php endif; ?>

        <form action="" class="form sign-up-form" method="post" id="myForm">

            <div class="form-row">
                <!-- first-name --->
                <div class="form-control">
                    <label for="fName">Prénom<span class="required">*</span></label>
                    <input type="text" id="fName" maxlength="50" placeholder="Votre prénom..." name="prenom" required>
                </div>
                <!-- last-name --->
                <div class="form-control">
                    <label for="lName">Nom de famille<span class="required">*</span></label>
                    <input type="text" id="lName" maxlength="50" placeholder="Votre nom..." name="nom" required>
                </div>
            </div>
            <!-- username --->
            <div class="form-control">
                <label for="username">Pseudonyme<span class="required">*</span></label>
                <input type="text" id="username" maxlength="30" placeholder="Votre pseudonyme..." name="pseudonyme" required>
            </div>
            <!-- email --->
            <div class="form-control">
                <label for="email">Email<span class="required">*</span></label>
                <input id="email" maxlength="255" placeholder="Votre email..." required type="email" name="email">
                <div id="emailError" class="wrong-signup" style="display: none;"></div>  <!-- AJOUTE APRES-->
            </div>
            <!-- tel --->
            <div class="form-control">
                <label for="tel">Téléphone</label>
                <input type="text" id="tel" maxlength="13" placeholder="+33 6 12 34 56 78" name="telephone">
            </div>
            <!-- password --->
            <div class="form-control">
                <label for="password" id="passwordLabel">Mot de passe<span class="required">* </span><i class="fa-solid fa-circle-question" id="passwordInfo"></i></label>
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
                <label for="password" id="passwordLabelConfirmation">Confirmez le mot de passe<span class="required">* </span></label>
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
        </form>

        <div class="button go-login-button">
            <button class="button go-to-login-button" onclick="window.location.href = 'SignUpModele.php';">Se connecter</button>
        </div>
    </div>
</div>
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
    top: 10%;
    left: 5%;
    width: 300px;
    height: 300px;
    transform: translate(-50%, -50%);
    background: radial-gradient(circle at 60% 40%, rgb(201,41,128), rgb(247,130,52), rgb(172,30,163));
    border-radius: 50%;
    z-index: 1;
    filter: blur(8px);
}

.container-sign-up {
    display: flex;
    align-items: center;
    justify-content: center;
    }
input {
border: 1px solid red;
    border-radius: 5px;
    padding: 10px;
    box-sizing: border-box;
}
.form-control {
    padding: 4%;
}
</style>
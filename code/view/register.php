<?php
$title = "Forum";
include "html-header.php";
include "menu.php";
?>
<body>
    <main>
        <div class="section-box">
            <div class="section-content">

                <form class="login-form"  method="POST" action="<?= BASE_URL . "register" ?>">
                    <div class="login-form-text">Registracija</div>

                    <span class="error"><?= isset($general_error) ? $general_error : "" ?></span>

                    <label>
                        <span class="label">E-mail: </span>
                        <input type="email" name="email" value="" maxlength="50" required/>
                        <span class="error"><?= isset($email_error) ? $email_error : "" ?></span>
                    </label>

                    <label>
                        <span class="label">Uporabniško ime: </span>
                        <input type="text" name="username" value="" maxlength="50" required/>
                        <span class="error"><?= isset($username_error) ? $username_error : "" ?></span>
                    </label>

                    <label>
                        <span class="label">Geslo: </span>
                        <input type="password" name="password" value="" minlength="8" maxlength="64" required/>
                        <span class="error"><?= isset($password_error) ? $password_error : "" ?></span>
                    </label>

                    <label>
                        <span class="label">Potrdi geslo: </span>
                        <input type="password" name="confirm_password" value="" minlength="8" maxlength="64" required/>
                        <span class="error"><?= isset($confirm_password_error) ? $confirm_password_error : "" ?></span>
                    </label>

                    <input type="submit" name="register" value="Registriraj se" />

                </form>
            </div>
        </div>
    </main>
</body>
<?php
$title = "Forum";
include "html-header.php";
include "menu.php";
?>
<body>
    <main>
        <div class="section-box">
            <div class="section-content">

                <form class="login-form" method="POST" action="<?= BASE_URL . "login" ?>">
                    <div class="login-form-text">Prijava</div>

                    <span class="error"><?= isset($general_error) ? $general_error : "" ?></span>

                    <label>
                        <span class="label">E-mail ali uporabniško ime: </span>
                        <input type="text" name="username" value="<?= isset($_POST["username"]) ? $_POST["username"] : ""; ?>" />

                    </label>

                    <label>
                        <span class="label">Geslo: </span>
                        <input type="password" name="password" value="" />
                    </label>

                    <input type="submit" name="login" value="Login" />

                    <a style="margin-top: 10px; text-decoration: underline" href="<?= BASE_URL . "register" ?>">Registriraj se tukaj!</a>
                </form>
            </div>
        </div>
    </main>
</body>
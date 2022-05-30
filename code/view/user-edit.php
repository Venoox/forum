<?php
$title = "Forum";
include "html-header.php";
include "menu.php";
?>
<body>
    <main>
        <form action="<?= BASE_URL . "user/edit" ?>" method="post">
        <div class="main-toolbox">
            <div><?= $errors != null && isset($errors["general_error"]) ? $errors["general_error"] : "" ?></div>
            <input type="submit" name="edit" value="Shrani" />
        </div>

        <div class="main-header">
            <div class="user-column">Uporabnikov profil</div>
        </div>

        <div class="section-box">
            <div class="section-content">
                <div class="user-profile">
                    <div class="user-profile-edit-container">
                        <div class="user-profile-info">
                            <img class="user-profile-img" width="100px" src="<?= explode("index.php", BASE_URL)[0] . $user["profile_picture"] ?>"  alt="Profile picture"/>
                            <div class="user-info">
                                <a class="user-name" href="<?= BASE_URL . "user?id=" . $user["id"] ?>"><?= $user["username"] ?></a>
                                <div class="user-role">Tip: <?= $user["role"] ?></div>
                            </div>
                        </div>
                        <div class="user-profile-edit">
                            <div>
                                <label>
                                    Klikni na gumb, da naložiš sliko<br />
                                    <input type="file" name="profile_picture" accept="image/*"/>
                                </label>
                                <div><?= $errors != null && isset($errors["file_error"]) ? $errors["file_error"] : "" ?></div>
                            </div>
                            <div>
                                <label>Novo geslo: <input type="password" name="password" minlength="8" maxlength="64" /></label>
                                <div><?= $errors != null && isset($errors["password_error"]) ? $errors["password_error"] : "" ?></div>
                            </div>
                            <div>
                                <label>Potrdi novo geslo: <input type="password" name="confirm_password" minlength="8" maxlength="64" /></label>
                                <div><?= $errors != null && isset($errors["confirm_password_error"]) ? $errors["confirm_password_error"] : "" ?></div>
                            </div>
                            <div>
                                <label>Email: <input type="email" name="email" value="<?= $user["email"] ?>" required/></label>
                                <div><?= $errors != null && isset($errors["email_error"]) ? $errors["email_error"] : "" ?></div>
                            </div>
                            <div>
                                <label>Država:
                                    <select name="country" required>
                                        <?php foreach ($countries as $country): ?>
                                            <option value="<?= $country["id"] ?>" <?= $user["country"] == $country["id"] ? "selected" : "" ?>><?= $country["name"] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </label>
                                <div><?= $errors != null && isset($errors["country_error"]) ? $errors["country_error"] : "" ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="user-profile-bio-thread-container">
                        <div class="user-profile-bio">
                            <div>Bio:</div>
                            <textarea class="user-profile-bio-textarea" name="bio"><?= $user["bio"] ?></textarea>
                            <div><?= $errors != null && isset($errors["bio_error"]) ? $errors["bio_error"] : "" ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </main>
</body>

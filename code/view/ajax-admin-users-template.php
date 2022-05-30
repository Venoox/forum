<?php foreach ($users as $user): ?>
    <div class="user" data-id="<?= $user["id"] ?>">
        <div class="admin-user-column">
            <img class="admin-user-img" src="<?= explode("index.php", BASE_URL)[0] . $user["profile_picture"] ?>" />
            <div class="user-info">
                <a class="user-name" href="<?= BASE_URL . "user?id=" . $user["id"] ?>"><?= $user["username"] ?></a>
                <div class="user-role"><?= $user["role"] ?></div>
            </div>
        </div>
        <div class="admin-promote-column">
            <div class="admin-promote-column-text">Nastavi tip uporabnika</div>
            <select name="promote_role">
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role["id"] ?>" <?= $user["role"] == $role["role"] ? "selected" : "" ?>><?= $role["role"] ?></option>
                <?php endforeach; ?>
            </select>
            <button name="promote_button" data-id="<?= $user["id"] ?>">Nastavi</button>
        </div>
        <div class="admin-delete-column">
            <button name="delete_button" data-id="<?= $user["id"] ?>">Izbriši</button>
        </div>
    </div>
<?php endforeach; ?>
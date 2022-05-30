<?php
$title = "Forum";
include "html-header.php";
include "menu.php";
?>
<body>
    <main>
        <div class="admin-panel-menu">
            <a href="<?= BASE_URL . "admin/users" ?>" class="admin-panel-menu-item admin-panel-menu-item-active">Uporabniki</a>
            <a href="<?= BASE_URL . "admin/categories" ?>" class="admin-panel-menu-item">Kategorije</a>
        </div>
        <div class="search">
            <label>Išči: <input type="text" id="search" /></label>
        </div>
        <div class="main-header">
            <div class="admin-user-column">Uporabnik</div>
            <div class="admin-promote-column">Nastavi tip uporabnika</div>
            <div class="admin-delete-column">Izbriši račun</div>
        </div>

        <div class="section-box">
            <div class="section-content">
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
            </div>
        </div>
    </main>
</body>
<script>
    const search = document.getElementById("search");
    search.addEventListener("keyup", function() {
        const value = search.value.toLowerCase();
        fetch("<?= BASE_URL . "admin/users" ?>?search_term=" + value)
            .then(response => response.text())
            .then(data => {
                document.querySelector(".section-content").innerHTML = data;
                document.querySelectorAll("button[name=promote_button]").forEach(button => {
                    button.addEventListener("click", promote);
                });
                document.querySelectorAll("button[name=delete_button]").forEach(button => {
                    button.addEventListener("click", deleteAccount);
                });
            });
    });
    function promote() {
        const id = this.getAttribute("data-id");
        const role = this.parentElement.querySelector("select").value;
        const roleName = this.parentElement.querySelector("select").options[this.parentElement.querySelector("select").selectedIndex].text;
        fetch("<?= BASE_URL . "admin/user/promote" ?>", {
            method: "POST",
            body: new URLSearchParams({
                id: id,
                role: role
            })
        })
            .then(response => response.text())
            .then(data => {
                if (data === "success") {
                    document.querySelector(".user[data-id='" + id + "']").querySelector(".user-role").innerText = roleName;
                }
            });
    }
    function deleteAccount() {
        const id = this.getAttribute("data-id");
        fetch("<?= BASE_URL . "admin/user/delete" ?>", {
            method: "POST",
            body: new URLSearchParams({
                id: id
            })
        })
            .then(response => response.text())
            .then(data => {
                if (data === "success") {
                    document.querySelector(".user[data-id='" + id + "']").remove();
                }
            });}
    document.querySelectorAll("button[name=promote_button]").forEach(button => {
        button.addEventListener("click", promote);
    });
    document.querySelectorAll("button[name=delete_button]").forEach(button => {
        button.addEventListener("click", deleteAccount);
    });
</script>
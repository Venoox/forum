<?php
$title = "Forum";
include "html-header.php";
include "menu.php";
?>
<body>
    <main>
        <div class="search">
            <label>Išči: <input id="search" type="text"/></label>
        </div>
        <div class="main-header users">
            <div class="user-column">Uporabnik</div>
            <div class="created-column">Račun ustvarjen</div>
            <div class="thread-count-column">Število tem</div>
            <div class="post-count-column">Število sporočil</div>
            <div class="last-online-column">Nazadnje online</div>
            <div class="country-column">Država</div>
        </div>

        <div class="section-box">
            <div class="section-content">
                <?php foreach ($users as $user): ?>
                <div class="user">
                    <div class="user-column">
                        <img width="50px" src="<?= explode("index.php", BASE_URL)[0] . $user["profile_picture"] ?>" />
                        <div class="user-info">
                            <a class="user-name" href="<?= BASE_URL . "user?id=" . $user["id"] ?>"><?= $user["username"] ?></a>
                            <div class="user-role"><?= $user["role"] ?></div>
                        </div>
                    </div>
                    <div class="created-column">
                        <?= $user["joined_at"] ?>
                    </div>
                    <div class="thread-count-column">
                        <?= $user["thread_count"] ?>
                    </div>
                    <div class="post-count-column">
                        <?= $user["post_count"] ?>
                    </div>
                    <div class="last-online-column">
                        <?= $user["last_active"] ?>
                    </div>
                    <div class="country-column">
                        <?= $user["country_name"] ?>
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
        fetch("<?= BASE_URL . "users" ?>?search_term=" + value)
            .then(response => response.text())
            .then(data => {
                document.querySelector(".section-content").innerHTML = data;
            });
    });
</script>

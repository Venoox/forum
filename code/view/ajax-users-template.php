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
            <?= $user["country"] ?>
        </div>
    </div>
<?php endforeach; ?>
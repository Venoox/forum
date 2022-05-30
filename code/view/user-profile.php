<?php
$title = "Forum";
include "html-header.php";
include "menu.php";
?>
<body>
    <main>
        <div class="main-toolbox">
            <?php if ($_SESSION && $_SESSION["id"] == $user["id"]): ?>
            <a href="<?= BASE_URL . "user/edit" ?>" class="button">Uredi profil</a>
            <?php endif; ?>
        </div>

        <div class="main-header users">
            <div class="user-column">Uporabnikov profil</div>
        </div>

        <div class="section-box">
            <div class="section-content">
                <div class="user-profile">
                    <div class="user-profile-info-container">
                        <div class="user-profile-info">
                            <img class="user-profile-img" width="100px" src="<?= explode("index.php", BASE_URL)[0] . $user["profile_picture"] ?>" />
                            <div class="user-info">
                                <a class="user-name" href="<?= BASE_URL . "user?id=" . $user["id"] ?>"><?= $user["username"] ?></a>
                                <div class="user-role">Tip: <?= $user["role"] ?></div>
                                <div class="user-role">Država: <?= $user["country_name"] ?></div>
                                <div class="user-role">Email: <?= $user["email"] ?></div>
                            </div>
                        </div>
                        <div class="user-profile-activity">
                            <div>Prva prijava: <?= $user["joined_at"] ?></div>
                            <div>Nazadnje aktiven: <?= $user["last_active"] ?></div>
                            <div>Število sporočil: <?= $user["post_count"] ?></div>
                            <div>Število tem: <?= $user["thread_count"] ?></div>
                        </div>
                    </div>
                    <div class="user-profile-bio-thread-container">
                        <div class="user-profile-bio">
                            <div>Bio:</div>
                            <div class="user-profile-bio-content">
                                <?= $user["bio"] ?>
                            </div>
                        </div>
                        <div class="user-profile-threads">
                            <div>Teme:</div>
                            <div class="user-profile-threads-content">
                                <?php foreach ($threads as $thread): ?>
                                <div class="user-profile-thread">
                                    <div class="thread-title">
                                        <a href="<?= BASE_URL . "forum/thread?id=" . $thread["id"] ?>">
                                            <?= $thread["title"] ?>
                                        </a>
                                    </div>
                                    <div class="thread-author">
                                        <span>
                                        <?= $thread["lastPost"]["username"]  ?>
                                        </span>
                                    </div>
                                    <div class="thread-last-message">
                                        Zadnje sporočilo: <?= $thread["lastPost"]["created_timestamp"]  ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

<?php
$title = "Forum";
include "html-header.php";
include "menu.php";
?>
<body>
    <main>
        <div class="section-box">
            <?php if ($_SESSION != null && ($_SESSION["role"] == "admin" || $_SESSION["role"] == "mod")): ?>
                <div class="main-toolbox">
                    <?php if ($thread["locked"] == 0): ?>
                        <a href="<?= BASE_URL . "forum/lock-thread?id=" . $thread["id"] ?>" class="button">Zakleni temo</a>
                    <?php else: ?>
                        <a href="<?= BASE_URL . "forum/unlock-thread?id=" . $thread["id"] ?>" class="button">Odkleni temo</a>
                    <?php endif; ?>
                    <a href="<?= BASE_URL . "forum/delete-thread?id=" . $thread["id"] ?>" class="button">Izbriši temo</a>
                </div>
            <?php endif; ?>

            <div class="section-title">
                <?= $category["title"] ?> > <?= $subcategory["title"] ?> > <?= $thread["title"] ?>
            </div>

            <div class="section-content">
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <div class="post-info">
                            <div class="author-image">
                                <img width="60px" src="<?= explode("index.php", BASE_URL)[0] . $post["author"]["profile_picture"] ?>" />
                            </div>
                            <div class="post-user">
                                <div class="post-role">
                                    <?= $post["author"]["role"]?>
                                </div>
                                <div class="post-author">
                                    <?= $post["author"]["username"] ?>
                                </div>
                                <div class="post-timestamp">
                                    <?= $post["created_timestamp"] ?>
                                </div>
                            </div>
                        </div>
                        <div class="post-content">
                            <div class="post-timestamp-desktop"><?= $post["created_timestamp"] ?></div>
                            <?= $post["content"] ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($_SESSION != null && $thread["locked"] == 0): ?>
            <div class="new-post">
                <div class="new-post-title">
                    Nova sporočilo
                </div>
                <form action="<?= BASE_URL . "forum/thread?id=" . $thread["id"] ?>" method="post">
                    <label style="margin-bottom: 10px;">
                        <textarea required minlength="10" style="min-height: 100px; width: 100%;" name="content" placeholder="Tukaj napiši svoje sporočilo..."></textarea>
                    </label>
                    <div><?= isset($errors["post_error"]) ? $errors["post_error"] : "" ?></div>
                    <input type="submit" name="post" value="Objavi" />
                </form>
            </div>
            <?php endif; ?>
        </div>
    </main>

</body>

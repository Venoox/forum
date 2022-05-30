<?php
$title = "Forum";
include "html-header.php";
include "menu.php";
?>
<body>
    <main>
        <?php if ($_SESSION != null): ?>
        <div class="main-toolbox">
            <a href="<?= BASE_URL . "forum/new-thread?category=" . $subcategory["id"] ?>" class="button">Nova tema</a>
        </div>
        <?php endif; ?>

        <div class="main-header">
            <div class="category-title-column">Teme</div>
            <div class="category-posts-column">Sporočila</div>
            <div class="category-last-message-column">Zadnje sporočilo</div>
        </div>

        <div class="section-box">

            <div class="section-title">
                <?= $category["title"] ?> > <?= $subcategory["title"] ?>
            </div>
            <div class="section-content">
                 <?php foreach($threads as $thread): ?>
                <div class="thread">
                    <div class="thread-title-column">
                        <div class="thread-title">
                            <a href="<?= BASE_URL . "forum/thread?id=" . $thread["id"] ?>">
                                <?= $thread["title"] ?>
                            </a>
                        </div>
                        <div class="thread-author">
                            <span>
                               <?= $thread["author"]["username"] ?>
                            </span>
                        </div>
                    </div>
                    <div class="thread-posts-column">
                        <?= $thread["postCount"] ?>
                    </div>
                    <div class="thread-last-message-column">
                        <?php if ($thread["lastPost"] != null): ?>
                        <a class="post-author" href="<?= BASE_URL . "user?id=" . $thread["lastPost"]["user"] ?>">
                            <?= $thread["lastPost"]["username"] ?>
                        </a>
                        <div class="last-post-timestamp">
                            <?= $thread["lastPost"]["created_timestamp"] ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

</body>

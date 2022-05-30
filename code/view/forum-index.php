<?php
$title = "Forum";
include "html-header.php";
include "menu.php";
?>
<body>
    <main>
        <div class="main-header">
            <div class="category-title-column">Kategorija</div>
            <div class="category-threads-column">Teme</div>
            <div class="category-posts-column">Sporočila</div>
            <div class="category-last-message-column">Zadnje sporočilo</div>
        </div>

        <div class="section-box">
            <?php foreach($categories as $category): ?>
            <div class="section-title">
                <?= $category["title"] ?>
            </div>
            <div class="section-content">
                <?php foreach($category["subCategories"] as $subCategory): ?>
                <div class="category">
                    <div class="category-title-column">
                        <div class="category-title">
                            <a href="<?= BASE_URL . "forum/category?id=" . $subCategory["id"] ?>">
                                <?= $subCategory["title"] ?>
                            </a>
                        </div>
                        <div class="category-description">
                            <span>
                                <?= $subCategory["description"] ?>
                            </span>
                        </div>
                    </div>
                    <div class="category-threads-column">
                        <?= $subCategory["threadCount"] ?>
                    </div>
                    <div class="category-posts-column">
                        <?= $subCategory["postCount"] ?>
                    </div>
                    <div class="category-last-message-column">
                        <?php if($subCategory["lastPost"] != null): ?>
                        <a class="post-title" href="<?= BASE_URL . "forum?thread=" . $subCategory["lastPost"]["thread"] ?>">
                            <?= $subCategory["lastPost"]["title"] ?>
                        </a>
                        <a class="post-author" href="<?= BASE_URL . "user?id=" . $subCategory["lastPost"]["user"] ?>">
                            <?= $subCategory["lastPost"]["username"] ?>
                        </a>
                        <div class="last-post-timestamp">
                            <?= $subCategory["lastPost"]["created_timestamp"] ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

</body>

<?php
$title = "Forum";
include "html-header.php";
include "menu.php";
?>
<body>
    <main>
        <div class="main-header">
            <div class="new-thread-column">Nova tema</div>
        </div>

        <div class="section-box">
            <div class="section-content">
                <div class="new-thread">
                    <form action="<?= BASE_URL . "forum/new-thread" ?>" method="post">
                        <div class="new-thread-label">Naslov:</div>
                        <input class="new-thread-input" type="text" name="title" required minlength="5" maxlength="100" />
                        <div class="new-thread-label">Sporočilo</div>
                        <textarea class="new-thread-textarea" minlength="10" maxlength="1000" name="content" required></textarea>
                        <input type="hidden" name="category" value="<?= isset($_GET["category"]) ? $_GET["category"] : $_POST["category"] ?>" />
                        <input type="submit" name="new-thread" value="Objavi" />
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

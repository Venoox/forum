<?php
$links = [
    [
        ["name" => "Forum", "url" => BASE_URL . "forum", "show" => true],
        ["name" => "Uporabniki", "url" => BASE_URL . "users", "show" => true],
    ],
    [
        ["name" => "Admin", "url" => BASE_URL . "admin", "show" => $_SESSION != null && $_SESSION['role'] == "admin"],
        ["name" => "Račun", "url" => BASE_URL . "user?id=" . $_SESSION["id"], "show" => $_SESSION != null && isset($_SESSION['login'])],
        ["name" => "Prijava", "url" => BASE_URL . "login", "show" => !isset($_SESSION['login'])],
        ["name" => "Odjava", "url" => BASE_URL . "logout", "show" => isset($_SESSION['login'])],
    ]
];
$actual_url = explode("?", $_SERVER["REQUEST_URI"])[0];
?>
<header class="menu">
    <div>
        <?php foreach ($links[0] as $link): ?>
            <?php if ($link["show"]): ?>
                <a class="link <?= $actual_url == $link["url"] ? "link-active" : "" ?>" href="<?= $link["url"] ?>">
                    <?= $link["name"] ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div>
        <?php foreach ($links[1] as $link): ?>
            <?php if ($link["show"]): ?>
                <a class="link <?= $actual_url == $link["url"] ? "link-active" : "" ?>" href="<?= $link["url"] ?>">
                    <?= $link["name"] ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</header>
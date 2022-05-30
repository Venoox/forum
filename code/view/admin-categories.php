<?php
$title = "Forum";
include "html-header.php";
include "menu.php";
?>
<body>
    <main>
        <div class="admin-panel-menu">
            <a href="<?= BASE_URL . "admin/users" ?>" class="admin-panel-menu-item">Uporabniki</a>
            <a href="<?= BASE_URL . "admin/categories" ?>" class="admin-panel-menu-item admin-panel-menu-item-active">Kategorije</a>
        </div>

        <div class="main-header">
            <div class="admin-category-column">Kategorije</div>
        </div>

        <div class="section-box">
            <div class="section-content">
                <div class="category-list">
                    <ul>
                    <?php foreach ($categories as $category): ?>
                        <li><span><?= $category["title"] ?></span><button name="remove" data-id="<?= $category["id"] ?>">x</button></li>
                        <ul data-parent-id="<?= $category["id"] ?>">
                        <?php foreach ($category["subCategories"] as $subCategory): ?>
                            <li><span><?= $subCategory["title"] ?></span><button name="remove" data-id="<?= $subCategory["id"] ?>">x</button></li>
                        <?php endforeach; ?>
                            <li><span><input type="text" /></span><button name="add" data-parent-id="<?= $category["id"] ?>">Add</button></li>
                        </ul>
                    <?php endforeach; ?>
                        <li><span><input type="text" /></span><button name="add" data-parent-id="8">Add</button></li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</body>
<script>
    function add() {
        const parent_category = this.getAttribute("data-parent-id");
        const title = this.parentNode.querySelector("input").value;
        fetch("<?= BASE_URL . "admin/categories/add" ?>", {
            method: "POST",
            body: new URLSearchParams({
                title,
                parent_category
            })
        })
            .then(response => response.text())
            .then(response => {
                if (response === "error") {
                    return;
                }
                this.parentNode.querySelector("input").value = "";
                const li = document.createElement("li");
                li.innerHTML = `<span>${title}</span><button name="remove" data-id="${response}">x</button>`;
                li.querySelector("button").addEventListener("click", remove);
                this.parentNode.parentNode.insertBefore(li, this.parentNode);
                if (parent_category == 8) {
                    const ul = document.createElement("ul");
                    ul.setAttribute("data-parent-id", response);
                    ul.innerHTML = `<li><span><input type="text" /></span><button name="add" data-parent-id="${response}">Add</button></li>`;
                    ul.querySelector("button").addEventListener("click", add);
                    this.parentNode.parentNode.insertBefore(ul, this.parentNode);
                }
            });
    }
    function remove() {
        const id = this.getAttribute("data-id");
        fetch("<?= BASE_URL . "admin/categories/remove" ?>", {
            method: "POST",
            body: new URLSearchParams({
                id
            })
        })
            .then(response => response.text())
            .then(response => {
                if (response === "error") {
                    return;
                }
                const subCategories = document.querySelector(`ul[data-parent-id="${id}"]`);
                if (subCategories) {
                    subCategories.remove()
                }
                this.parentNode.remove();
            });
    }
    document.querySelectorAll("button[name=add]").forEach(button => button.addEventListener("click", add));
    document.querySelectorAll("button[name=remove]").forEach(button => button.addEventListener("click", remove));
</script>

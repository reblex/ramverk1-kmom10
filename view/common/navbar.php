<?php
$navItems = [
        "home" => [
            "title" => "Home",
            "route" => ""
        ],
        "posts" => [
            "title" => "Posts",
            "route" => "posts"
        ],
        "tags" => [
            "title" => "Tags",
            "route" => "tags"
        ],
        "about" => [
            "title" => "About",
            "route" => "about"
        ],
];
?>

<div class="container">

<div class="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?= $this->di->get("url")->create("") ?>">Discuss</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="containerNavbar">
            <ul class="navbar-nav mr-auto">
            <?php foreach($navItems as $item): ?>
            <li class="nav-item">
                <a class="nav-link <?= $this->di->get("request")->getRoute() == $item["route"] ? "active" : "" ?>" href="<?= $this->di->get("url")->create($item["route"]) ?>"><?= $item["title"] ?></a>
            </li>
            <?php endforeach; ?>
            </ul>
            <ul class="navbar-nav navbar-right">
                <li><a class="nav-orange nav-link <?= $this->di->get("request")->getRoute() == $item["route"] ? "active" : "" ?>" href="<?= $this->di->get("url")->create("user")?>">User</a></li>
            </ul>
        </div>
    </nav>
</div>

<br><br><br>

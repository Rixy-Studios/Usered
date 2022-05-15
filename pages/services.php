<?php
require_once "./utils/database.php";
require_once "./database/user.php";
require_once "./utils/utils.php";
require_once "./database/app.php";
require_once "./database/dm.php";
$dmClass = new Dm;
$dbClass = new Database;
$dbClass->init_session();
$conn =  $dbClass->connect();
$userClass = new User;
$utilsClass = new Utils;
$appClass = new App;
require_once "./database/ban.php";
$banClass = new Ban;
//metadata needed for header
$useneko = false;
$title = "Link";
require_once "elements/header.php";
$apps = $appClass->getAllApps($conn);
?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">Services list</h1>
            <?php
            foreach($apps as $app){ ?>
            <h2 class="bluetext"><a href="/link?appid=<?= $app['appid'] ?>"><?= $app['name'] ?></a></h2>
            <p><?= $app['description'] ?></p>
            <?php } ?>
        </div>
    </div>
</div>
<?php
require_once "elements/footer.php";
?>
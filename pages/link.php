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
$app = $appClass->getAppFromID($conn, $_GET['appid']);
if(!$app){
    header("Location: /");
}
?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">Link</h1>
            <h2 class="bluetext"><?= $app['name'] ?></h2>
            <p><?= $app['description'] ?></p>
            <i><b class="redtext">By clicking authorize & redirect, you accept that a part of your user data is shared with <?= $app['name'] ?> and (possibly) its thirdparties.</b></i>
            <br>
            <br>
            <form method="post">
                <input type="submit" class="g-button g-button-share" name="submit" value="Authorize & redirect">
            </form>
            <?php
            if(isset($_POST['submit'])){
                $token = $appClass->createAppToken($conn, $utilsClass, $user['id']);
                header("Location: ".$app['redirecturl']."?userToken=".$token);
                exit;
            }
            ?>
        </div>
    </div>
</div>
<?php
require_once "elements/footer.php";
?>
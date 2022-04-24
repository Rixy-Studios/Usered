<?php
require_once "./utils/database.php";
require_once "./database/user.php";
require_once "./database/ban.php";
$dbClass = new Database;
$dbClass->init_session();
$conn =  $dbClass->connect();
$userClass = new User;
$banClass = new Ban;
//metadata needed for header
$title = "404";
require_once "elements/header.php";
?>
<div class="main content clearfix">
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">Oh no!</h1>
            <h2 class="redtext">Grr... It seems like you got lost. >:3</h2>
            <br>
            <a href="/">Let's (hopefully) get back home.</a>
        </div>
    </div>
</div>
<?php
require_once "elements/footer.php";
?>
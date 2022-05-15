<?php
require_once "./utils/database.php";
require_once "./database/user.php";
require_once "./database/dm.php";
$dmClass = new Dm;
$dbClass = new Database;
$dbClass->init_session();
$conn =  $dbClass->connect();
$userClass = new User;
require_once "./database/ban.php";
$banClass = new Ban;
//metadata needed for header
$title = "Terms Of Service";
require_once "elements/header.php";
?>
<div class="main content clearfix">
    <div class="product-info oz">
        <div class="product-headers">
            <i>Last updated: 23/04/2022</i>
            <br>
            <br>
            <br>
            <h1 class="bluetext">Terms Of Service</h1>
            <br>
            <p>To ensure this to be a safe & cool place, we made some rules. Let's go ahead.</p>
            <h2 class="bluetext">About NSFW and so on</h2>
            <strong>This is stricly forbidden and will result in a permanent ban from Riiset & Usered.</strong>
            <h2 class="bluetext">Doxxing, harassing, insulting, embarrasing someone</h2>
            <strong>This is stricly forbidden and will result in a permanent ban from Riiset & Usered.</strong>
            <h2 class="bluetext">Make publicity about your discord server, your miiverse clone, etc</h2>
            <p>You must <strong>contact an admin</strong> before doing so.</p>
            <br>
            <p>Don't doing this will result in a warn + deletion of the message, but if repeated, will result in a permanent/temporary ban from Usered (only).</p>
            <h1 class="bluetext">That's all!</h1>
            <p>...for now. Don't forget to check this regularly, to not get banned/warned stupidly.</p>
        </div>
    </div>
</div>
<?php
require_once "elements/footer.php";
?>
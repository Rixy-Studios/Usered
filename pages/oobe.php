<?php
require_once "./utils/database.php";
require_once "./database/user.php";
$dbClass = new Database;
$dbClass->init_session();
$conn =  $dbClass->connect();
$userClass = new User;
require_once "./database/ban.php";
$banClass = new Ban;
//metadata needed for header
$useneko = false;
$title = "Welcome!!!";
require_once "elements/header.php"
?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">Hello, <?= $user['username'] ?>!</h1>
            <br>
            <p>...And welcome to Usered! Usered is a social network that everyone can contribute to it.</p>
            <h2 class="bluetext">How to use it?</h2>
            <br>
            <p>First things first, go to your <b>profile</b> and start modifying it! Add your bio, some custom CSS, an url to the website of your choice, your pronouns, etc...</p>
            <br>
            <p>Secondly, you can start following some people to see their latest activity appear in your <b>personal feed</b>!</p>
            <br>
            <p>Thirdly, you can start making some content, and do not worry about 'oh no my content will never be seen, i'm not popular...'; we have a global feed that everyone can consult!</p>
            <br>
            <i class="bluetext"><b>but wait; continue to read this guide... (i didn't wrote this for nothing)</b></i>
            <h2 class="bluetext">Important information</h2>
            <br>
            <p><b>DO NOT FORGET</b> to read the TOS to avoid getting banned/warned stupidly! You can check 'em out <a href="/legal/terms">there</a>.</p>
            <h2 class="bluetext">End</h2>
            <br>
            <p>Thank you for reading this guide!</p>
            <br>
            <p>You are now ready to use Usered...</p>
            <br>
            <br>
            <i>Happy posting & best regards,<br>-Rixy, owner of Usered.</i>
        </div>
    </div>
</div>
<?php
require_once "./elements/footer.php";
?>
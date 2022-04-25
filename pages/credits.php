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
$title = "Credits";
require_once "elements/header.php";
?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">Credits</h1>
            <br>
            <h3 class="bluetext">People</h3>
            <p>These people are actually making Usered!</p>
            <ul>
                <li>-Rixy, <i>original idea & lead developer</i></li>
                <li>-Terminal, <i>developer</i></li>
                <li>-bruhdude, <i>designer & developer</i></li>
            </ul>
            <h3 class="bluetext">Technologies & languages</h3>
            <p>Thank to these, else Usered wouldn't be possible!</p>
            <ul>
                <li>-MySQL</li>
                <li>-PHP</li>
                <li>-(2013)Google+ CSS</li>
            </ul>
            <h3 class="bluetext">Special Thanks</h3>
            <p>This is my special thanks <3</p>
            <ul>
                <li>-<a href="https://noted.webs.nf/">Noted</a>, without this the design of this website would be terrible</li>
            </ul>
        </div>
    </div>
</div>
<?php
require_once "elements/footer.php";
?>

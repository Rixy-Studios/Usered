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
$title = "News";
require_once "elements/header.php";
$useneko = false;
?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">News</h1>
            <p>Here you can check out latest updates of the service.</p>
            <h2 class="bluetext">[latest] Usered 0.21.0</h2>
            <p>-Added administrator status for admins on profiles</p>
            <p>-A few other tweaks & minor bugfixes I liked</p>
            <h2 class="bluetext">Usered 0.20.7</h2>
            <br>
            <p>-You can now add videos & images to a reed!</p>
            <h2 class="bluetext">Usered 0.20.6</h2>
            <br>
            <p>-Bug fixes</p>
            <p>-Improvement: now users can decide in their profile settings if they wanna enable custom css everywhere or not.</p>
            <h2 class="bluetext">Usered 0.20.5</h2>
            <br>
            <p>-Added admin panel</p>
            <p>-Added feedback functionality</p>
            <p>-Added bans functionality</p>
            <p>-Improvement: now users can see a part of the Reed on the Global Feed, the Profile Feed, or the Personal Feed. <i>(suggested by Terminal)</i></p>
            <p>-Much much more admin stuff.</p>
            <h2 class="bluetext">Usered 0.20.0</h2>
            <br>
            <p>-Added following.</p>
            <p>-Added personal feed.</p>
            <p>-Added URL setting in profile settings.</p>
            <p>-Added URL in profiles.</p>
            <p>-Added OOBE for new users.</p>
            <p>-Added recent activities in profiles.</p>
            <p>-Added news (what you're seeing right now!)</p>
            <p>-Added Minecraft (<i>wait what?</i>)</p>
        </div>  
    </div>        
</div>
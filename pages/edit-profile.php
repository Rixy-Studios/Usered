<?php
require_once "./utils/database.php";
require_once "./database/user.php";
require_once "./database/activity.php";
$dbClass = new Database;
$dbClass->init_session();
$conn =  $dbClass->connect();
$userClass = new User;
$actClass = new Activity;
require_once "./database/ban.php";
$banClass = new Ban;
//metadata needed for header
$useneko = true;
$title = "Edit your profile";
require_once "elements/header.php"
?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">Edit your profile</h1>
            <br>
            <p>Want to have the most <b><i>coolio</i></b> profile ever?! THEN THIS IS FOR YOU!</p>
            <form method="post">
                <br>
                <p>Status:</p>
                <input type="text" name="status" placeholder="Status" value="<?= $user['status'] ?>">
                <br>
                <br>
                <p>Bio: (html authorized)</p>
                <textarea  name="bio" placeholder="Bio (HTML AUTHORIZED)"><?= $user['bio'] ?></textarea>
                <br>
                <br>
                <p>Pronouns:</p>
                <input type="text" name="pronouns" placeholder="Pronouns" value="<?= $user['pronouns'] ?>">
                <br>
                <br>
                <p>Avatar URL:</p>
                <input type="text" name="avatarurl" placeholder="Avatar URL" value="<?= $user['avatar_url'] ?>">
                <br>
                <br>
                <p>URL:</p>
                <input type="text" name="url" placeholder="URL" value="<?= $user['url'] ?>">
                <br>
                <br>
                <p>Discord Tag:</p>
                <input type="text" name="discord_tag" placeholder="Discord Tag" value="<?= $user['discord_tag'] ?>">
                <br>
                <br>
                <p>Custom CSS (profile):</p>
                <textarea name="css" placeholder="CSS Code"><?= $user['css'] ?></textarea>
                <br>
                <br>
                <p>Enable custom CSS everywhere</p>
                <input type="hidden" name="c_css_everywhere" value="0">
                <input type="checkbox" name="c_css_everywhere" value="1" <? if($user['c_css_everywhere']==1){ ?>checked<? } ?>>
                <br>
                <br>
                <input class="g-button g-button-submit" type="submit" name="submit" value="Update profile">
            </form>
            <?php
            if(isset($_POST['submit'])){
                $userClass->update($conn, "status", $_POST['status'], $user['id'], true);
                $userClass->update($conn, "bio", $_POST['bio'], $user['id'], false);
                $userClass->update($conn, "pronouns", $_POST['pronouns'], $user['id'], true);
                $userClass->update($conn, "avatar_url", $_POST['avatarurl'], $user['id'], true);
                $userClass->update($conn, "url", $_POST['url'], $user['id'], true);
                $userClass->update($conn, "css", $_POST['css'], $user['id'], false);
                $userClass->update($conn, "discord_tag", $_POST['discord_tag'], $user['id'], true);
                $userClass->update($conn, "c_css_everywhere", $_POST['c_css_everywhere'], $user['id'], true);
                $actClass->addActivity($conn, 1, $user['id'], "/profile/".$user['id'], true);
                echo "<p class='greentext'>Your profile was updated succesfully!</p>";
            }
            ?>
        </div>
    </div>
</div>
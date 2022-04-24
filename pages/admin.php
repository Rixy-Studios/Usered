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
$title = "Admin Panel";
require_once "elements/header.php";
if($user['perms']==0){
    exit(header("Location: /"));
}
?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">Admin Panel</h1>
            <br>
            <p>This is the admin panel, where you can manage some functionalities inside a little nice UI.</p>
            <br>
            <br>
            <a href="/admin/ban">Access ban management</a>
            <br>
            <a href="/admin/feedbacks">Access feedback list</a>
            <br>
            <a href="/admin/feedback_mg">Access feedback management</a>
        </div>
    </div>
</div>
<?php
require_once "elements/footer.php";
?>

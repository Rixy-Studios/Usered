<?php
require_once "./utils/database.php";
require_once "./database/user.php";
require_once "./database/feedback.php";
require_once "./database/dm.php";
$dmClass = new Dm;
$dbClass = new Database;
$dbClass->init_session();
$conn =  $dbClass->connect();
$userClass = new User;
$fbClass = new Feedback;
$feedbacks = $fbClass->getAllFeedbacks($conn);
require_once "./database/ban.php";
$banClass = new Ban;
//metadata needed for header
$useneko = false;
$title = "See all feedbacks";
require_once "elements/header.php";
if($user['perms']==0){
    exit(header("Location: /"));
}
?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">Feedbacks</h1>
            <br>
            <p>Here you can see all of the feedbacks submitted.</p>
            <br>
            <br>
            <?php
            foreach($feedbacks as $feedback){
                $fuser = $userClass->getUserFromID($conn, $feedback['author']);?>
                <br>
                <h1><?= $fuser['username'] ?>'s Feedback</h1>
                <br>
                <h2><?= $feedback['title'] ?></h2>
                <br>
                <p><?= nl2br($feedback['content']); ?></p>
                <br>
                <i>feedback id: <?= $feedback['id'] ?></i>
            <?php } ?>
        </div>
    </div>
</div>
<?php
require_once "elements/footer.php";
?>
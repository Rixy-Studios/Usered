<?php
require_once "./utils/database.php";
require_once "./database/user.php";
require_once "./utils/utils.php";
require_once "./database/dm.php";
require_once "./database/misc.php";
$dbClass = new Database;
$dbClass->init_session();
$conn =  $dbClass->connect();
$userClass = new User;
$miscClass = new Misc;
$dmClass = new Dm;
$utilsClass = new Utils;
require_once "./database/ban.php";
$banClass = new Ban;
//metadata needed for header
$useneko = false;
$_user = $userClass->getUserFromToken($conn, $_SESSION['token']);
$all = $dmClass->getAllConversationsFromSource($conn, $_user['id']);
$title = "Conversation list";
require_once "elements/header.php";
?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">Conversation list</h1>
            <br>
            <?php
            if(!$all){
                echo "<p class='bluetext'>Feels kinda empty here.</p>";
            }
            foreach($all as $dm){
                $dmuser = $userClass->getUserFromID($conn, $dm['target']);
                $msg = $dmClass->getLatestMessageFromConversation($conn, $dm['cid']); ?>
                <div class="reminder">
                    <p><a href="/conversation/<?= $dm['cid'] ?>">Conversation between you and <?= $dmuser['username'] ?></a></p>
                    <?php
                    if($msg){
                        $tmstp = $miscClass->getTimestampFromDate($conn, $msg['timestamp']);
                    ?>
                    <small style="color: grey">Last message: <?= $msg['content'] ?></small>
                    <br>
                    <small style="color: grey; "><i><?= $utilsClass->get_time_ago($tmstp); ?></i></small>
                    <?php }else{ ?>
                    <small style="color: grey">Last message: <i>none</i></small>
                    <?php } ?>
                </div>
            <? } ?>
        </div>
    </div>
</div>
<?php
require_once "elements/footer.php";
?>

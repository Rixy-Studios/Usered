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
//oh no, oh no, oh no no no no no.
$_user = $userClass->getUserFromToken($conn, $_SESSION['token']);
$chk = $dmClass->getConversationFromIDAndSource($conn, $id, $_user['id']);
if(!$chk){
    header("Location: /");
}
$cuser = $userClass->getUserFromID($conn, $chk['target']);
$all_source = $dmClass->getDmAsSource($conn, $_user['id'], $chk['cid']);
$all_target = $dmClass->getDmAsTarget($conn, $_user['id'], $chk['cid']);
$all = array_merge($all_source, $all_target);
usort($all, 'Utils::date_compare');
$all = array_reverse($all);
$title = "Conversation with ".$cuser['username'];
require_once "elements/header.php";
?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">Conversation with <?= $cuser['username'] ?></h1>
            <form method="post">
                <textarea type="text" name="dm" placeholder="Your life" class="yt-search-input" style="width: 615px; height: 70px;"></textarea>
                <input type="submit" class="g-button g-button-share" name="submit" value="Post">
                <br><br>
            </form>
            <?php
            if(isset($_POST['submit'])){
                if(!empty($_POST['dm'])){
                    $dmClass->createDm($conn, $user['id'],$cuser['id'],$_POST['dm'],$chk['cid']);
                    echo "<p class='greentext'>You sucessfully send your DM!</p><br><br>";
                }else{
                    echo "<p class='redtext'>Didn't know blank text was necessary...</p><br><br>";
                }
            }
            foreach($all as $dm){
                $dmuser = $userClass->getUserFromID($conn, $dm['source']);
                $tmstp = $miscClass->getTimestampFromDate($conn, $dm['timestamp']);
                if($dm['new']==1 && $dm['target']==$user['id']){
                    $dmClass->removeNotRead($conn, $dm['id']);
                }
                if($dmuser['id']==$user['id']){?>
                <div class="reminder" style="background-color: #fcd158;">
                    <small style="color: grey; "><i>You</i></small>
                    <p style=""><?= $utilsClass->formatText($dm['content'], true); ?></p>
                    <small style="color: grey; "><i><?= $utilsClass->get_time_ago($tmstp); ?></i></small>
                </div>
            <? }else{ ?>
                <div class="reminder">
                    <small style="color: grey; "><i><?= $dmuser['username'] ?></i></small>
                    <p style=""><?= $utilsClass->formatText($dm['content'], true); ?></p>
                    <small style="color: grey; "><i><?= $utilsClass->get_time_ago($tmstp); ?></i></small>
                </div>
            <? } }?>
        </div>
    </div>
</div>
<?php
require_once "elements/footer.php";
?>

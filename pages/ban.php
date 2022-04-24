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
$useneko = false;
$title = "Ban";
require_once "elements/header.php";
if($user['perms']==0){
    exit(header("Location: /"));
}
?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">Ban people</h1>
            <p>ban haha go brrrrr</p>
            <br>
            <i>PS: abusive usage of this functionality will be punished!</i>
            <br>
            <br>
            <form method="post">
                <input type="text" name="user_id" placeholder="User ID">
                <br>
                <br>
                <textarea placeholder="Reason" name="reason"></textarea>
                <br>
                <br>
                <input type="submit" class="g-button g-button-share" name="submit" value="Submit">
            </form>
            <?php
            if(isset($_POST['submit'])){
                if(!empty($_POST['user_id']) && !empty($_POST['reason'])){
                    $banClass->createBan($conn, $_POST['user_id'], $_POST['reason']);
                    echo "<p class='greentext'>You've banned this person. Thank you.</p>";
                }else{
                    echo "<p class='redtext'>It seems like you forgot to fill a field. Please check & try again.</p>";
                }
            }
            ?>
            <br>
            <br>
            <h1 class="bluetext">Unban people</h1>
            <p>unban haha go brrrrr</p>
            <br>
            <i>PS: abusive usage of this functionality will be punished!</i>
            <br>
            <br>
            <form method="post">
                <input type="text" name="user_id" placeholder="User ID">
                <br>
                <br>
                <input type="submit" class="g-button g-button-share" name="submit2" value="Submit">
            </form>
            <?php
            if(isset($_POST['submit2'])){
                if(!empty($_POST['user_id'])){
                    $banClass->deleteBan($conn, $_POST['user_id']);
                    echo "<p class='greentext'>You've unbanned this person. Thank you.</p>";
                }else{
                    echo "<p class='redtext'>It seems like you forgot to fill a field. Please check & try again.</p>";
                }
            }
            ?>
        </div>
    </div>
</div>
<?php
require_once "elements/footer.php";
?>
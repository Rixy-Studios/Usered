<?php
require_once "./utils/database.php";
require_once "./database/user.php";
require_once "./database/ban.php";
require_once "./database/feedback.php";
require_once "./database/dm.php";
$dmClass = new Dm;
$dbClass = new Database;
$dbClass->init_session();
$conn =  $dbClass->connect();
$userClass = new User;
$banClass = new Ban;
$fbClass = new Feedback;
//metadata needed for header
$useneko = false;
$title = "Feedback Management";
require_once "elements/header.php";
if($user['perms']==0){
    exit(header("Location: /"));
}
?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">Remove feedback</h1>
            <p>All said in the title.</p>
            <br>
            <i>PS: abusive usage of this functionality will be punished!</i>
            <br>
            <br>
            <i>other PS: you can get the id of the feedback in the feedback list</i>
            <br>
            <br>
            <form method="post">
                <input type="text" name="fb_id" placeholder="Feedback ID">
                <br>
                <br>
                <input type="submit" class="g-button g-button-share" name="submit" value="Submit">
            </form>
            <?php
            if(isset($_POST['submit'])){
                if(!empty($_POST['fb_id'])){
                    $fbClass->removeFeedback($conn, $_POST['fb_id']);
                    echo "<p class='greentext'>You deleted this feedback.</p>";
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
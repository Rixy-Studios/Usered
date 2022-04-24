<?php
require_once "./utils/database.php";
require_once "./database/user.php";
require_once "./database/feedback.php";
$dbClass = new Database;
$dbClass->init_session();
$conn =  $dbClass->connect();
$userClass = new User;
$fbClass = new Feedback;
require_once "./database/ban.php";
$banClass = new Ban;
//metadata needed for header
$useneko = false;
$title = "Send Feedback";
require_once "elements/header.php";
?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">Send Feedback</h1>
            <p>You have a bug? A feature? Another-thing-that-needs-to-be-modified?</p>
            <br>
            <b>Then you can do this right there.</b>
            <br>
            <br>
            <i>PS: abusive usage of this functionality will be punished!</i>
            <br>
            <br>
            <form method="post">
                <input type="text" name="title" placeholder="Name">
                <br>
                <br>
                <textarea placeholder="Content" name="content"></textarea>
                <br>
                <br>
                <input type="submit" class="g-button g-button-share" name="submit" value="Submit">
            </form>
            <?php
            if(isset($_POST['submit'])){
                if(!empty($_POST['title']) && !empty($_POST['content'])){
                    $fbClass->createFeedback($conn, $_POST['title'], $_POST['content'], $user['id']);
                    echo "<p class='greentext'>Your feedback has been sended succesfully and will be read soon. Thank you.</p>";
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
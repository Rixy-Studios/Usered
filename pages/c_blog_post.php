<?php
require_once "./utils/database.php";
require_once "./database/user.php";
require_once "./database/activity.php";
require_once "./database/blog_post.php";
$dbClass = new Database;
$dbClass->init_session();
$conn =  $dbClass->connect();
$userClass = new User;
$actClass = new Activity;
$bpClass = new BlogPost;
require_once "./database/ban.php";
$banClass = new Ban;
//metadata needed for header
$useneko = false;
$title = "Create a blog post";
require_once "elements/header.php";
?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">Create a blog post</h1>
            <p>You want to create an article about why cats are so cute? Now you can!!</p>
            <form method="post">
                <input type="text" name="title" placeholder="Title">
                <br>
                <br>
                <textarea placeholder="Content (HTML allowed)" name="content"></textarea>
                <br>
                <br>
                <input type="text" name="banner_url" placeholder="Banner URL (not necessary)">
                <br>
                <br>
                <input type="submit" class="g-button g-button-share" name="submit" value="Submit">
            </form>
            <?php
            if(isset($_POST['submit'])){
                if(!empty($_POST['title']) && !empty($_POST['content'])){
                    $blogpost = $bpClass->createBlogPost($conn, $_POST['title'], $_POST['content'], $_POST['banner_url'], $user['id']);
                    $actClass->addActivityWithExtra($conn, 3, $user['id'], "/blog_post/".$blogpost['id'], $blogpost['id']);
                    echo "<p class='greentext'>Your blog post has been created sucessfully!</p>";
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
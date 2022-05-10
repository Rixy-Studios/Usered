<?php
require_once "./utils/database.php";
require_once "./database/user.php";
require_once "./database/activity.php";
require_once "./database/blog_post.php";
require_once "./database/reed.php";
require_once "./database/misc.php";
require_once "./database/follow.php";
require_once "./utils/utils.php";

$dbClass = new Database;
$dbClass->init_session();
$conn =  $dbClass->connect();
$userClass = new User;
$actClass = new Activity;
$reedClass = new Reed;
$miscClass = new Misc;
$utilsClass = new Utils;
$followClass = new Follow;
$bpClass = new BlogPost;
require_once "./database/ban.php";
$banClass = new Ban;
$profile_user = $userClass->getUserFromID($conn, $id);
$if_ban = $banClass->checkBan($conn, $profile_user['id']);
if($if_ban){
    $ban = $banClass->getBan($conn, $profile_user['id']);?>
<head>
    <title>User is banned - Usered</title>
    <!-- <link rel="stylesheet" href="css/yt-framework.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <script src="/js/bootstrap-alert.js"></script>
    <script src="/js/jquery-ui-config.js"></script>
    <script src="/js/dropdown.js"></script>
    <script src="/js/toggle-buttons.js"></script>

    	<!-- Prettify code -->
		<link rel="stylesheet" href="https://google-code-prettify.googlecode.com/svn/trunk/src/prettify.css">
    <script src="https://google-code-prettify.googlecode.com/svn/trunk/src/prettify.js"></script>
    <style>
    	pre.prettyprint, code {
    		border-color:#EBEBEB;
    		border:1px dashed #BBBBBB;
    		border-left:5px solid #EBEBEB;
    	}
    </style>
    <link rel="stylesheet" href="/css/usered-framework.css">
    <link rel="icon" type="image/png" href="/img/fav.png">

</head>
<body>
<div class="google-header-bar">
    <div class="header content clearfix">
      <a href="/"><img class="logo" alt="Usered" src="/img/logo.png" height="50px"></a>
    </div>
</div>
<div class="main content clearfix">
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="redtext">This user have been banned.</h1>
            <br>
            <p class="redtext">This user have been banned from Usered for this reason: <?= $ban['reason'] ?></p>
      </div>
  </div>
</div>
</body>
<?php    exit();
}
$activities = $actClass->getLatestActivitiesFromUser($conn, $profile_user['id']);
$latestReeds = $reedClass->getLatestReedsFromProfile($conn, $profile_user['id']);
$latestPosts = $bpClass->getAllBlogPostFromUserID($conn, $profile_user['id']);
$followers = $followClass->checkFollowsAsTarget($conn, $profile_user['id']);
$following = $followClass->checkFollowsAsSource($conn, $profile_user['id']);
if(!$profile_user){
    exit(require_once "404.php");
}
//metadata needed for header
$useneko = true;
$title = $profile_user['username']."'s profile";
require_once "elements/header.php";
if($profile_user['id'] !== $user['id']){
    $if_following = $followClass->checkIfFollowing($conn, $user['id'], $profile_user['id']);
}
if(empty($profile_user['bio'])){
    $profile_user['bio'] = "none";
}
if(empty($profile_user['url'])){
    $profile_user['url'] = "none";
}
if(empty($profile_user['status'])){
    $profile_user['status'] = "no status yet";
}
if(empty($profile_user['discord_tag'])){
    $profile_user['discord_tag'] = "none";
}
?>
<!-- just for you, people -->
<style>
    <?= $profile_user['css'] ?>
</style>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <img src="<?= $profile_user['avatar_url'] ?>" alt="Profile Picture" class="pfp">
            <br>
            <br>
            <h1 class="bluetext"><?= $profile_user['username'] ?> <? if($user['id']==$profile_user['id']){ ?><a class="g-button g-button-red" href="/edit-profile">EDIT</a><? }else{ ?><form method="post"><input type="submit" name="submit" value="<? echo $if_following ? "UNFOLLOW" : "FOLLOW"; ?>" class="g-button g-button-red"> <? } ?></h1>
            <? if($profile_user['perms']==1){ ?><p class="redtext"><b>This user is an administrator. Contact him if necessary.</b></p><? } ?>
            <?php 
            if(isset($_POST['submit']) && $user['id']!==$profile_user['id']){
                if($if_following){
                   $followClass->removeFollow($conn, $user['id'], $profile_user['id']);
                    echo "<p class='greentext'>You are now unfollowing: ".$profile_user['username']."</p>";
                }else{
                    $followClass->createFollow($conn, $user['id'], $profile_user['id']);
                    echo "<p class='greentext'>You are now following: ".$profile_user['username']."</p>";
                }
            }
            ?>
            <p>"<?= $profile_user['status'] ?>"</p>
            <b>Biography:</b><br><?= nl2br($profile_user['bio']); ?>
            <br>
            <b>Pronouns:</b> <?= $profile_user['pronouns'] ?>
            <br>
            <br>
            <b>URL:</b> <a href="<?= $profile_user['url'] ?>"><?= $profile_user['url'] ?></a>
            <br>
            <br>
            <b>Discord Tag:</b> <?= $profile_user['discord_tag'] ?>
            <br>
            <br>
            <b><?= $following ?></b> following, <b><?= $followers ?></b> followers
            <br>
            <br>
            <? if($user['id']==$profile_user['id']){ ?>
                <form method="post">
                    <textarea name="content" placeholder="Your life" style="height: 25px; width: 158px;"></textarea>
                    <br>
                    <br>
                    <input type="text" name="image_url" placeholder="Image URL (not required)">
                    <br>
                    <br>
                    <input type="text" name="video_url" placeholder="Video URL (not required)">
                    <input class="g-button g-button-share" type="submit" name="submit" value="Reed!">
                </form>
            <? } ?>
            <?php
            if(isset($_POST['submit']) && $user['id']==$profile_user['id']){
                if(!empty($_POST['content'])){
                    $reed = $reedClass->createReed($conn, $_POST['content'], $user['id'], $_POST['image_url'], $_POST['video_url']);
                    $actClass->addActivityWithExtra($conn, 2, $user['id'], "/profile/".$user['id'], $reed['id']);
                    echo "<p class='greentext'>Your reed has been created succesfully!</p>";
                }else{
                    echo "<p class='redtext'>best joke ever: empty post</p>";
                }
            } ?>
            <h2 class="bluetext"><?= $profile_user['username'] ?>'s Reeds</h2>
            <?php
            foreach($latestReeds as $reed){ 
                $tmstp = $miscClass->getTimestampFromDate($conn, $reed['timestamp']);?>
                <div class="reminder" id="reed<?= $reed['id'] ?>">
                    <p><?= $utilsClass->formatText($reed['content'], true); ?></p>
                    <? if(!empty($reed['image_url'])){ ?>
                    <img src="<?= $reed['image_url'] ?>" alt="Linked image" width="500px">
                    <br>
                    <br>
                    <? } ?>
                    <? if(!empty($reed['video_url'])){ ?>
                    <video controls src="<?= $reed['video_url'] ?>" alt="Linked video" width="500px"></video>
                    <br>
                    <br>
                    <? } ?>
                    <small style="color: grey; "><i><?= $utilsClass->get_time_ago($tmstp); ?></i></small>
                </div>
            <?php } ?>
            <h2 class="bluetext"><?= $profile_user['username'] ?>'s Blog Posts</h2>
            <?php
            foreach($latestPosts as $post){
                $blogpost_title = mb_substr($post['title'], 0, 70, 'utf8');
                $tmstp = $miscClass->getTimestampFromDate($conn, $post['date_created']);?>
                <div class="reminder" id="reed<?= $reed['id'] ?>">
                    <a href="/blog_post/<?= $post['id'] ?>"><p>"<?= $blogpost_title ?><? if($post['title']!==$blogpost_title){ echo "..."; } ?>"</p></a>
                    <small style="color: grey; "><i><?= $utilsClass->get_time_ago($tmstp); ?></i></small>
                </div>
            <?php } ?>
            <h2 class="bluetext">Latest activities</h2>
            <?php foreach($activities as $activity){ 
                    $actuser = $actClass->getUserFromActivity($conn, $activity['id']);
                    $tmstp = $miscClass->getTimestampFromDate($conn, $activity['timestamp']);
                    if($activity['type']==1){?>
                    <div class="reminder">
                        <div class="feature-title bluetext">
                            <img src="<?= $actuser['avatar_url'] ?>" height="16"> 
                            Profile update</div>
                            <div> <?= $actuser['username'] ?> updated their <a href="<?= $activity['target'] ?>">profile</a><br>
                                <small style="color: grey; "><i><?= $utilsClass->get_time_ago($tmstp); ?></i></small>
                            </div>
                    </div>
            <?php }elseif($activity['type']==2){ 
                    $reed = $reedClass->getReedFromID($conn, $activity['extra']);
                    $reed_content = mb_substr($reed['content'], 0, 70, 'utf8');?>
                    <div class="reminder">
                        <div class="feature-title bluetext">
                            <img src="<?= $actuser['avatar_url'] ?>" height="16"> 
                            New reed</div>
                            <div> <?= $actuser['username'] ?> created a new <a href="<?= $activity['target'] ?>#reed<?= $activity['extra'] ?>">reed</a><br>
                                <p>"<?= $reed_content ?><? if($reed['content']!==$reed_content){ echo "..."; } ?>"</p>
                                <small style="color: grey; "><i><?= $utilsClass->get_time_ago($tmstp); ?></i></small>
                            </div>
                    </div>
            <?php 
            }elseif($activity['type']==3){ 
                    $blogpost = $bpClass->getBlogPostFromID($conn, $activity['extra']);
                    $blogpost_title = mb_substr($blogpost['title'], 0, 70, 'utf8');?>
                    <div class="reminder">
                        <div class="feature-title bluetext">
                            <img src="<?= $actuser['avatar_url'] ?>" height="16"> 
                            New blog post</div>
                            <div> <?= $actuser['username'] ?> created a new <a href="<?= $activity['target'] ?>">blog post</a><br>
                                <p>"<?= $blogpost_title ?><? if($blogpost['title']!==$blogpost_title){ echo "..."; } ?>"</p>
                                <small style="color: grey; "><i><?= $utilsClass->get_time_ago($tmstp); ?></i></small>
                            </div>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
</div>
<?php
require_once "elements/footer.php";
?>
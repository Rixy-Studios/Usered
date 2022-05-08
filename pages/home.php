<?php
require_once "./utils/database.php";
require_once "./utils/utils.php";
require_once "./database/user.php";
require_once "./database/activity.php";
require_once "./database/misc.php";
require_once "./database/follow.php";
require_once "./database/reed.php";
require_once "./database/blog_post.php";
$dbClass = new Database;
$dbClass->init_session();
$conn =  $dbClass->connect();
$userClass = new User;
$actClass = new Activity;
$miscClass = new Misc;
$utilsClass = new Utils;
$followClass = new Follow;
$reedClass = new Reed;
$bpClass = new BlogPost;
require_once "./database/ban.php";
$banClass = new Ban;
$activities = $actClass->getLatestActivities($conn);
//metadata needed for header
$useneko = true;
$title = "Welcome (back)!";
require_once "elements/header.php";
$follows = $followClass->getAllFollowsFromUser($conn, $user['id']);
$activity_feed = array();
?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="reminder">
            <div class="text-content">
                <div class="feature-title redtext">Important notice</div>
                <div><b>Usered Beta.</b> Yes, the beta is here. 40% of dev means beta, no???</div>
            </div>
        </div>
        <br>
        <br>
        <div class="product-headers">
            <h1 class="bluetext">Welcome (back) to Usered.</h1>
            <p><b>Glad to see ya!</b> The 3 funnies (Term, bruhdude & Rixy) were waiting for you. LET'S START THE PARTYYY!</p>
            <br>
            <p>Usered development progress:</p>
            <br>
            <progress class="yt-progress-bar" value="40" max="100">40%</progress>
            <br>
            <a href="/news">Checkout latest updates</a>
            <br>
            <a href="/feedback">Send feedback</a>
            <?php if(!empty($follows)){ ?>
                <h2 class="bluetext"><b>Personal feed:</b></h2>
                <?php foreach($follows as $follow){
                    $acts = $actClass->getLatestActivitiesFromUser($conn, $follow['target']);
                    $activity_feed = array_merge($activity_feed, $acts);
                } 
                usort($activity_feed, 'Utils::date_compare');
                ?>
                <?php 
                $i = 0;
                foreach(array_reverse($activity_feed) as $activity){ 
                    if($i < 5){
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
                <?php   $i++; }elseif($activity['type']==2){ 
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
                <?php $i++; }elseif($activity['type']==3){ 
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
            <?php $i++;}
            }
            }
            }?>
            <h2 class="bluetext"><b>Recent activity:</b></h2>
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